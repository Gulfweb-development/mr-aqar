<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class SiteMapController extends Controller
{
    public static $hiddenUri = [
        'api',
        'admin',
        'profile',
        '_debugbar',
        '_ignition',
        'livewire',
        'lang/',
        '{locale}/password',
        'email/',
        'auth/',
        'payment-redirect/',
        'get_subscript',
        'sitemap.xml',
        'test',
        'sync',
        'logout',
        'optimize-clear',
        'test',
        'feed',
        'resources/uploads/images/thumb',
        'resources/thumb/',
        '{locale}/companies/payment-response/{hide}/premium',
        '{locale}/feed',
        '{locale}/test',
        '{locale}/card-action/{ad}',
        '{locale}/companies/new',
        '{locale}/get-credit-user',
        '{locale}/user/delete',
        '{locale}/cat',
        '{locale}/payment-response',
        '{locale}/search',
        '{locale}/ad/{advertising}',
        '{locale}/advertising/{advertising}/report',
        '{locale}/advertising/{advertising}/location',
        '{locale}/cities',
        '{locale}/get-all-areas',
        '{locale}/venuetypestest',
        '{locale}/asset/',
        '{locale}/confirm-report/',
        '{locale}/company/{company}/report',
        '{locale}/companies/{phone}/{name?}/advertise',
        '{locale}/advertising/{hashNumber}/location',
        '{locale}/advertising/{hashNumber}/direction',
        '{locale}/images/',
        '{locale}/companies/buy-premium',
    ];
    public static $hiddenMiddleware = [
        'auth',
    ];

    public static $getByEloquent = [
        'site.ad.detail' => [
            'query' => '\App\Models\Advertising::whereDate(\'expire_at\', \'>=\', Carbon\Carbon::now())->latest()->get()',
            'variable' => [
                '$item->hash_number',
            ],
            'name' => '$item->title_en',
            'lastmod' => '$item->updated_at',
        ],
        'companies.info' => [
            'query' => '\App\User::where(\'type_usage\', \'company\')->latest()->get()',
            'variable' => [
                '$item->company_phone',
                '$item->company_name',
            ],
            'name' => '$item->company_name',
            'lastmod' => '$item->updated_at',
        ],
    ];
    public function index(){
        $routeCollection = Route::getRoutes();
        $staticRoute = [];
        $dynamicRoute = [];
        foreach (array_keys(self::$getByEloquent) as $name )
            $dynamicRoute[$name] = [];
        foreach ($routeCollection->getRoutes() as  $value) {
            if ( ! Str::startsWith( trim( $value->uri() , '/'), self::$hiddenUri )
                and count( array_intersect($value->middleware(), self::$hiddenMiddleware ) ) == 0
                and in_array('GET', $value->methods())
                and ! in_array($value->getName(), array_keys(self::$getByEloquent))
                and $value->getName() != null
            ) {
                if(strpos($value->uri(), '{locale}'  ) === false)
                    $staticRoute[] = [
                        'link' => route($value->getName()),
                        'name' => $value->getName(),
                    ];
                else {
                    $staticRoute[] = [
                        'link' => route($value->getName() , 'ar'),
                        'name' => $value->getName(),
                    ];
                    $staticRoute[] = [
                        'link' => route($value->getName() , 'en'),
                        'name' => $value->getName(),
                    ];
                }
            } elseif ( in_array('GET', $value->methods())
                and in_array($value->getName(), array_keys(self::$getByEloquent))
            ) {
                $Eloquent['query'] = [];
                $object = self::$getByEloquent[$value->getName()];
                eval('$Eloquent[\'query\'] = '.trim($object['query'] , ';') . ';');
                foreach ( $Eloquent['query'] as $item) {
                    $routesVariable = [];
                    foreach ($object['variable'] as $variable) {
                        eval('$routesVariable[] = '.trim($variable , ';') . ';');
                    }
                    eval('$Eloquent[\'name\'] = '.trim($object['name'] , ';') . ';');
                    eval('$Eloquent[\'lastmod\'] = '.trim($object['lastmod'] , ';') . ';');

                    if(strpos($value->uri(), '{locale}'  ) === false)
                        $dynamicRoute[$value->getName()][] = [
                            'link' => route($value->getName(), $routesVariable),
                            'name' => $Eloquent['name'],
                            'lastmod' => $Eloquent['lastmod'],
                        ];
                    else {
                        array_unshift($routesVariable, "en");
                        $dynamicRoute[$value->getName()][] = [
                            'link' => route($value->getName(), $routesVariable),
                            'name' => $Eloquent['name'],
                            'lastmod' => $Eloquent['lastmod'],
                        ];
                        $routesVariable[0] = 'ar';
                        $dynamicRoute[$value->getName()][] = [
                            'link' => route($value->getName(), $routesVariable),
                            'name' => $Eloquent['name'],
                            'lastmod' => $Eloquent['lastmod'],
                        ];
                    }
                }
            }
        }
        $temp = array_unique(array_column($staticRoute, 'link'));
        $staticRoute = array_intersect_key($staticRoute, $temp);
        return response()->view('sitemap', compact('dynamicRoute' , 'staticRoute'))->header('Content-Type', 'text/xml');

    }
}
