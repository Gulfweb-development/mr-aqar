<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\site\CompanyController;
use App\Models\Advertising;
use App\Models\Package;
use App\Models\PackageHistory;
use App\Models\Social;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MembersController extends Controller
{

    public function balanceHistory($userId)
    {
        $list= PackageHistory::where('user_id',$userId)->get();
        return view("members.balance",compact('list'));
    }
    public function createValidator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required','unique:users','email', 'max:191'],
            'mobile' => ['required','unique:users'],
            'type_usage' => ['required'],
            'image_profile' => ['nullable', 'mimes:jpeg,jpg,png,gif', 'max:512000'],
            'licence' =>['nullable', 'mimes:jpeg,jpg,png,gif', 'max:819200'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
    public function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:191'],
            'email' => ['nullable', 'string', 'email', 'max:191'],
            'mobile' => ['required', 'string'],
            'image_profile' => ['nullable', 'file', 'max:512000'],
            'licence' =>['nullable', 'file', 'max:819200'],
        ]);
    }
    public function passwordValidator(array $data)
    {
        return Validator::make($data, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function customValidator(array $data, $userId)
    {
        $errors = [];
        $user = User::find($userId);
        if ($user->mobile != $data['mobile']) {
            if (User::where('mobile', 'LIKE', $data['mobile'])->count() > 0) {
                $errors['mobile'] = 'This mobile number is already taken.';
            }
        }

        if ($user->email != $data['email']) {
            if (User::where('email', 'LIKE', $data['email'])->count() > 0) {
                $errors['email'] = 'This email address is already taken.';
            }
        }

        return $errors;
    }

    public function index()
    {
        $search=\request()->search;


        $route=\request()->route()->getName();
        ///dd($route);
        if (Auth::user()->type == 'admin') {

            $members = User::where('type', 'LIKE','member')->with(["package","advertising"]);

            if($route=="members.individual"){
                $members=$members->where('type_usage','!=','company');
            }
            if($route=="members.company"){
                $members=$members->where('type_usage','company');
            }


            if(!empty($search)){
                $members=$members->where(function($r)use($search){
                    $r->where("name","like","%".$search."%")
					  ->orWhere("mobile","like","%".$search."%")
					  ->orWhere("email","like","%".$search."%");
                });
            }



            $members=$members->orderBy('id','desc')->paginate(30);
            //$companyMembers=$companyMembers->orderBy('id','desc')->paginate(30);
            return view('members.index', compact('members'));
        } else {
            return redirect()->route("dashboard");
        }
    }

    public function notActiveMembers(Request $request)
    {
        $search=\request()->search;

        $route=\request()->route()->getName();

        if (Auth::user()->type == 'admin') {
            $members = User::where('type', 'LIKE','member')->with(["package","advertising"]);



            if($route!="members.notActiveCompany"){
                $members=$members->where('type_usage','!=','company');
            }else{
                $members=$members->where('type_usage','company');
            }
            if(isset($search)){
                $members=$members->where(function ($r)use($search){
                    $r->where("name","like","%".$search."%")->orWhere("mobile","like","%".$search."%");
                });
            }

            $members=$members->where('verified',0)->where('verified_office',0)->where('licence','!=',null)->where('licence','!=',"")->orderBy('id','desc')->paginate(30);
            //$companyMembers=$companyMembers->orderBy('id','desc')->paginate(30);
            return view('members.not-verified', compact('members'));
        } else {
            return redirect()->route("dashboard");
        }
    }

    public function create()
    {
        $packages=Package::getPackageList();
        return view('members.create',compact("packages"));
    }

    public function store(Request $request)
    {
        $this->createValidator($request->all())->validate();
        $user=User::makeUser(["name"=>$request->name,"email"=>$request->email,"mobile"=>$request->mobile,"password"=>bcrypt($request->password),"type_usage"=>$request->type_usage]);
        if($request->hasFile("image_profile")) {
         $user->image_profile=$this->saveFile($request->image_profile);
        }
        if($request->hasFile("licence")){
            $user->licence=$this->saveFile($request->licence);
        }
        if($request->is_enable=="on"){
            $user->is_enable=1;
        }
        if($request->verifed=="on"){
            $user->verifed=1;
        }
        if(isset($request->package_id)){
            $user->package_id=$request->package_id;
        }

        $user->save();

        return redirect()->back()->with("success",true);
    }

    public function edit($user)
    {
        $user = User::find($user);
        $packages=Package::getPackageList();
        return view('members.edit', compact('user','packages'));
    }

    public function verify($user)
    {
        $user = User::find($user);
        return view('members.verify', compact('user'));
    }

    public function setVerify(Request $request)
    {
        $user=User::find($request->user_id);
        if($request->hasFile("licence")){
            $user->licence=$this->saveFile($request->licence);
        }
        if($request->verified!=1){
            $user->verified=0;
        }else{
            $user->verified=1;
        }
        $user->save();

        return redirect()->back()->with("success",true);


    }

    public function update(Request $request, $userId)
    {
        $user = User::find($userId);
        if ($user->isCompany) {
            $this->validate($request, [
                'company_name' => 'required',
                'company_phone' => 'required|digits:8|unique:users,company_phone,' . $user->id,
            ]);
        }
        $this->validator($request->only(['name', 'email', 'mobile']))->validate();
        $errors = $this->customValidator($request->only(['email', 'mobile']), $user->id);

        if (count($errors) > 0)
            return redirect(route('members.edit', $userId))
                ->withErrors($errors)
                ->withInput();

        if ($request->password)
            $this->passwordValidator($request->only(['password', 'password_confirmation']))->validate();

        if($request->hasFile("licence")){
            $user->licence=$this->saveFile($request->licence);
        }
        if($request->hasFile("image_profile")){
            $user->image_profile=$this->saveFile($request->image_profile);
        }


        if($request->is_enable!=1){
            $user->is_enable=0;
        }else{
            $user->is_enable=1;
        }

        if($request->verified!=1){
            $user->verified=0;
        }else{
            $user->verified=1;
        }
        if($request->verified_office!=1){
            $user->verified_office=0;
        }else{
            $user->verified_office=1;
        }

        $user->name=$request->name;
        $user->email=$request->email;
        $user->mobile=$request->mobile;

        if ($user->isCompany) {
            $user->company_name=$request->company_name;
            $user->company_phone=$request->company_phone;
        }

        $user->password= $request->password ? Hash::make($request->password) : $user->password;
        $user->save();

        if ($user->isCompany) {
            $request->merge(['email' => $request->social_email]);
            CompanyController::insertSocials($request, $userId);
        }

        return redirect()->route('members.index')->with("success",true);
    }

    public function destroy($user)
    {
        User::find($user)->delete();
        Social::where('user_id',$user)->delete();
        Advertising::where('user_id',$user)->delete();
       // PackageHistory::where('user_id',$user)->delete();
        return redirect(route('members.index'));
    }

    public function show($userId)
    {
        $user=User::with(["advertising","package"])->find($userId);
        return view("members.view",compact("user"));

    }

    public function advertisingList($userId){
        $user=User::whereId($userId)->first();
        $advertises = Advertising::where('user_id', $user->id)
            ->whereNotNull('expire_at')
            ->where('expire_at' , '>' , date('Y-m-d'))
            ->orderBy('created_at', 'desc')
            ->get();
        return view('members.showUserAdvertises',compact('user','advertises'));
    }

}
