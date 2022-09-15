<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\CompanyRequest;
use App\Models\Package;
use App\Models\PackageHistory;
use App\Models\Setting;
use App\Models\Social;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = User::where('type_usage', 'company')
            ->with('socials')
            ->get();

        return view('site.pages.companies', compact('companies'));
    }

    public function show($locale, $phone, $name)
    {
        $company = User::where('type_usage', 'company')
            ->where('company_phone', $phone)
            ->with('socials')
            ->firstOrFail();
        return view('site.pages.main', compact('company'));
    }

    public function new()
    {
        return view('site.pages.new-company');
    }

    public function store(CompanyRequest $request)
    {
        $user = auth()->user();
        $user_id = $user->id;

        if ($request->file('image')) {
            $file= $request->file('image');
            $filename = uniqid(time()).$file->getClientOriginalName();
            $path ='/resources/uploads/images/avatars/'.$filename;
            $file->move(public_path('/resources/uploads/images/avatars'), $filename);
            $filename = '/resources/uploads/images/avatars/' . $filename;

            if ($user->image_profile && file_exists($path = public_path('resources/uploads/images/avatars'). '/' . $user->image_profile))
                unlink($path);
        }
        // Company name always should be required!!!!
        if ( $user->company_name == null or empty($user->company_name) ) {
            $package = Package::where("title_en", "gift credit")->where('is_enable', 1)->where('user_type', 'company')->first();
            if (isset($package)) {
                $countDay = optional($package)->count_day;
                $today = date("Y-m-d");
                $date = strtotime("+$countDay day", strtotime($today));
                $expireDate = date("Y-m-d", $date);
                $countNormal = $package->count_advertising;
                $countPremium = $package->count_premium;
                PackageHistory::create(['title_en' => $package->title_en, 'title_ar' => $package->title_ar, 'user_id' => $user->id, 'type' => "static", 'package_id' => $request->package_id, 'date' => date('Y-m-d'), 'is_payed' => 1, 'price' => $package->price, 'count_day' => $package->count_day, 'count_show_day' => $package->count_show_day, 'count_advertising' => $countNormal, 'count_premium' => $countPremium, 'count' => 1, 'accept_by_admin' => 1, 'expire_at' => $expireDate]);
            }
        }

        User::where('id', $user_id)->update([
            'company_name' => $request->company_name,
            'company_phone' => $request->company_phone,
            'image_profile' => isset($filename) ? $filename : $user->image_profile,
            'type_usage' => 'company',
        ]);

        $this->insertSocials($request, $user_id);
        return redirect()->route('Main.buyPackage', app()->getLocale())->withInput()->with('status', 'account_upgraded');
    }

    public function downgrade(Request $request)
    {
        $balance = \App\Http\Controllers\site\MainController::getBalance();
        if ($balance !== 0)
            return redirect()->route('Main.buyPackage', app()->getLocale())->withInput()->with('status', 'ads_remaining');
        $user = auth()->user();
        $user_id = $user->id;

        User::where('id', $user_id)->update([
            'company_phone' => null,
            'type_usage' => 'individual',
        ]);
        return redirect()->route('Main.buyPackage', app()->getLocale())->withInput()->with('status', 'account_downgraded');
    }


    public static function insertSocials($request, $user_id)
    {
        Social::where('user_id' ,$user_id )->delete();
        $socials = [];
        if ($request->filled('email')) {
            $socials [] = [
                'user_id' => $user_id,
                'address' => $request->email,
                'type' => 'email',
            ];
        }
        if ($request->filled('instagram')) {
            $socials [] = [
                'user_id' => $user_id,
                'address' => $request->instagram,
                'type' => 'instagram',
            ];
        }
        if ($request->filled('twitter')) {
            $socials [] = [
                'user_id' => $user_id,
                'address' => $request->twitter,
                'type' => 'twitter',
            ];
        }
        if (!empty($socials)) {
            Social::insert($socials);
        }
    }
}
