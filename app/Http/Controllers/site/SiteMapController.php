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
        '{locale}/feed',
        '{locale}/test',
        '{locale}/card-action/{ad}',
        '{locale}/companies/new',
        '{locale}/get-credit-user',
        '{locale}/user/delete',
    ];

    public static $getByEloquent = [
        'ad.search' => [
            'query' => '\App\Models\Ad::query()->where(\'is_approved\', 1)->latest()->get()',
            'variable' => [
                'toSlug($item->title)',
                '$item->id',
            ],
            'name' => '$item->title',
            'lastmod' => '$item->updated_at',
        ],
        'agency.ads' => [
            'query' => '\App\Models\User::companies()->get()',
            'variable' => [
                'toSlug($item->name)',
                '$item->id',
            ],
            'name' => 'trans(\'app.ads\') .\' \' . trans(\'app.created_by\') .\' \' . $item->name',
            'lastmod' => '$item->updated_at',
        ],
        'agency' => [
            'query' => '\App\Models\User::companies()->get()',
            'variable' => [
                'toSlug($item->name)',
                '$item->id',
            ],
            'name' => '$item->name',
            'lastmod' => '$item->updated_at',
        ],
        'blog' => [
            'query' => '\App\Models\Blog::get()',
            'variable' => [
                'toSlug($item->translate(\'title\'))',
                '$item->id',
            ],
            'name' => '$item->translate(\'title\')',
            'lastmod' => '$item->updated_at',
        ],
        'school' => [
            'query' => '\App\Models\School::query()->latest()->get()',
            'variable' => [
                'toSlug($item->translate(\'title\'))',
                '$item->id',
            ],
            'name' => '$item->translate(\'title\')',
            'lastmod' => '$item->updated_at',
        ],
    ];
    public function index(){
        $routeCollection = Route::getRoutes();
        dd(collect($routeCollection->getRoutes())
            ->map(function ($item) {
                if ( ! Str::startsWith( trim( $item->uri() , '/'), self::$hiddenUri )
                    and in_array('GET', $item->methods())
                    and ! in_array($item->getName(), array_keys(self::$getByEloquent))
                )
                    return $item->middleware() ;
            }));
        $staticRoute = [];
        $dynamicRoute = [];
        foreach (array_keys(self::$getByEloquent) as $name )
            $dynamicRoute[$name] = [];
        foreach ($routeCollection->getRoutes() as  $value) {
            if ( ! Str::startsWith( trim( $value->uri() , '/'), self::$hiddenUri )
                and in_array('GET', $value->methods())
                and ! in_array($value->getName(), array_keys(self::$getByEloquent))
            )
                $staticRoute[] = [
                    'link' => route($value->getName()),
                    'name' => trans('app.'.$value->getName()),
                ];
            elseif ( in_array('GET', $value->methods())
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
                    $dynamicRoute[$value->getName()][] = [
                        'link' => route($value->getName(), $routesVariable),
                        'name' => $Eloquent['name'],
                        'lastmod' => $Eloquent['lastmod'],
                    ];
                }
            }
        }
        return response()->view('sitemap', compact('dynamicRoute' , 'staticRoute'))->header('Content-Type', 'text/xml');

    }
}
