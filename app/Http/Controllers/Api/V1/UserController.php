<?php


namespace App\Http\Controllers\Api\V1;
use App\Events\UserRegistered;
use App\Http\Controllers\site\CompanyController;
use App\Mail\VerifiedMail;
use App\Models\Package;
use App\Models\PackageHistory;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\Social;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends ApiBaseController
{
    public function registerValidation(array $data)
    {
        $len = strlen(self::makeSmsCode());
        return Validator::make($data, [
            //'name' => 'required',
            'mobile' => 'required|digits:8|unique:users',
            'password' => 'required|min:8',
            'code' => 'required|digits:'.$len,
            'token' => 'required',
            //'email' => 'required|email|unique:users',
            'type_usage'=>'required|in:company,individual',
            'language'=>'required|in:ar,en',
        ]);
    }

    public function passwordValidation(array $data)
    {
        return Validator::make($data, [
            'password' => 'required|string|min:8|confirmed',
        ]);
    }



    public function sendSmsCode(Request $request)
    {

        $validation=Validator::make($request->all(),['mobile' => 'required|digits:8']);
        if ($validation->fails())
            return $this->fail($validation->errors()->first());

        try{
            $mobile=$request->mobile;
            $user= User::where("mobile",$mobile)->first();
            if(!is_null($user)){
                $code=rand(10000,99999);
                $message="Activation Code : ".$code;
                $user->sms_code=$code;
                $user->save();
                self::sendSms($message,$mobile);
                return $this->success(trans("main.successfully_send_verify_code"));
            }
            return $this->fail(trans("main.user_not_found"));
        }catch (\Exception $e){
            return $this->fail($e->getMessage());
        }


    }

    public function verifyUserBySmsCode(Request $request)
    {
        $validation=Validator::make($request->all(),['mobile' => 'required','code'=>'required']);
        if ($validation->fails())
            return $this->fail($validation->errors()->first());

        $code=$request->code;
        $mobile=$request->get('mobile' , 'ERFANEBRAHIMI');
        $user=  User::where("type","member")->where(function ($query) use ($mobile) {
            $query->where("mobile",$mobile)
                ->orWhere("email",$mobile);
        })->first();
        if($user){
            if($user->sms_code==$code){

                $user->sms_verified=1;
                $user->sms_code="";
                $user->api_token = Str::random(60);
                $user->save();
                return $this->success("",$user);
            }
            return $this->fail(trans("main.sms_code_is_not_valid"));
        }
        return $this->fail(trans("main.user_not_found"));
    }

    public function updateDeviceToken(Request $request)
    {
        $user = auth()->user();
        if(isset($request->device_token) && $request->device_token!="null" && $request->device_token!="")
            User::whereId($user->id)->update(['device_token'=>$request->device_token]);


        return $this->success("");
    }

    public function register(Request $request)
    {
        try{
            $validate = $this->registerValidation($request->all());
            if ($validate->fails())
                return $this->fail($validate->errors()->first());

            $decrypted = Crypt::decryptString($request->token);
            $data = unserialize($decrypted);
            if ( $data['code'] != $request->code or $data['phone'] != $request->mobile )
                return $this->fail(trans('invalidOTP'));

            DB::beginTransaction();
            $package = Package::where("title_en", "gift credit")->where('is_enable' , 1)->where('user_type' , $request->type_usage)->first();
            $user= User::makeUser([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>bcrypt($request->password),
                'type_usage'=>$request->type_usage,
                'company_name'=>$request->company_name,
                'mobile'=>$request->mobile,
                'device_token'=>$request->device_token,
                'lang'=>$request->language,
                'package_id'=> optional($package)->id,
                'api_token'=>Str::random(60)
            ]);

            if($request->verified_office==1){
                $user->verified_office=1;
                $user->save();
            }

            if(isset($package)){
                $countDay=optional($package)->count_day;
                $today=   date("Y-m-d");
                $date = strtotime("+$countDay day", strtotime($today));
                $expireDate=date("Y-m-d",$date);
                $countNormal= $package->count_advertising ;
                $countPremium= $package->count_premium ;
                PackageHistory::create(['title_en'=>$package->title_en,'title_ar'=>$package->title_ar,'user_id'=>$user->id,'type'=>"static",'package_id'=>$package->id,'date'=>date('Y-m-d'),'is_payed'=>1,'price'=>$package->price,'count_day'=>$package->count_day,'count_show_day'=>$package->count_show_day,'count_advertising'=>$countNormal,'count_premium'=>$countPremium,'count'=>1,'accept_by_admin'=>1,'expire_at'=>$expireDate]);
            }
            DB::commit();
            event(new UserRegistered($user));

            $user = User::where('mobile',$user->mobile)->where("type","member")->with("package");
            return $this->success(trans('main.register_success'),['user'=>$user->first()]);
        }catch (\Exception $exception) {
            DB::rollback();
            return $this->fail(trans('un_success_alert_title'));
        }

    }

    public function registerSendOTP(Request $request){
        try {
            if ( $request->has('mobile')) {
                $validation = Validator::make($request->all(), [
                    'mobile' => 'required|digits:8|unique:users',
                ]);
                if ($validation->fails())
                    return $this->fail($validation->errors()->first());
                $code=$this->makeSmsCode();
                $message="Verification Code : ".$code;
                $result= self::sendSms($message,$request->mobile);
                $token = Crypt::encryptString(serialize(['code' => $code , 'phone' => $request->mobile]));
                if($result==100){
                    return $this->success(trans('validate_send'), ['token' => $token]);
                }
                return $this->fail("Server Could Not Send Sms");
            } elseif ( $request->has('token')) {
                $decrypted = Crypt::decryptString($request->token);
                $data = unserialize($decrypted);
                $message="Verification Code : ".$data['code'];
                $result= self::sendSms($message,$data['phone']);
                if($result==100){
                    return $this->success(trans('validate_resend'), ['token' => $request->token]);
                }
                return $this->fail("Server Could Not Send Sms");
            } else {
                return $this->fail("Server Could Not Send Sms");
            }
        } catch (\Exception $exception){
            return $this->fail(trans('un_success_alert_title'));
        }
    }

    public function saveLicense(Request $request)
    {
        $user = auth()->user();
        $validation=Validator::make($request->all(), [
            'image' => 'required|mimes:jpeg,bmp,png|max:2048',
        ]);
        if ($validation->fails())
            return $this->fail($validation->errors()->first());


        if($request->hasFile('image')){
            $p = $this->saveImage($request->image);
            User::whereId($user->id)->update(["licence"=>$p]);
        }

        return $this->success("",['user'=>User::find($user->id)]);

    }

    public function updateProfile(Request $request)
    {
        try {
            $user = auth()->user();
            $rules = [
                'email' => 'nullable|email|unique:users,email,' . $user->id,
                'licence' => 'mimes:jpeg,bmp,png|max:2048',
                'avatar' => 'mimes:jpeg,bmp,png|max:2048',
            ];
            if ($user->isCompany) {
                $rules['company_name'] = 'required|max:250';
                $rules['company_phone'] = 'required|digits:8|unique:users,company_phone,' . $user->id;
            }
            $validation = Validator::make($request->all(),$rules);
            if ($validation->fails()) {
                return $this->fail($validation->errors()->first());
            }

            $user->name = $request->name;
            $user->email = $request->email;


            $licenceFile = $request->licence;
            $avatarFile = $request->avatar;

            if (isset($licenceFile)) {
                $licence = $this->saveLicence($licenceFile);
                $user->licence = $licence;
            }
            if (isset($avatarFile)) {
                $avatar = $this->saveAvatar($avatarFile);
                $user->image_profile = $avatar;
            }
            if ($user->isCompany) {
                $user->company_name = $request->company_name;
                $user->company_phone = $request->company_phone;
                CompanyController::insertSocials($request, $user->id);
            }

            if ($user->save()) {
                return $this->success(trans('main.success_profile_update'),
                    ['image_profile'=>$user->image_profile,'user'=>$user]);
            } else {
                return $this->fail(trans('main.server_not_stable'));
                //return redirect()->route( 'Main.profile', app()->getLocale() )->with( [ 'status' => 'unsuccess'] );
            }
        } catch (\Exception $exception) {
            return $this->fail(trans('main.server_not_stable'));
        }
    }


    private function saveAvatar($file){
        $mainImageFile = $file;
        $fileName = $mainImageFile->getClientOriginalName();
        $storeName = uniqid(time()) . $fileName;
        $path = '/resources/uploads/images/avatars/' . $storeName;
        $mainImageFile->move(public_path('resources/uploads/images/avatars'), $storeName);
        return $path;
    }

    public function changePassword(Request $request)
    {
        try {
            $user = $request->user();
            if ($user) {
                if (Hash::check($request->old_password, $user->password)) {

                    $validate = $this->passwordValidation($request->all());

                    if ($validate->fails())
                        return $this->fail($validate->errors()->first(),-1, $validate->errors());


                    $user->password=bcrypt($request->password);
                    $user->save();

                    return $this->success(trans('main.password_update_successfully'));
                } else {
                    return $this->fail(trans('main.old_password_is_incorrect'));
                }
            } else {
                return $this->fail(trans('main.invalid_user'));
            }
        } catch (\Exception $exception) {
            return $this->fail(trans('main.server_not_stable'));
        }
    }

    public function deleteAccount(Request $request)
    {
        try {
            $user = $request->user();
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    $user->delete();
                    return $this->success(trans('main.password_update_successfully'));
                } else {
                    return $this->fail(trans('main.old_password_is_incorrect'));
                }
            } else {
                return $this->fail(trans('main.invalid_user'));
            }
        } catch (\Exception $exception) {
            return $this->fail(trans('main.server_not_stable'));
        }
    }

    public function resetPassword(Request $request)
    {
        $password=$request->password;
        $mobile=$request->get('mobile' , 'ERFANEBRAHIMI');

        $validate= Validator::make($request->all(), [
            'password' => 'required|string|min:8',
            'api_token' => 'required'
        ]);

        if ($validate->fails())
            return $this->fail($validate->errors()->first(),-1, $validate->errors());


        $user=  User::where("type","member")->where(function ($query) use ($mobile) {
            $query->where("mobile",$mobile)
                ->orWhere("email",$mobile);
        })->where("api_token",$request->api_token)->with("package")->first();
        if($user){
            $user->password = Hash::make($password);
            $user->api_token = Str::random(60);
            $user->device_token = $request->device_token;
            $user->save();
            return $this->success(trans('main.login_success'),['user'=>$user]);
        }
        return $this->fail(trans('main.not_exist_user'));


    }

    public function sendRequestSmsCode(Request $request)
    {
        $mobile=$request->get('mobile' , 'ERFANEBRAHIMI');
        $user=  User::where("type","member")->where(function ($query) use ($mobile) {
            $query->where("mobile",$mobile)
                ->orWhere("email",$mobile);
        })->first();
        if($user){
            $email = $user->email;
            $emailMask = $email ? preg_replace('/\B[^@.]/', '*', $email) : false;
            $code=$this->makeSmsCode();
            $message="Reset Password Code : ".$code;
            $user->sms_code= $code;
            $user->save();
            if($request->get('resendEmail' , false) and $email != null ) {
                \Illuminate\Support\Facades\Mail::to($email)->send(new VerifiedMail($user, $code));
                return $this->success("send verify code to your email: ".$emailMask , compact('emailMask'));
            } else {
                $result = self::sendSms($message, $user->mobile);
                if ($result == 100) {
                    return $this->success("send verify code your device " , compact('emailMask'));
                } elseif( $email != null ) {
                    \Illuminate\Support\Facades\Mail::to($email)->send(new VerifiedMail($user, $code));
                    return $this->success("send verify code to your email: " . $emailMask, compact('emailMask'));
                }
            }
            return $this->fail("Server Could Not Send Sms Or Email");
        }
        return $this->fail(trans('main.not_exist_user'));
    }

    public function getBalance(Request $request)
    {
        $user = auth()->user();
        $date=date("Y-m-d");
        User::where('id',$user->id)->update(['last_activity'=>date("Y-m-d")]);
        $listBalance= PackageHistory::where("user_id",$user->id)
            ->where("expire_at",">",$date)
            ->where("is_payed",1)
            ->where('accept_by_admin',1)
            ->whereColumn('count_advertising','>=','count_usage')
            ->whereColumn('count_premium','>=','count_usage_premium')
            ->orderBy('id','desc')->get();

        if($listBalance->count()>=1){
            $expireAt=$listBalance[0]->expire_at;
            $type=$listBalance[0]->type;
            $titleAr=$listBalance[0]->itle_ar;
            $titleEn=$listBalance[0]->title_en;

            $count=0;
            $countPremium=0;
            $countUsage=0;
            $countPremiumUsage=0;
            foreach ($listBalance as $item) {
                $count+=$item->count_advertising;
                $countPremium+=$item->count_premium;
                $countUsage+=$item->count_usage;
                $countPremiumUsage+=$item->count_usage_premium;
            }
            $av=$count-$countUsage;
            $avp=$countPremium-$countPremiumUsage;
            $record=['type'=>$type,'title_en'=>$titleEn,'title_ar'=>$titleAr,'expire_at'=>$expireAt,'count_advertising'=>$count,'count_usage'=>$countUsage,'count_premium'=>$countPremium,'count_premium_usage'=>$countPremiumUsage,'available'=>$av,'available_premium'=>$avp];
            return $this->success("",$record);
        }
        return $this->fail("empty user balance");


    }

    public function payments(Request $request)
    {
        $user=auth()->user();
        $list=Payment::where('user_id',$user->id)->orderBy('id','desc')->paginate(30);
        return $this->success("",$list);

    }


    public function isValidRegisterAdvertising(Request $request)
    {
        $user=auth()->user();
        try {
            $credit=$this->getCreditUser($user->id);
            if(count($credit)>=1){
                return $this->success("",$credit);
            }
            return $this->fail("first subscribe");

        }catch (\Exception $exception){
            return $this->fail("error server");
        }

    }

    public function updateLanguage(Request $request)
    {
        try{
            $validation = Validator::make($request->all(), [
                'language' => 'required|in:ar,en',
            ]);
            if ($validation->fails()) {
                return $this->fail($validation->errors()->first());
            }
            $user=auth()->user();
            User::where('id',$user->id)->update(["lang"=>$request->language]);
            return $this->success("");
        }catch (\Exception $e){
            return $this->fail($e->getMessage());
        }



    }

    public function profile(){
        $user=auth()->user();
        $user = User::where('id',$user->id)->where("type","member")->with("package","socials");
        return $this->success("",['user'=>$user->first()]);
    }

    public function login(Request $request)
    {

        $validation= Validator::make($request->only(['mobile','password']), [
            'mobile' => 'required|size:8',
            'password' => 'required|min:8',
        ]);
        if ($validation->fails())
            return $this->fail($validation->errors()->first());


        $user = User::where('mobile',$request->mobile)->where("type","member")->with("package","socials");

        if($user->count() == 0) {
            return $this->fail(trans('main.not_exist_user'));
        } else {

            //if($user->count() == 1 && $user->first()->is_enable) {
            if (Hash::check($request->password, $user->first()->password)) {
                $user->first()->update(['api_token' => Str::random(60),'device_token' => $request->device_token]);

                return $this->success(trans('main.login_success'),['user'=>$user->first()]);
            }
            else
                return $this->fail(trans('main.not_exist_combination'));
            //} elseif ($user->count() == 1 && !($user->first()->is_active))
            //    return $this->fail(trans('main.not_active_user'));
            //else
            //    return $this->fail(trans('main.more_than_one_user'));
        }
    }

    public function unAuthorize(Request $request)
    {
        return $this->fail(trans('main.need_login'),401);
    }

    public function makeSmsCode()
    {
        return rand(1000,9999);
    }

    public function upgrade(Request $request){
        $validation=Validator::make($request->all(),[
            'image' => 'nullable|mimes:jpeg,bmp,png|max:2048',
            'company_name'=>'required',
            'company_phone'=>'required',
        ]);
        if ($validation->fails())
            return $this->fail($validation->errors()->first());

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
        $user = User::where('id',$user_id)->with("package","socials")->first();
        return $this->success(__('upgraded_to_company'),['user'=>$user]);
    }

    public function downgrade()
    {
        $balance = \App\Http\Controllers\site\MainController::getBalance();
        if ($balance !== 0)
            return $this->fail(__('packageNotFinished'));
        $user = auth()->user();
        $user_id = $user->id;

        User::where('id', $user_id)->update([
            'company_phone' => null,
            'type_usage' => 'individual',
        ]);
        $user = User::where('id',$user_id)->with("package","socials")->first();
        return $this->success(__('account_downgraded_successfully'),['user'=>$user]);
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



    public function report($id){
        $company = User::where('type_usage', 'company')->findOrFail($id);
        $company->reported += 1;
        $company->save();
        return $this->success( trans('user').trans('has_been_reported_successfully'));
    }

}
