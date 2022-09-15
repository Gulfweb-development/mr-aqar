<?php

namespace App\Http\Controllers\site;


use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\City;
use App\Models\Advertising;
use App\Models\Package;
use App\Models\PackageHistory;
use App\Models\Payment;
use App\Models\Setting;
use App\User;
use Carbon\Carbon;
use http\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use mysql_xdevapi\Exception;

class MainController extends Controller
{
    // index page
    public function index()
    {
        // app('debugbar')->disable();
        $premiumAds = Advertising::where('expire_at', '>', date('Y-m-d'))
            ->where('advertising_type', 'premium')
            ->whereNotNull('expire_at')
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        $cities = City::all();
        $areas = Area::orderBy('name_en')->get();

        $residentials = Advertising::where('expire_at', '>', date('Y-m-d'))
            ->where('advertising_type', 'normal')
            ->whereNotNull('expire_at')
            ->orderBy('created_at', 'desc')
            ->paginate(6);



        return view('site.pages.main', compact('premiumAds', 'residentials', 'cities', 'areas'));
    }

    //sign up page
    public function signup()
    {
        return view('site.auth.signup');
    }

    // login page
    public function login()
    {
        return view('site.auth.login');
    }

    // about us page
    public function aboutus()
    {

	    $aboutus_large_ar = Setting::where('setting_key' , 'aboutus_large_ar')->value('setting_value');
		$aboutus_large_en = Setting::where('setting_key' , 'aboutus_large_en')->value('setting_value');
		$aboutus_large_pic1 =   Setting::where('setting_key' , 'aboutus_large_pic1')->value('setting_value');
		$aboutus_large_pic2 =   Setting::where('setting_key' , 'aboutus_large_pic2')->value('setting_value');

		$our_story_en =   Setting::where('setting_key' , 'our_story_en')->value('setting_value');
		$our_story_ar =   Setting::where('setting_key' , 'our_story_ar')->value('setting_value');
		$our_value_en =   Setting::where('setting_key' , 'our_value_en')->value('setting_value');
		$our_value_ar =   Setting::where('setting_key' , 'our_value_ar')->value('setting_value');
		$our_promise_en =   Setting::where('setting_key' , 'our_promise_en')->value('setting_value');
		$our_promise_ar =   Setting::where('setting_key' , 'our_promise_ar')->value('setting_value');
        return view('site.pages.aboutus',compact('aboutus_large_ar','aboutus_large_en','aboutus_large_pic1','aboutus_large_pic2','our_story_en','our_story_ar','our_value_en','our_value_ar','our_promise_en','our_promise_ar'));
    }

    /*
    //
    my account page
    //
    */

    // get available ads for user
    public static function getBalance($ignoreGift=false)
    {
        $user = auth()->user();
        $date = date("Y-m-d");
        User::where('id', $user->id)->update(['last_activity' => date("Y-m-d")]);
        $listBalance = PackageHistory::where("user_id", $user->id)
            ->where("expire_at", ">", $date)
            ->where("is_payed", 1)
            ->where('accept_by_admin', 1)
            ->whereColumn('count_advertising', '>=', 'count_usage')
            ->whereColumn('count_premium', '>=', 'count_usage_premium')
            ->orderBy('id', 'desc');
if ($ignoreGift){
    $listBalance=$listBalance->where('title_en',"!=",'gift credit');
}
        $listBalance=$listBalance->get();
        if ($listBalance->count() >= 1) {
            $expireAt = $listBalance[0]->expire_at;
            $type = $listBalance[0]->type;
            $titleAr = $listBalance[0]->itle_ar;
            $titleEn = $listBalance[0]->title_en;

            $count = 0;
            $countPremium = 0;
            $countUsage = 0;
            $countPremiumUsage = 0;
            foreach ($listBalance as $item) {
                $count += $item->count_advertising;
                $countPremium += $item->count_premium;
                $countUsage += $item->count_usage;
                $countPremiumUsage += $item->count_usage_premium;
            }
            $av = $count - $countUsage;
            $avp = $countPremium - $countPremiumUsage;
            $record = [
                'type' => $type,
                'title_en' => $titleEn,
                'title_ar' => $titleAr,
                'expire_at' => $expireAt,
                'count_advertising' => $count,
                'count_usage' => $countUsage,
                'count_premium' => $countPremium,
                'count_premium_usage' => $countPremiumUsage,
                'available' => $av,
                'available_premium' => $avp
            ];
            if ($record['available'] === 0 && $record['available_premium'] === 0)
                $record = 0;
        } else {
            $record = 0;
        }
        return $record;
    }

