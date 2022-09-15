<?php


namespace App\Http\Controllers\Api\V1;
use App\Events\UserRegistered;
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

class UserController extends ApiBaseController
{
    public function registerValidation(array $data)
    {
        return Validator::make($data, [
            'name' => 'required',
            'mobile' => 'required|digits:8|unique:users',
            'password' => 'required|min:8',
            'email' => 'required|email|unique:users',
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
        $validation=Validator::make($request->all(),['mobile' => 'required|digits:8','code'=>'required']);
        if ($validation->fails())
            return $this->fail($validation->errors()->first());

        $code=$request->code;
        $mobile=$request->mobile;
        $user= User::where("mobile",$mobile)->first();
        if(isset($user)){
            if($user->sms_code==$code){

                $user->sms_verified=1;
                $user->sms_code="";
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
                'package_id'=>$package->id,
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
            return $this->success(trans('main.register_success'));

        }catch (\Exception $exception) {
            DB::rollback();
            return $this->fail("");
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
            $validation = Validator::make($request->all(), [
                'name' => 'required',
                'mobile' => 'required|digits:8|unique:users,mobile,'.$user->id,
                'email' => 'required|email|unique:users,email,'.$user->id
            ]);
            if ($validation->fails()) {
                return $this->fail($validation->errors()->first());
            }



            if ($user) {
                $user->name=$request->name;
                $user->email=$request->email;
                $user->mobile=$request->mobile;

                $file=$request->profile_photo;
                if($file==false||$file=="false"){
                    $user->image_profile="";
                }elseif(isset($file)){
                    $user->image_profile=$this->saveFile($file);
                }
                $user->save();
                return $this->success(trans('main.success_profile_update'),['image_profile'=>$user->image_profile,'user'=>$user]);
            } else {
                return $this->fail(trans('main.invalid_user'));
            }
        } catch (\Exception $exception) {
            return $this->fail(trans('main.server_not_stable'));
        }
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

    public function resetPassword(Request $request)
    {
        $password=$request->password;
        $mobile=$request->mobile;

        $validate= Validator::make($request->all(), [
            'password' => 'required|string|min:8',
        ]);

        if ($validate->fails())
            return $this->fail($validate->errors()->first(),-1, $validate->errors());


            $user=  User::where("type","member")->where("mobile",$mobile)->first();

            if(isset($user)){
                    $user->password = Hash::make($password);
                    $user->save();
                    return $this->success("");
            }
            return $this->fail(trans('main.not_exist_user'));


    }

    public function sendRequestSmsCode(Request $request)
    {
        $mobile=$request->mobile;
        $user=  User::where("type","member")->where("mobile",$mobile)->first();
        if(isset($user)){
            $code=$this->makeSmsCode();
            $message="Reset Password Code : ".$code;
            $user->sms_code= $code;
            $user->save();
            $result= self::sendSms($message,$mobile);
            if($result==100){
                return $this->success("send verify code your device ");
            }
            return $this->fail("Server Could Not Send Sms");
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
        $list=Payment::where('user_id',$user->id)->orderBy('id','desc')->paginate(10);
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

    public function login(Request $request)
    {

       $validation= Validator::make($request->only(['mobile','password']), [
            'mobile' => 'required|size:8',
            'password' => 'required|min:8',
        ]);
        if ($validation->fails())
            return $this->fail($validation->errors()->first());


        $user = User::where('mobile',$request->mobile)->where("type","member")->with("package");

        if($user->count() == 0) {
            return $this->fail(trans('main.not_exist_user'));
        } else {

                if($user->count() == 1 && $user->first()->is_enable) {
                    if (Hash::check($request->password, $user->first()->password)) {
                        $user->first()->update(['api_token' => Str::random(60),'device_token' => $request->device_token]);

                        return $this->success(trans('main.login_success'),['user'=>$user->first()]);
                    }
                    else
                        return $this->fail(trans('main.not_exist_combination'));
                } elseif ($user->count() == 1 && !($user->first()->is_active))
                    return $this->fail(trans('main.not_active_user'));
                else
                    return $this->fail(trans('main.more_than_one_user'));
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

}
