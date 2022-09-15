<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\Site\RegisterRequest;
use App\Models\Package;
use App\Models\PackageHistory;
use App\Models\Setting;
use App\Providers\RouteServiceProvider;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }





    /**
     * all codes like mobile api for sms verification
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    // first : user inputs validation and sending sms code
    /**
     * @param RegisterRequest|Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $this->registerValidation();
        try {

            DB::beginTransaction();
            if ($request->has('resend')) {
                $otp = rand(10000, 99999);
                $this->sendOtp($otp, $request->mobile);
                $request->merge(['code' => $otp, 'codeValidation' => Hash::make($otp . " : Erfan Ebrahimi : " . $request->mobile)]);
                return redirect()->back()->withInput()->with('success', __('validate_resend'));
            }
            if (!$request->has('code')) {
                $otp = rand(10000, 99999);
                $this->sendOtp($otp, $request->mobile);
                $request->merge(['code' => $otp, 'codeValidation' => Hash::make($otp . " : Erfan Ebrahimi : " . $request->mobile)]);
                return redirect()->back()->withInput()->with('success', __('validate_send'));
            } elseif (!Hash::check($request->code . " : Erfan Ebrahimi : " . $request->mobile, $request->codeValidation))
                return redirect()->back()->withInput()->withErrors(__('invalidOTP'));


            $request->merge(['type_usage' => 'individual']);
            $package = Package::where("title_en", "gift credit")->where('is_enable', 1)->where('user_type', $request->type_usage)->first();

            $user = User::makeUser([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'type_usage' => 'individual',
                'mobile' => $request->mobile,
                'lang' => 'en',
                'image_profile' => '/images/main/profile.jpg'
            ]);
            /*
            if($request->verified_office==1){
                $user->verified_office=1;
                $user->save();
            }
            */

            if (isset($package)) {
                $countDay = optional($package)->count_day;
                $today = date("Y-m-d");
                $date = strtotime("+$countDay day", strtotime($today));
                $expireDate = date("Y-m-d", $date);
                $countNormal = $package->count_advertising;
                $countPremium = $package->count_premium;
                PackageHistory::create([
                    'title_en' => $package->title_en,
                    'title_ar' => $package->title_ar,
                    'user_id' => $user->id,
                    'type' => "static",
                    'package_id' => $package->id,
                    'date' => date('Y-m-d'),
                    'is_payed' => 1,
                    'price' => $package->price,
                    'count_day' => $package->count_day,
                    'count_show_day' => $package->count_show_day,
                    'count_advertising' => $countNormal,
                    'count_premium' => $countPremium,
                    'count' => 1,
                    'accept_by_admin' => 1,
                    'expire_at' => $expireDate
                ]);
            }
            DB::commit();
            // event(new UserRegistered($user));
            Auth::loginUsingId($user->id);
            return redirect()->route('Main.index', app()->getLocale())->with('controller-success', trans('main.register_success'));

        } catch (\Exception $exception) {
            DB::rollback();
            return $this->fail($exception->getMessage());
        }

    }

    public function registerValidation()
    {
        return $this->validate(request(), [
            // 'name' => 'required',
            'mobile' => 'required|digits:8|unique:users',
            'password' => 'required|min:8|confirmed',
            // 'email' => 'required|email|unique:users',
            // 'type_usage'=>'required|in:company,individual',
            //'type_usage'=>'required|in:individual',
            // 'language'=>'required|in:ar,en',
        ]);
    }



    /**
     *
     */


    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'digits:8', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'type_usage' => ['required', 'in:company,individual'],
            'lang' => ['required', 'in:ar,en']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }


    public static function sendOtp($otp, $mobile)
    {
        $message="Verification code: ".$otp;
        $mobile = \Illuminate\Support\Str::startsWith($mobile, '965') ? substr($mobile,3) : $mobile ;
        return parent::sendSms($message,$mobile);
    }
}