    // profile page
    public function profile()
    {
        $record = $this->getBalance();
        return view('site.pages.profile', [
            'balance' => $record
        ]);
    }

    // change password
    public function changePassword()
    {
        $record = $this->getBalance();
        return view('site.pages.changePassword', [
            'balance' => $record
        ]);
    }

    //wishlist
    public function wishList()
    {
        $record = $this->getBalance();
        //return  $user = User::whereId(Auth::user()->id)->with(['archiveAdvertising','advertising'])->first();
        $wishList = User::whereId(Auth::user()->id)->with(['archiveAdvertising' => function ($q) {
            $q->where('expire_at', '>=', Carbon::now()->format('Y-m-d'))->with(['user', 'city', 'area']);
        }])->first();
//        return $wishList->archiveAdvertising;
        if (\request()->wantsJson()) {
            return [
                'balance' => $record,
                'wishLists' => $wishList->archiveAdvertising
            ];
        }
        return view('site.pages.wishList', [
            'balance' => $record,
            'wishLists' => $wishList->archiveAdvertising
        ]);
    }

    //payment history
    public function paymentHistory()
    {
        $record = $this->getBalance();
        $user = auth()->user();
        $payments = PackageHistory::where('user_id', $user->id)
            ->orderBy('id', 'desc')->paginate(20);

        return view('site.pages.paymentHistory', [
            'balance' => $record,
            'payments' => $payments
        ]);
    }

	public function paymentDetails(Request $request){
	if(empty($request->paymentid)){abort('404');}

	$record       = $this->getBalance();

	$payments     = Payment::where('payments.id',$request->paymentid);
	$payments     = $payments->select('tbl_transaction_api.*','payments.*')
	                         ->join('tbl_transaction_api','tbl_transaction_api.api_ref_id','=','payments.ref_id');
	$payments     = $payments->first();
	return view('site.pages.paymentDetails',['balance'=>$record,'paymentsDetails'=>$payments]);
	}

    //my ads
    public function myAds()
    {
        $record = $this->getBalance();

        $user = auth()->user();
        $ads = Advertising::where('user_id', $user->id)
            ->orderBy('id', 'desc')->paginate(20);

        return view('site.pages.myAds', [
            'balance' => $record,
            'ads' => $ads
        ]);
    }



    // buy package
    public function buyPackage()
    {
        cache()->forget('balance_values'.auth()->id());
        $record = $this->getBalance();

        if (auth()->user()->type_usage == 'individual') {
            $normals = Package::where('type', 'normal')
                ->where('title_en', '!=', 'gift credit')
                ->where('user_type', 'individual')
                ->where('is_enable', 1)
                ->where('is_visible', 1)->get();
            $statics = Package::where('type', 'static')
                ->where('user_type', 'individual')
                ->where('is_enable', 1)
                ->where('is_visible', 1)->get();
        } elseif (auth()->user()->type_usage == 'company') {
            $normals = Package::where('type', 'normal')
                ->where('title_en', '!=', 'gift credit')
                ->where('user_type', 'company')
                ->where('is_enable', 1)
                ->where('is_visible', 1)->get();
            $statics = Package::where('type', 'static')
                ->where('user_type', 'company')
                ->where('is_enable', 1)
                ->where('is_visible', 1)->get();
        }

        $credit = $this->getCreditUser(auth()->id());
        if ($credit === [])
            $credit = ['count_premium_advertising' => 0, 'count_normal_advertising' => 0];

        return view('site.pages.buyPackage', [
            'balance' => $record,
            'normals' => $normals,
            'statics' => $statics,
            'credit' => $credit,
        ]);
    }

