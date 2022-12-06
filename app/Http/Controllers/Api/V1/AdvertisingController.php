<?php

namespace App\Http\Controllers\Api\V1;

use App\Classes\Payment\CBKPay;
use App\Http\Controllers\site\MainController;
use App\Http\Controllers\site\MessageController;
use App\Jobs\EmailNotify;
use App\Lib\KnetPayment;
use App\Models\Advertising;
use App\Models\AdvertisingView;
use App\Models\InvalidKey;
use App\Models\LogVisitAdvertising;
use App\Models\Package;
use App\Models\PackageHistory;
use App\Models\Payment;
use App\Models\Setting;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AdvertisingController extends ApiBaseController
{
    private $user;

    public function companies(Request $request)
    {
        $companies = User::where('type_usage', 'company')
            ->with('socials')
            ->orderByDesc('is_premium')
            ->orderByDesc('created_at')
            ->paginate(30);
        return $this->success("", $companies);
    }
    public function company($id)
    {
        $company = User::where('type_usage', 'company')
            ->with('socials')
            ->findOrFail($id);
        return $this->success("", $company);
    }
    public function buyCompanyPremium()
    {
        try {
            //send user to buy
            $price = MessageController::getSettingDetails('on_top_price');
            if (!$price > 0 || auth()->user()->is_premium || auth()->user()->type_usage != 'company')
                return $this->fail("can not upgrade now!");

            $payment = Payment::create([
                'user_id' => auth()->user()->id,
                'price' => $price,
                'payment_type' => 'MyFatoorah',
                'status' => 'new',
                'ref_id' => $ref = substr(time(), 5, 4) . rand(1000, 9999) . auth()->user()->id,
            ]);

            $cbkPay = new CBKPay();
            $form = $cbkPay->initiatePayment($price, $ref, '', 'mraqar007', '', '', '', '', '', 'en', request()->getSchemeAndHttpHost() . '/' . app()->getLocale() . '/companies/payment-response/1/premium',true);
            return $this->success("", ['url' => route('api.formPayment' , ['url' => $form['url'] , 'formData' => $form['formData']])]);
        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }
    }
    public static function clearAdsData($item){
        $item->title_en = __($item->purpose,[],'en') .' '. ( $item->venue ? $item->venue->title_en : "") .' '. __('in' , [] , 'en') .' '.( $item->area ? $item->area->name_en : "");
        $item->title_ar = __($item->purpose,[],'ar') .' '. ( $item->venue ? $item->venue->title_ar : "") .' '. __('in' , [] , 'ar') .' '.( $item->area ? $item->area->name_ar : "");
        $item->other_images = json_decode($item->other_image , true);
        $item->other_images = isset($item->other_images['other_image']) ? array_values($item->other_images['other_image']) : [];
        $item->share_link = [
            'en' => route('site.ad.detail' , ['en' , $item->hash_number]) ,
            'ar' => route('site.ad.detail' , ['ar' , $item->hash_number])
        ];
        unset(
            $item->user->email_verified_at,
            $item->user->email,
            $item->user->package_id,
            $item->user->sms_verified,
            $item->user->verified,
            $item->user->verified_office,
            $item->user->licence,
            $item->user->type,
            $item->user->is_enable,
            $item->user->api_token,
            $item->user->device_token,
            $item->user->lang,
            $item->user->sms_code,
            $item->user->companied_at,
            $item->user->reported,
            $item->user->last_activity,
            $item->user->password_token,
            $item->user->package_expire_at,
            $item->user->created_at,
            $item->user->deleted_at,
            $item->user->updated_at,
            $item->area->created_at,
            $item->area->deleted_at,
            $item->area->updated_at,
            $item->city->created_at,
            $item->city->deleted_at,
            $item->city->updated_at,
            $item->venue->created_at,
            $item->venue->deleted_at,
            $item->venue->updated_at,
        );
        return $item;
    }
    public function getListAdvertising(Request $request)
    {
        $advertising = $this->bindFilter($request);
        $advertising->orderByDesc('advertising_type');
        $advertising->orderByDesc('updated_at');
        $advertising = tap($advertising->paginate(30))->map(function ($item){
            return AdvertisingController::clearAdsData($item);
        });

        return $this->success("", $advertising);
    }
    public function search(Request $request)
    {
        // $this->user = User::find($request->user_id);
        $advertising = $this->bindFilter($request);
        $advertising->orderByDesc('advertising_type');
        $advertising->orderByDesc('updated_at');
        // if (@$this->user) {
        //         $advertising = $advertising->whereNotIn('id', $this->user->blockedAdvertising->pluck('id')->merge(Advertising::whereIn('user_id',$this->user->blockedUsers->pluck('id') ?? [])->pluck('id') ?? []) ?? []);
        // }
        $advertising = tap($advertising->paginate(30))->map(function ($item){
            return AdvertisingController::clearAdsData($item);
        });

        return $this->success("", $advertising);
    }
    public function similarAdvertising($id)
    {
        $advertising = Advertising::findOrFail($id);
        $list = tap(Advertising::getValidAdvertising()->where('type', $advertising->type)->where("venue_type", $advertising->venue_type)->where("purpose", $advertising->purpose)->paginate(30))->map(function ($item){
            return AdvertisingController::clearAdsData($item);
        });
        return $this->success("", $list);
    }
    public function getAdvertising($id)
    {
        $advertising = Advertising::with(["user", "area", "city"])->findOrFail($id);
        $advertising->title_en = __($advertising->purpose,[],'en') .' '. $advertising->venue->title_en .' '. __('in' , [] , 'en') .' '.$advertising->area->name_en;
        $advertising->title_ar = __($advertising->purpose,[],'ar') .' '. $advertising->venue->title_ar .' '. __('in' , [] , 'ar') .' '.$advertising->area->name_ar;
        $device_token = \request()->device_token;
        $user_id = \request()->user_id;
        $count = $this->visitAdvertising($id, $device_token);
        $hasArchive = $this->hasArchive($user_id, $id);
        $advertising->count_view = $count;
        $advertising->has_archive = $hasArchive;
        return $this->success("", $advertising);
    }
    public function getUserSaved(Request $request)
    {
        $user = auth()->user();
        $userId = $user->id;
        $ids = DB::table("user_archive_advertising")->where('user_id', $userId)->pluck('advertising_id')->toArray();
        $advertising = Advertising::getValidAdvertising()->whereIn('id', $ids)->paginate(30);
        return $this->success("", $advertising);
    }
    public function getUserAdvertising(Request $request)
    {
        $advertising = tap(Advertising::getValidAdvertising(0)->where(function ($r) use ($request) {
            if ($request->expire == 1) {
                $r->whereDate('expire_at', '<', Carbon::now())->whereNotNull('expire_at');
            } elseif ($request->expire == 0) {
                $r->whereNotNull('expire_at')->whereDate('expire_at', '>=', Carbon::now());
            }
        })->where('user_id', auth()->user()->id)->paginate(30))->map(function ($item){
            return AdvertisingController::clearAdsData($item);
        });

        return $this->success("", $advertising);
    }
    public function createAdvertising(Request $request)
    {

        try {
            $validate = $this->validateAdvertising($request);
            if ($validate->fails())
                return $this->fail($validate->errors()->first(), -1, $request->all());

            $result = $this->filterKeywords($request->description);

            if (!$result[0]) {
                return $this->fail("invalid Keyword (" . $result[1] . ")", -1, $request->all());
            }


            $user = auth()->user();
            $isValid = $this->isValidCreateAdvertising($user->id, $request->advertising_type);
            if ($isValid) {
                DB::beginTransaction();
                $advertising = new Advertising();
                $advertising = $this->saveAdvertising($request, $user, $advertising);
                $countShowDay = $this->affectCreditUser($user->id, $request->advertising_type);
                $today =   date("Y-m-d");
                $date = strtotime("+$countShowDay day", strtotime($today));
                $expireDate = date("Y-m-d", $date);
                $advertising->expire_at = $expireDate;
                $advertising->save();
                $advertising->title_en = __($advertising->purpose,[],'en') .' '. ( $advertising->venue ? $advertising->venue->title_en : "") .' '. __('in' , [] , 'en') .' '.( $advertising->area ? $advertising->area->name_en : "");
                $advertising->title_ar = __($advertising->purpose,[],'ar') .' '. ( $advertising->venue ? $advertising->venue->title_ar : "") .' '. __('in' , [] , 'ar') .' '.( $advertising->area ? $advertising->area->name_ar : "");

                DB::commit();
                return $this->success("", ['advertising' => $advertising]);
            }
            return $this->fail(trans("main.expire_your_credit"));
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->fail($exception->getMessage(), -1, $request->all());
        }
    }

    public function repostAdvertising(Request $request)
    {

        try {
            $user = auth()->user();
            $advertise = Advertising::query()
                ->where('user_id' , $user->id)
                ->find($request->advertise_id);
            if ( $advertise == null )
                return $this->fail(trans("no_ad_found"));

            $isValid = $this->isValidCreateAdvertising($user->id, $advertise->advertising_type);
            if ($isValid) {
                DB::beginTransaction();
                $newAdvertise = $advertise->replicate();
                $newAdvertise->hash_number = Advertising::makeHashNumber();
                $newAdvertise->created_at = Carbon::now();
                $newAdvertise->updated_at = Carbon::now();
                $countShowDay = $this->affectCreditUser($user->id, $advertise->advertising_type);
                $today =   date("Y-m-d");
                $date = strtotime("+$countShowDay day", strtotime($today));
                $expireDate = date("Y-m-d", $date);
                $newAdvertise->expire_at = $expireDate;
                $newAdvertise->save();
                $newAdvertise->title_en = __($newAdvertise->purpose,[],'en') .' '. ( $newAdvertise->venue ? $newAdvertise->venue->title_en : "") .' '. __('in' , [] , 'en') .' '.( $newAdvertise->area ? $newAdvertise->area->name_en : "");
                $newAdvertise->title_ar = __($newAdvertise->purpose,[],'ar') .' '. ( $newAdvertise->venue ? $newAdvertise->venue->title_ar : "") .' '. __('in' , [] , 'ar') .' '.( $newAdvertise->area ? $newAdvertise->area->name_ar : "");

                DB::commit();
                return $this->success("", ['advertising' => $newAdvertise]);
            }
            return $this->fail(trans("main.expire_your_credit"));
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->fail($exception->getMessage(), -1, $request->all());
        }
    }

    public function updateAdvertising(Request $request)
    {
        try {
            $validate = $this->validateAdvertising($request, false);
            if ($validate->fails())
                return $this->fail($validate->errors()->first());

            $result = $this->filterKeywords($request->description);
            if (!$result[0]) {
                return $this->fail("invalid Keyword (" . $result[1] . ")", -1, $request->all());
            }

            $user = auth()->user();
            $advertising = Advertising::where('user_id',$user->id)->find($request->id);
            if (isset($advertising)) {
                $advertising = $this->saveAdvertising($request, $user, $advertising);
                return $this->success(trans('edited'), ['advertising' => $advertising]);
            }
            return $this->fail("not_found_advertising");
        } catch (\Exception $exception) {
            return $this->fail("server_error");
        }
    }
    public function attachFileToAdvertising(Request $request)
    {
        //Log::info($request->all());

        $validate =   Validator::make($request->all(), [
            'advertising_id' => 'required',
            //'video' => 'nullable|mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4|max:20000',
            // 'other_image.*' => 'nullable|mimes:jpeg,bmp,png|max:2048',
        ]);
        if ($validate->fails())
            return $this->fail($validate->errors()->first());

        $advertising = Advertising::find($request->advertising_id);
        if ($advertising->other_image != "" && $advertising->other_image != null) {
            $otherImage = (array)json_decode($advertising->other_image);
        } else {
            $otherImage = [];
        }

        for ($i = 1; $i <= 10; $i++) {
            if (isset($request->{"other_image" . $i})) {
                $file = $request->{"other_image" . $i};
                if ($request->hasFile("other_image" . $i)) {
                    $path = $this->saveImage($file);
                    $otherImage["other_image" . $i] = $path;
                } elseif ($file == "false") {
                    $otherImage["other_image" . $i] = "";
                }
            }
        }

        if (count($otherImage) >= 1) {
            $otherImage = json_encode($otherImage);
            $advertising->other_image = $otherImage;
        }
        if ($request->hasFile('main_image')) {
            $advertising->main_image = $this->saveImage($request->main_image);
        } elseif ($request->main_image == "false") {
            $advertising->main_image = "";
        }
        if (isset($request->video)) {
            if (!is_string($request->video)) {
                $video = $request->video;
                $advertising->video = $this->saveVideo($video);
            } elseif ($request->video == "false") {
                $advertising->video = "";
            }
        }
        if ($request->hasFile('floor_plan')) {
            $advertising->floor_plan = $this->saveImage($request->floor_plan);
        } elseif ($request->floor_plan == "false") {
            $advertising->floor_plan = "";
        }

        $advertising->save();

        return $this->success("");
    }
    public function deleteFileFromAdvertising(Request $request)
    {
        $validate =   Validator::make($request->all(), [
            'advertising_id' => 'required',
            //'video' => 'nullable|mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4|max:20000',
            'file_patch' => 'required',
        ]);
        if ($validate->fails())
            return $this->fail($validate->errors()->first());

        $advertising = Advertising::where('user_id' ,auth()->id())->find($request->advertising_id);
        if ( $advertising == null )
            return $this->fail("not found");


        if ( $advertising->video == $request->file_patch ) {
            $advertising->video = null ;
            $advertising->save();
            return $this->success("");
        }

        if ($advertising->other_image != "" && $advertising->other_image != null) {
            $otherImage = json_decode($advertising->other_image , true);
            $otherImage = array_values(isset($otherImage['other_image']) ? ( isset($otherImage['other_image'][0]) ? $otherImage['other_image'][0] : [] ) : [] );
        } else {
            $otherImage = [];
        }
        if ( $advertising->main_image == $request->file_patch ) {
            $advertising->main_image = isset($otherImage[0]) ? $otherImage[0] : null ;
            if ( isset($otherImage[0])  )
                unset($otherImage[0]);
        }
        foreach ($otherImage as $item => $value){
            if( $value == $request->file_patch ){
                unset($otherImage[$item]);
                break;
            }
        }
        $advertising->other_image = json_encode(['other_image' => array_values($otherImage)]);
        $advertising->save();

        return $this->success("");
    }
    public function archiveAdvertising(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'advertising_id' => 'required|numeric',
        ]);
        if ($validate->fails())
            return $this->fail($validate->errors()->first());


        auth()->user()->archiveAdvertising()->syncWithoutDetaching([$request->advertising_id]);
        return $this->success("");
    }
    public function detachArchive(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'advertising_id' => 'required|numeric',
        ]);
        if ($validate->fails())
            return $this->fail($validate->errors()->first());


        auth()->user()->archiveAdvertising()->detach([$request->advertising_id]);
        return $this->success("");
    }
    public function deleteAdvertising(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'advertising_id' => 'required|numeric',
        ]);
        if ($validate->fails())
            return $this->fail($validate->errors()->first());


        $result =  Advertising::where('id', $request->advertising_id)->where("user_id", auth()->user()->id)->first();
        if (isset($result)) {
            $result->delete();
            return $this->success(trans('ad_delete_success_title'));
        }
        return $this->fail("not found");
    }
    // get available ads for user
    public function getBalance($ignoreGift = false)
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
        if ($ignoreGift) {
            $listBalance = $listBalance->where('title_en', "!=", 'gift credit');
        }
        $listBalance = $listBalance->get();
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
        } else {
            $record = 0;
        }
        return $record;
    }
    public function buyPackageOrCredit(Request $request)
    {
        try {
            $user = auth()->user();
            $validate = Validator::make($request->all(), [
                'package_id'   => 'required|numeric',
                'type'         => 'required|in:static,normal',
                'count'        => 'nullable|numeric',
                'payment_type' => 'required|in:Cash,CBKPay',
            ]);
            if ($validate->fails()) {
                return $this->fail($validate->errors()->first());
            }
            $package = Package::find($request->package_id);
            // untill now request data is validated
            // now we check user doesn't choose a package that already bought
            if ($package->type == "normal") {
                if ($user->package_id != null && $user->package_id != 0) {
                    $balance = MainController::getBalance(true);
                    //                dd($this->getBalance());
                    if ($balance !== 0 && $balance['available'] > 0 && $balance['available_premium'] > 0) {
                        return $this->fail(trans('packageNotFinished'));
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


            $ref = substr(time(), 5, 4) . rand(1000, 9999) .$user->id;
            $payment = Payment::create([
                'user_id'      => $user->id,
                'package_id'   => $request->package_id,
                'payment_type' => $request->payment_type,
                'amount'        => $price,
                'status'       => 'new',
            ]);

            //todo:: 'is_payed'=>1  change to 0 after implement logic payment
            $res = PackageHistory::create([
                'title_en'          => $package->title_en,
                'title_ar'          => $package->title_ar,
                'user_id'           => $user->id,
                'type'              => $request->type,
                'package_id'        => $request->package_id,
                'date'              => date('Y-m-d'),
                'is_payed'          => 0,
                'price'             => $package->price,
                'count_day'         => $package->count_day,
                'count_show_day'    => $package->count_show_day,
                'count_advertising' => $countN,
                'count_premium'     => $countP,
                'count'             => $count,
                'expire_at'         => $expireDate,
                'payment_type'      => $request->payment_type,
                'accept_by_admin'   => $accept
            ]);
            $payment->package_history_id = $res->id;
            $payment->ref_id             = $ref;
            $res->payment_id             = $payment->id;
            $res->save();
            $payment->save();


            if ($request->get('payment_type') == "CBKPay" and $price > 0) {
                $cbkPay = new CBKPay();
                $form = $cbkPay->initiatePayment($price, $ref, '', 'mraqar007', '', '', '', '', '', 'en', request()->getSchemeAndHttpHost() . '/'.app()->getLocale().'/payment-response/1/cbk' , true);
                return $this->success("", ['url' => route('api.formPayment' , ['url' => $form['url'] , 'formData' => $form['formData']])]);
            } else {
                // if payment type is cash
                $res->accept_by_admin = 1;
                $res->is_payed        = 1;

                $package_id       = $res->package_id;
                $user->package_id = $package_id;
                $user->save();
                $res->save();

                if ($user->type_usage == 'company' && $user->companied_at === null)
                    $user->update(['companied_at' => now()]);

                return $this->success(trans('packageSuccess'));
            }
        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }
    }
    public function formPayment(Request $request){
        $form = "<form id='pgForm' method='post' action='".$request->url."' enctype='application/x-www-form-urlencoded'>";
        foreach ($request->formData as $k => $v) {
            $form .= "<input type='hidden' name='$k' value='$v'>";
        }
        $form .= "</form><div style='position: fixed;top: 15%;left: 50%;transform: translate(-50%, -50%);text-align:center'>Redirecting... <br> <b> DO NOT REFRESH</b><br><img src='/fancybox/source/fancybox_loading@2x.gif'></div><script type='text/javascript'>
                document.getElementById('pgForm').submit();
            </script>";
        return $form;
    }
    public function paymentResult(Request $request)
    {

        $message = $request->get('message');
        $refId = $request->get('refid');
        $trackid = $request->get('trackid');
        $payment = Payment::with(['package', 'packageHistory', 'user'])->where('ref_id', $request->get('refid'))->first();
        $order = DB::table('tbl_transaction_api')->where("api_ref_id", $request->get('refid'))->first();

        if ($payment) {

            if ($message == "CAPTURED") {
                $payment->status = "completed";
                $payment->packageHistory->accept_by_admin = 1;
                $payment->packageHistory->is_payed = 1;
                \App\User::find($payment->user->id)->update(['package_id' => intval($payment->package_id)]);
            } else {
                $payment->status = "failed";
                $payment->packageHistory->accept_by_admin = 0;
            }
            $payment->description = $message;
            $payment->update();
            $payment->packageHistory->update();
        }
        if ($payment) {
            event(new \App\Events\Payment($message, $payment, $refId, $trackid));
        }
        if ($message == "CAPTURED") {
            return view("api.pages.payment", compact('message', 'refId', 'trackid', 'payment', 'order'));
        } else
            return view("api.pages.payment", compact('message', 'refId', 'trackid', 'payment', 'order'));
    }

    private function visitAdvertising($id, $token = null)
    {
        if (isset($token) && $token != null && !empty($token)) {
            $res = AdvertisingView::where('advertising_id', $id)->where('device_token', $token)->first();
            if (!isset($res)) {
                DB::table("advertising_view")->insert(['advertising_id' => $id, 'device_token' => $token, 'created_at' => date('Y-m-d h:i:s', time())]);
            } else {
                $res->update(['created_at' => date('Y-m-d h:i:s', time())]);
            }
        }
        $count = DB::table("advertising_view")->where('advertising_id', $id)->count();
        return $count;
    }
    public function logVisitAdvertising(Request $request)
    {
        $advertisingId = $request->advertising_id;
        $user_id = $request->user_id;
        $device_token = empty($request->device_token) ? 'null' : $request->device_token;
        if (isset($user_id) && $user_id != "" && $user_id != null) {
            LogVisitAdvertising::updateOrCreate(
                ['user_id' => $user_id, 'advertising_id' => $advertisingId],
                ['device_token' => $device_token]
            );
        } elseif (isset($device_token) && $device_token != "" && $device_token != null) {
            LogVisitAdvertising::updateOrCreate(
                ['device_token' => $device_token, 'advertising_id' => $advertisingId],
                ['user' => null]
            );
        }
        return $this->success("");
    }
    private function bindFilter(Request $request): \Illuminate\Database\Eloquent\Builder
    {
        $advertising = Advertising::getValidAdvertising()
            ->whereNotNull('expire_at')
            ->where('expire_at', '>', date('Y-m-d'))
            ->whereHas("user");


        if (isset($request->area_id) && count($request->area_id) > 0) {
            $advertising = $advertising->whereIn("area_id", $request->area_id);
        }
        if ($request->isRequiredPage)
            $advertising = $advertising->where("purpose", 'required_for_rent');
        else {
            $advertising = $advertising->where("purpose", "!=", 'required_for_rent');
            if (isset($request->purpose) && $request->purpose != null and $request->purpose != "" and $request->purpose != "all") {
                $advertising = $advertising->where("purpose", $request->purpose);
            }
        }

        if ($request->company_id) {
            $advertising = $advertising->where("user_id", $request->company_id);
        }

        if ($request->advertising_type) {
            $advertising = $advertising->where("advertising_type", $request->advertising_type);
        }

        if ($request->venue_type) {
            $advertising = $advertising->where("venue_type", $request->venue_type);
        }
        if (isset($request->keyword) && $request->keyword != "") {
            $advertising = $advertising->where(function ($r) use ($request) {
                $r->where('title_en', 'like', '%' . $request->keyword . '%')->orWhere('title_ar', 'like', '%' . $request->keyword . '%');
            });
        }
        if (isset($request->min_price) &&  $request->min_price != "") {
            $minPrice = floatval(trim(str_replace("KD", "", $request->min_price)));
            $advertising = $advertising->where("price", '>=', $minPrice);
        }
        if (isset($request->max_price) &&  $request->max_price != "") {
            $p = floatval(trim(str_replace("KD", "", $request->max_price)));
            $advertising = $advertising->where("price", '<=', $p);
        }
        if (isset($request->number_of_rooms) &&  is_numeric($request->number_of_rooms)) {
            $advertising = $advertising->where("number_of_rooms", $request->number_of_rooms);
        }
        if (isset($request->property) && is_array($request->property)) {
            if (in_array('parking', $request->property)) {
                $advertising = $advertising->where("number_of_parking", '>=', 1);
            }
            if (in_array('balcony', $request->property)) {
                $advertising = $advertising->where("number_of_balcony", '>=', 1);
            }
            if (in_array('security', $request->property)) {
                $advertising = $advertising->where("security", 1);
            }
            if (in_array('pool', $request->property)) {
                $advertising = $advertising->where("pool", 1);
            }
        }
        return $advertising;
    }
    private function validateAdvertising(Request $request, $create = true): \Illuminate\Contracts\Validation\Validator
    {
        if ( $create )
            return Validator::make($request->all(), [
                'venue_type' => 'required',
                'purpose' => 'required|in:rent,sell,exchange,required_for_rent',
                'advertising_type' => 'required|in:normal,premium',
                'city_id' => 'required',
                'area_id' => 'required',
                'price' => 'nullable|numeric',
                'video' => request()->hasFile("video") ? 'nullable|mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4|max:20000' : ( (request()->has("video") and is_string(request()->get("video"))) ?  'nullable|string' : 'nullable' ) ,
            ]);
        return Validator::make($request->all(), [
            'venue_type' => 'required',
            'purpose' => 'required|in:rent,sell,exchange,required_for_rent',
            'city_id' => 'required',
            'area_id' => 'required',
            'price' => 'nullable|numeric',
            'video' => request()->hasFile("video") ? 'nullable|mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4|max:20000' : ( (request()->has("video") and is_string(request()->get("video")) )?  'nullable|string' : 'nullable' )
            ]);
    }
    private function saveAdvertising(Request $request, $user, Advertising $advertising): Advertising
    {
        $advertising->user_id = $user->id;
        $advertising->phone_number = $request->phone_number;
        $advertising->city_id = $request->city_id;
        $advertising->area_id = $request->area_id;
        $advertising->type = 'residential';
        $advertising->venue_type = $request->venue_type;
        $advertising->purpose = $request->purpose;
        if ($request->route()->getName() == "api.createAdvertise")
            $advertising->advertising_type = $request->advertising_type;
        $advertising->description = $request->description;
        $advertising->price = $request->price;
        $advertising->title_en = $request->title_en;
        $advertising->title_ar = $request->title_en;
        $advertising->number_of_rooms = $request->number_of_rooms ? $request->number_of_rooms : null;
        $advertising->number_of_bathrooms = $request->number_of_bathrooms ? $request->number_of_bathrooms : null;
        $advertising->number_of_master_rooms = $request->number_of_master_rooms ? $request->number_of_master_rooms : null;
        $advertising->number_of_parking = $request->number_of_parking ? $request->number_of_parking : null;
        $advertising->number_of_balcony = $request->number_of_balcony ? $request->number_of_balcony : null;
        $advertising->number_of_floor = $request->number_of_floor ? $request->number_of_floor : null;
        $advertising->number_of_miad_rooms = $request->number_of_miad_rooms ? $request->number_of_miad_rooms : null;
        $advertising->surface = $request->surface ? $request->surface : null;
        // $advertising->gym = $request->gym;
        // $advertising->pool = $request->pool;
        // $advertising->furnished = $request->furnished;
        $advertising->security = $request->security;
        $advertising->location_lat = $request->location_lat;
        $advertising->location_long = $request->location_long;
        if ($request->route()->getName() == "api.createAdvertise") {
            $advertising->hash_number = Advertising::makeHashNumber();
            $advertising->floor_plan = "";
            $advertising->main_image = "";
            $advertising->other_image = "";
        }

        foreach ((array) $request->deleted_images as $image) {
            !file_exists(public_path(urldecode($image))) ?: unlink(public_path(urldecode($image)));
        }

        if ($request->hasFile('floor_plan')) {
            $advertising->floor_plan = $this->saveImage($request->floor_plan);
        } elseif ($request->floor_plan == "false") {
            $advertising->floor_plan = "";
        }

        $otherImage = [];
//        $old_otherImages = @$advertising->other_image
//        && json_decode(@$advertising->other_image)
//        && count(json_decode(@$advertising->other_image))
//        && json_decode(@$advertising->other_image, true)['other_image']
//            ? json_decode(@$advertising->other_image, true)['other_image']
//            : [];

        if (is_array($request["other_image"]) and count($request["other_image"])  > 0) {
            foreach ($request["other_image"] as $i => $file) {
                if ($request->hasFile("other_image." .  $i)) {
                    $path = $this->saveImage($request->file("other_image." . $i), true);
                } elseif (is_string($file)) {
                    $path = $file;
                } else {
                    $path = "";
                    continue;
                }
                $otherImage["other_image"][] = $path;
                //!(@$old_otherImages[$i] && file_exists(public_path(urldecode(@$old_otherImages[$i])))) ?: unlink(public_path(urldecode(@$old_otherImages[$i])));
            }
        }
        if (($advertising->main_image == "" or  $advertising->main_image == null or true ) and isset($otherImage["other_image"][0])) {
            $advertising->main_image = $otherImage["other_image"][0];
            unset($otherImage["other_image"][0]);
        }
        if (count($otherImage) >= 1) {
            $otherImage = json_encode($otherImage);
            $advertising->other_image = $otherImage;
        }
        // dd($advertising);

        if (isset($request->video)) {
            if (!is_string($request->video)) {
                $video = $request->video;
                $advertising->video = $this->saveVideo($video);
            } elseif (is_string($request->video)) {
                $advertising->video = $request->video;
            } elseif ($request->video == "false") {
                $advertising->video = null;
            }
        }

        $advertising->save();

        //        event(new NewAdvertising($advertising));
        return $advertising;
    }
    private function makeSearchHistory($request)
    {
        if ($request->device_token != null && $request->device_token != "" && $request->device_token != "null") {
            $cityId = $request->city_id != -1 ?? 0;
            $area_id = $request->area_id != -1 ?? 0;
            DB::table("search_history")->insert(['area_id' => $area_id, 'city_id' => $cityId, 'advertising_type' => $request->advertising_type, 'type' => $request->type, 'venue_type' => $request->venue_type, 'purpose' => $request->purpose, 'main_price' => floatval($request->main_price), 'max_price' => floatval($request->max_price), 'device_token' => $request->device_token]);
        }
    }

    private function hasArchive($userId, $id)
    {
        return  DB::table("user_archive_advertising")->where("user_id", $userId)->where("advertising_id", $id)->count();
    }
    private function sendRequestForPayment($price, $refId, $user_id = null, $type = null, $package_id = null)
    {
        return null;
    }
    public function makeRefId($userId)
    {
        return substr(time(), 5, 4) . rand(1000, 9999) . $userId;
    }
    private function getInvalidKeys()
    {
        $keys =  InvalidKey::first();
        if (isset($keys)) {
            $items = json_decode($keys->key_title);
        } else {
            $items = [];
        }
        return $items;
    }
    public function filterKeywords($text)
    {
        $keys = explode(" ", $text);
        $invalidKeys = $this->getInvalidKeys();
        foreach ($keys as $key) {
            if (in_array($key, $invalidKeys)) {
                return [false, $key];
            }
        }
        return [true];
    }


    public function upgrade_premium(Request $request)
    {
        $isValid = $this->isValidCreateAdvertising(auth()->user()->id, 'premium');
        if (!$isValid) {
            return $this->fail(trans('dont_have_premium_package'));
        }
        if ($request->advertise_id) {
            $advertising = Advertising::whereId($request->advertise_id)->where('user_id', Auth::user()->id)->firstOrFail();
            // decrease one from user premium packages count
            User::where('id', Auth::user()->id)->update(['last_activity' => date("Y-m-d")]);
            $countShowDay = $this->affectCreditUser(Auth::user()->id, 'premium');
            $today = date("Y-m-d");
            $date = strtotime("+$countShowDay day", strtotime($today));
            $expireDate = date("Y-m-d", $date);
            $advertising->expire_at = $expireDate;
            $advertising->advertising_type = 'premium';
            $advertising->save();

            return $this->success( trans('upgraded_premium'));
        }
        return $this->fail(trans('un_success_alert_title'));
    }

    public function report($id){
        $advertising = Advertising::getValidAdvertising()->findOrFail($id);
        $advertising->reported += 1;
        $advertising->save();
        return $this->success( trans('advertising_title').trans('has_been_reported_successfully'));
    }
}
