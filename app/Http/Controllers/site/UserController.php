<?php


namespace App\Http\Controllers\site;

use App\Events\UserRegistered;
use App\Http\Controllers\Api\V1\ApiBaseController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Site\RegisterRequest;
use App\Http\Requests\Site\SendSmsCodeRequest;
use App\Http\Requests\Site\verifySmsCodeRequest;
use App\Models\Advertising;
use App\Models\Package;
use App\Models\PackageHistory;
use App\Models\Payment;
use App\Models\Setting;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use App\Mail\DefaultEmail;
use Mail;

class UserController extends Controller
{
    public function passwordValidation(array $data)
    {
        return Validator::make($data, [
            'password' => 'required|string|min:8|confirmed',
        ]);
    }


    public function sendSmsCode(SendSmsCodeRequest $request)
    {
        try {
            $mobile = $request->mobile;
            $user = User::where("mobile", $mobile)->first();
            if (!is_null($user)) {
                $code = rand(10000, 99999);
                $message = "Activation Code : " . $code;
                $user->sms_code = $code;
                $user->save();
                self::sendSms($message, $mobile);
                return $this->success(trans("main.successfully_send_verify_code"));
            }
            return $this->fail(trans("main.user_not_found"));
        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }


    }

    public function verifyUserBySmsCode(verifySmsCodeRequest $request)
    {
        $user = User::where("mobile", request('mobile'))->first();
        Auth::login($user);
        return $this->success("", $user);
    }

    public function updateDeviceToken(Request $request)
    {
        $user = auth()->user();
        if (isset($request->device_token) && $request->device_token != "null" && $request->device_token != "")
            User::whereId($user->id)->update(['device_token' => $request->device_token]);


        return $this->success("");
    }

    public function register(RegisterRequest $request)
    {
        try {

            DB::beginTransaction();
            $user = User::makeUser(['name' => $request->name, 'email' => $request->email, 'password' => bcrypt($request->password),
                'type_usage' => $request->type_usage, 'company_name' => $request->company_name, 'mobile' => $request->mobile,
                'device_token' => $request->device_token, 'lang' => $request->language, 'api_token' => Str::random(60)]);

            if ($request->verified_office == 1) {
                $user->verified_office = 1;
                $user->save();
            }
            $package = Package::where("title_en", "gift credit")->where('is_enable' , 1)->where('user_type' , $request->type_usage)->first();
            if (isset($package)) {
                $countDay = optional($package)->count_day;
                $today = date("Y-m-d");
                $date = strtotime("+$countDay day", strtotime($today));
                $expireDate = date("Y-m-d", $date);
                $countNormal= $package->count_advertising ;
                $countPremium= $package->count_premium ;
                PackageHistory::create(['title_en' => $package->title_en, 'title_ar' => $package->title_ar, 'user_id' => $user->id, 'type' => "static", 'package_id' => $request->package_id, 'date' => date('Y-m-d'), 'is_payed' => 1, 'price' => $package->price, 'count_day' => $package->count_day, 'count_show_day' => $package->count_show_day, 'count_advertising' => $countNormal, 'count_premium' => $countPremium, 'count' => 1, 'accept_by_admin' => 1, 'expire_at' => $expireDate]);
            }
            DB::commit();
            return $this->success(trans('main.register_success'));

        } catch (\Exception $exception) {
            DB::rollback();
            return $this->fail("");
        }

    }

    // save uploaded licence image
    public function saveLicence($image)
    {
        $mainImageFile = $image;
        $fileName = $mainImageFile->getClientOriginalName();
        $storeName = uniqid(time()).$fileName;
        $path ='/resources/uploads/images/licences/'.$storeName;
        $mainImageFile->move(public_path('resources/uploads/images/licences'), $storeName);
        return $path;
    }

    // save uploaded avatar image
    public function saveAvatar($image)
    {
        $mainImageFile = $image;
        $fileName = $mainImageFile->getClientOriginalName();
        $storeName = uniqid(time()).$fileName;
        $path ='/resources/uploads/images/avatars/'.$storeName;
        $mainImageFile->move(public_path('resources/uploads/images/avatars'), $storeName);
        return $path;
    }

    public function editUser(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'licence' => 'mimes:jpeg,bmp,png|max:2048',
            'avatar' => 'mimes:jpeg,bmp,png|max:2048',
        ];

        if ( $user->isCompany ) {
            $rules['image'] = 'nullable|image|mimes:jpg,png,jpeg|max:1024';
            $rules['company_name'] = 'required|max:250';
            $rules['email'] = 'nullable|email';
            $rules['social_email'] = 'nullable|email';
            $rules['company_phone'] = 'required|digits:8|unique:users,company_phone,' . $user->id;
        }
        $validatedData = $request->validate($rules);

        $user->name = $request->name;
        $user->email = $request->email;


        $licenceFile = $request->licence;
        $avatarFile = $request->avatar;