    //buy package or credit
    public function buyPackageOrCredit(Request $request)
    {
        try {
            $user = auth()->user();
            cache()->forget('balance_values'.auth()->id());
            $validate = Validator::make($request->all(), [
                'package_id' => 'required|numeric',
                'type' => 'required|in:static,normal',
                'count' => 'nullable|numeric',
                'payment_type' => 'required|in:Cash,MyFatoorah',
            ]);
            if ($validate->fails()) {
                return redirect()->route('Main.buyPackage',app()->getLocale())->with(['status' => 'validation_failed']);
            }
            $package = Package::find($request->package_id);
            // untill now request data is validated
            // now we check user doesn't choose a package that already bought
            if ($package->type=="normal"){
                if ($user->package_id != null && $user->package_id != 0) {
                 $balance=$this->getBalance(true);
    //                dd($this->getBalance());
                    if ($balance!==0 && $balance['available']>0 && $balance['available_premium']>0) {
                            return redirect(app()->getLocale().'/buypackage#result')->with(['status' => 'ads_remaining']);
                    }
                }
            }
            $countDay = optional($package)->count_day;

            $today = date("Y-m-d");
            $date = strtotime("+$countDay day", strtotime($today));
            $expireDate = date("Y-m-d", $date);


            if (isset($request->count) && is_numeric($request->count) && $request->count > 1) {
                $count = $request->count;
            } else {
                $count = 1;
            }
            $countP = intval($package->count_premium) * intval($count);
            $countN = intval($package->count_advertising) * intval($count);
            $price = intval($package->price) * intval($count);


            if ($request->payment_type == "Cash" || $request->payment_type == "cash") {
                $accept = 0;
            } else {
                $accept = 1;
            }


            $ref = $this->makeRefId($user->id);
            $payment = Payment::create([
                'user_id' => $user->id,
                'package_id' => $request->package_id,
                'payment_type' => $request->payment_type,
                'price' => $price,
                'status' => 'new'
            ]);

            //todo:: 'is_payed'=>1  change to 0 after implement logic payment
            $res = PackageHistory::create([
                'title_en' => $package->title_en,
                'title_ar' => $package->title_ar,
                'user_id' => $user->id,
                'type' => $request->type,
                'package_id' => $request->package_id,
                'date' => date('Y-m-d'),
                'is_payed' => 0,
                'price' => $package->price,
                'count_day' => $package->count_day,
                'count_show_day' => $package->count_show_day,
                'count_advertising' => $countN,
                'count_premium' => $countP,
                'count' => $count,
                'expire_at' => $expireDate,
                'payment_type' => $request->payment_type,
                'accept_by_admin' => $accept
            ]);
            $payment->package_history_id = $res->id;
            $payment->ref_id = $ref;
            $res->payment_id = $payment->id;
            $res->save();
            $payment->save();


            if ($request->get('payment_type') == "MyFatoorah" and $price > 0 ) {
                $payUrl = $this->sendRequestForPayment($price, $ref, $package , $count , $payment);
                return redirect($payUrl) ;
            }
            else{ // if payment type is cash
                $res->accept_by_admin=1;
                $res->is_payed=1;

                $package_id = $res->package_id ;
                $user->package_id = $package_id ;
                $user->save() ;
                $res->save();

                if ($user->type_usage == 'company' && $user->companied_at === null)
                    $user->update(['companied_at' => now()]);

                return redirect()->route('Main.myAds', app()->getLocale())->with(['status' => 'package_bought']);
                // return redirect(app()->getLocale().'/paymenthistory#result')->with(['status' => 'package_bought']);
                //return redirect('/paymenthistory#result',app()->getLocale())->with(['status' => 'package_bought']);

            }
        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }
    }

    public function makeRefId($userId)
    {
        return substr(time(), 5, 4) . rand(1000, 9999) . $userId;
    }