        if (isset($licenceFile)){
            $licence = $this->saveLicence($licenceFile);
            $user->licence = $licence ;
        }
        if (isset($avatarFile)){
            $avatar = $this->saveAvatar($avatarFile);
            $user->image_profile = $avatar ;
        }
        if ( $user->isCompany ) {
            $user->company_name = $request->company_name;
            $user->company_phone = $request->company_phone;

            $request->merge(['email' => $request->social_email]);
            CompanyController::insertSocials($request, $user->id);
        }

        if($user->save()) {
            return redirect(app()->getLocale().'/profile#result')->with(['status' => 'success']);
            //return redirect()->route( 'Main.profile', app()->getLocale() )->with( [ 'status' => 'success' ] );
        } else {
            return redirect(app()->getLocale().'/profile#result')->with(['status' => 'unsuccess']);
            //return redirect()->route( 'Main.profile', app()->getLocale() )->with( [ 'status' => 'unsuccess'] );
        }
    }

    public function changePassword(Request $request)
    {
        $user = auth()->user();

        $validatedData = $request->validate([
            'current' => 'required|string|min:8',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (Hash::check($request->current, $user->password)){
            $user->password = bcrypt($request->password);
            if($user->save()) {
                return redirect(app()->getLocale().'/changepassword#result')->with(['status' => 'success']);
            } else {
                return redirect(app()->getLocale().'/changepassword#result')->with(['status' => 'unsuccess']);
            }
        } else {
            return redirect(app()->getLocale().'/changepassword#result')->with(['status' => 'dontmatch']);
        }
    }

    public function resetPassword(Request $request)
    {
        $password = $request->password;
        $mobile = $request->mobile;

        $validate = Validator::make($request->all(), [
            'password' => 'required|string|min:8',
        ]);

        if ($validate->fails())
            return $this->fail($validate->errors()->first(), -1, $validate->errors());


        $user = User::where("type", "member")->where("mobile", $mobile)->first();

        if (isset($user)) {
            $user->password = Hash::make($password);
            $user->save();
            return $this->success("");
        }
        return $this->fail(trans('main.not_exist_user'));


    }

    public function sendRequestSmsCode(Request $request)
    {
        $mobile = $request->mobile;
        $user = User::where("type", "member")->where("mobile", $mobile)->first();
        if (isset($user)) {
            $code = $this->makeSmsCode();
            $message = "Reset Password Code : " . $code;
            $user->sms_code = $code;
            $user->save();
            $result = self::sendSms($message, $mobile);
            if ($result == 100) {
                return $this->success("send verify code your device ");
            }
            return $this->fail("Server Could Not Send Sms");
        }
        return $this->fail(trans('main.not_exist_user'));
    }

    public function getBalance(Request $request)
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
            ->orderBy('id', 'desc')->get();

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
            $record = ['type' => $type, 'title_en' => $titleEn, 'title_ar' => $titleAr, 'expire_at' => $expireAt, 'count_advertising' => $count, 'count_usage' => $countUsage, 'count_premium' => $countPremium, 'count_premium_usage' => $countPremiumUsage, 'available' => $av, 'available_premium' => $avp];
            return $this->success("", $record);
        }
        return $this->fail("empty user balance");


    }

    public function payments(Request $request)
    {
        $user = auth()->user();
        $list = Payment::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(10);
        return $this->success("", $list);

    }



    public function isValidRegisterAdvertising(Request $request)
    {
        $user = auth()->user();
        try {
            $credit = $this->getCreditUser($user->id);
            if (count($credit) >= 1) {
                return $this->success("", $credit);
            }
            return $this->fail("first subscribe");

        } catch (\Exception $exception) {
            return $this->fail("error server");
        }

    }

    public function updateLanguage(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'language' => 'required|in:ar,en',
            ]);
            if ($validation->fails()) {
                return $this->fail($validation->errors()->first());
            }
            $user = auth()->user();
            User::where('id', $user->id)->update(["lang" => $request->language]);
            return $this->success("");
        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }


    }

    public function login(Request $request)
    {

        $validation = Validator::make($request->only(['mobile', 'password']), [
            'mobile' => 'required|size:8',
            'password' => 'required|min:8',
        ]);
        if ($validation->fails())
            return $this->fail($validation->errors()->first());


        $user = User::where('mobile', $request->mobile)->where("type", "member")->with("package");

        if ($user->count() == 0) {
            return $this->fail(trans('main.not_exist_user'));
        } else {

            if ($user->count() == 1 && $user->first()->is_enable) {
                if (Hash::check($request->password, $user->first()->password)) {
                    $user->first()->update(['api_token' => Str::random(60), 'device_token' => $request->device_token]);

                    return $this->success(trans('main.login_success'), ['user' => $user->first()]);
                } else
                    return $this->fail(trans('main.not_exist_combination'));
            } elseif ($user->count() == 1 && !($user->first()->is_active))
                return $this->fail(trans('main.not_active_user'));
            else
                return $this->fail(trans('main.more_than_one_user'));
        }
    }

    public function unAuthorize(Request $request)
    {
        return $this->fail(trans('main.need_login'), 401);
    }

    public function makeSmsCode()
    {
        return rand(1000, 9999);
    }

    public function userProfile(Request $request)
    {
        $user=User::whereMobile($request->mobile)->first();
        $credit=$this->getCreditUser($user->id);
        $advertises = Advertising::where('user_id', $user->id)
            ->whereNotNull('expire_at')
            ->where('expire_at' , '>' , date('Y-m-d'))
            ->orderBy('created_at', 'desc')
            ->get();
        return view('site.user.showUser',compact('user','credit','advertises'));
    }

    public function getAdvertises(Request $request)
    {
        return Advertising::where('user_id',$request['user_id'])->where('expire_at' , '>' , date('Y-m-d'))
            ->whereNotNull('expire_at')
            ->orderBy('created_at', 'desc')->with(['city','area'])->get();
    }

    ///////////////////////////////forgot password reset///////////////
    public function showLinkRequestForm(){
        return view('auth.passwords.email');
    }

    //send link
    public function sendResetLinkEmail(Request $request)
    {
        //field validation
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|digits:8|exists:users,mobile'
        ]);
        if ($validator->fails()) {
            return redirect(app()->getLocale() . '/password/reset')
                ->withErrors($validator)
                ->withInput();
        }

        if ( $request->has('resend') ){
            $otp = rand(10000, 99999);
            RegisterController::sendOtp($otp, $request->mobile);
            $request->merge(['code' => $otp ,'codeValidation' => Hash::make($otp . " : Erfan Ebrahimi : ".$request->mobile )]);
            return redirect()->back()->withInput()->with('success', __('validate_resend'));
        }
        if ( ! $request->has('code') ){
            $otp = rand(10000, 99999);
            RegisterController::sendOtp($otp, $request->mobile);
            $request->merge(['code' => $otp ,'codeValidation' => Hash::make($otp . " : Erfan Ebrahimi : ".$request->mobile )]);
            return redirect()->back()->withInput()->with('success', __('validate_send'));
        } elseif ( ! Hash::check($request->code ." : Erfan Ebrahimi : ".$request->mobile  , $request->codeValidation) )
            return redirect()->back()->withInput()->withErrors(__('invalidOTP'));


        $validator = Validator::make($request->all(), [
			'password'        => 'required|min:8|max:150|string|confirmed',
        ]);
        if ($validator->fails()) {
            return redirect(app()->getLocale() . '/password/reset')
                ->withErrors($validator)
                ->withInput();
        }

        $clientInfo = User::where("mobile", $request->mobile)->first();

        $clientInfo->password   = bcrypt($request->password);
        $clientInfo->save();


        return redirect(app()->getLocale() . '/login')
            ->with('status', trans('main.password_reset_done'));

    }

	//show reset form
	public function showResetForm(){
      return view('auth.passwords.reset');
	}

	public function resets(Request $request,$token){
    $token = $request->token;
	//field validation
	  $validator = Validator::make($request->all(),[
            'email'           => 'required|email',
			'password'        => 'required|min:3|max:150|string',
			'password-confirm'=> 'required|min:3|max:150|string|same:password',
            ],[
			'email.required'  => trans('main.email_required'),
			'password.required'      => trans('main.newpassword_required'),
			'password-confirm.required'  => trans('main.confirmpassword_required'),
			'password-confirm.same'      => trans('main.confirmpassword_mismatched'),
			]
			);
	    if ($validator->fails()) {
            return redirect(app()->getLocale().'/password/reset/'.$token)
                        ->withErrors($validator)
                        ->withInput();
        }

	$clientInfo = User::where("email",$request->email)->where("password_token",$token)->first();
	if(empty($clientInfo->id)){

	return redirect(app()->getLocale().'/password/reset/'.$token)
                        ->withErrors(['email'=>trans('main.email_not_register_or_token')])
                        ->withInput();
	}else{

	 $token = (string)Str::uuid();
	 $clientInfo->password_token=$token;
	 $clientInfo->password   = bcrypt($request->password);
	 $clientInfo->save();
	 $appendMessage  ="";
	 $appendMessage .= "<b>".trans('main.username')." : </b>".$clientInfo->mobile;
	 $appendMessage .= "<br><b>".trans('main.password')." : </b>".$request->password;
	 $data = [
	 'dear'       => trans('main.dearuser'),
	 'message'    => trans('main.password_reset_done_success')."<br><br>".$appendMessage,
	 'subject'    =>'Password Successfully Reset',
	 'email_from'      =>"noreply@googleme.com",
	 'email_from_name' =>"googleme.com"
	 ];
     Mail::to($request->email)->send(new DefaultEmail($data));

	return redirect(app()->getLocale().'/login')
	                 ->with('status',trans('main.password_reset_done'));
	}

	}


}