    private function sendRequestForPayment($price, $orderid, $package, $quantity , $payment)
    {
        $post_string = '{
            "InvoiceValue":"' . $price . '",
            "CustomerName":"' . auth()->user()->name . '",
            "CustomerReference":"' . $orderid . '",
            "DisplayCurrencyIsoAlpha":"KWD",
            "CountryCodeId":"+965",
            "CustomerMobile":"' . auth()->user()->mobile . '",
            "CustomerEmail":"' . auth()->user()->email . '",
            "DisplayCurrencyId": 3,
            "SendInvoiceOption": 1,
            "InvoiceItemsCreate": [
              {
                "ProductId":null,
                "ProductName": "Purchasing from Online Store Kuwait Kash5astore",
                "Quantity":' . $quantity . ',
                "UnitPrice": "' . ( $price / $quantity ) . '"
              }
            ],
                "CallBackUrl":  "' . route('callback',[app()->getLocale() , 'accept' => true]) . '",
                 "Language": "2",
                 "ExpireDate": "2062-12-31T13:30:17.812Z",
                 "ApiCustomFileds": "",
                 "ErrorUrl": "' . route('callback',[app()->getLocale() , 'accept' => false]) . '"
          }';
        $soap_do = curl_init();
        curl_setopt($soap_do, CURLOPT_URL, env('ISLIVE', true) ? 'https://apikw.myfatoorah.com/ApiInvoices/CreateInvoiceIso' : 'https://apidemo.myfatoorah.com/ApiInvoices/CreateInvoiceIso');
        curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($soap_do, CURLOPT_TIMEOUT, 10);
        curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($soap_do, CURLOPT_POST, true);
        curl_setopt($soap_do, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($soap_do, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8', 'Content-Length: ' . strlen($post_string), 'Accept: application/json', 'Authorization: Bearer ' . $this->MYFToken()));
        $result1 = curl_exec($soap_do);
        //dd($result1);
        // echo "<pre>";print_r($result1);die;
        $err = curl_error($soap_do);
        $json1 = json_decode($result1, true);
        if (isset($json1['IsSuccess']) && $json1['IsSuccess'] == true) {
            $RedirectUrl = $json1['RedirectUrl'];
            if (is_array($json1['PaymentMethods'])) {
                $ref_Ex = $json1['PaymentMethods'][0];
                if (array_key_exists('PaymentMethodUrl', $ref_Ex)) {
                    $t = explode("?", $ref_Ex["PaymentMethodUrl"]);
                    if (is_array($t)) {
                        $res = str_replace("invoiceKey=", "", explode("&", $t[1]));
                        $referenceId = $res[0];
                        curl_close($soap_do);
                        $payment->pay_id = $referenceId ;
                        $payment->save();
                        $paymentTransaction =  new \App\Models\OrderTransaction();
                        $paymentTransaction->user_id = $payment->user_id;
                        $paymentTransaction->package_id = $payment->package_id;
                        $paymentTransaction->api_ref_id = $payment->ref_id;
                        $paymentTransaction->payment_id = $payment->id;
                        $paymentTransaction->trackid = $payment->pay_id;
                        $paymentTransaction->tranid = $payment->pay_id;
                        $paymentTransaction->type = $package->type;
                        $paymentTransaction->save();
                        return $RedirectUrl;
                    }
                }
            }
        } else {
            throw new \Exception($json1['Message'] .' '. $result1);
        }
    }

    private function MYFToken(){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, env('ISLIVE', true) ? 'https://apikw.myfatoorah.com/Token' : 'https://apidemo.myfatoorah.com/Token');
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(array('grant_type' => 'password', 'username' => env('MF_USERNAME'), 'password' => env('MF_PASSWORD'))));
        $result = curl_exec($curl);
        curl_close($curl);
        $json = json_decode($result, true);
        if (isset($json['access_token']) && !empty($json['access_token'])) {
            return $json['access_token'];
        } else
            throw new \Exception(__('throttle' , ['seconds' => 30 ]));
    }
    public function paymentResult(Request $request)
    {
        if (empty($request->paymentId)) {
            return redirect('/'.app()->getLocale(). '/');
        }
        $url =  ( env('ISLIVE', true) ? 'https://apikw.myfatoorah.com/ApiInvoices/Transaction/' :'https://apidemo.myfatoorah.com/ApiInvoices/Transaction/' ) .$request->paymentId;
        $soap_do1 = curl_init();
        curl_setopt($soap_do1, CURLOPT_URL,$url );
        curl_setopt($soap_do1, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($soap_do1, CURLOPT_TIMEOUT, 10);
        curl_setopt($soap_do1, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($soap_do1, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($soap_do1, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($soap_do1, CURLOPT_POST, false );
        curl_setopt($soap_do1, CURLOPT_POST, 0);
        curl_setopt($soap_do1, CURLOPT_HTTPGET, 1);
        curl_setopt($soap_do1, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8', 'Accept: application/json','Authorization: Bearer '. $this->MYFToken()));
        $result_in = curl_exec($soap_do1);
        $err_in = curl_error($soap_do1);
        $file_contents = htmlspecialchars(curl_exec($soap_do1));
        curl_close($soap_do1);
        $getRecorById = json_decode($result_in, true);
        $payment = Payment::with(['package', 'packageHistory', 'user'])->where('pay_id', $getRecorById['InvoiceId'])->first();
        $order = DB::table('tbl_transaction_api')->where("trackid", $getRecorById['InvoiceId'])->first();
        $refId = null;
        $message = $getRecorById['Error'];
        $trackid = $getRecorById['InvoiceId'];
        if ($payment) {
            $refId = $payment->ref_id;
            if (!empty($getRecorById['TransactionStatus']) && $getRecorById['TransactionStatus']==2) {
                $payment->status = "completed";
                $payment->packageHistory->accept_by_admin = 1;
                $payment->packageHistory->is_payed = 1;
                \App\User::find($payment->user->id)->update(['package_id' => intval($payment->package_id)]);
            } else {
                $payment->status = "failed";
                $payment->packageHistory->accept_by_admin = 0;
            }
            $payment->description = $getRecorById['Error'];
            $payment->update();
            $payment->packageHistory->update();
            //event(new \App\Events\Payment($message, $payment, $refId, $trackid));

        }
        return view("site.pages.payment", compact('message', 'refId', 'trackid', 'payment', 'order'));
    }

    public function getAreas()
    {
        return app()->getLocale()=='en'?  Area::orderBy('name_en')->get():Area::orderBy('name_ar')->get();
    }


}
