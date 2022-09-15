<?php


namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Advertising;
use App\Models\Area;
use App\Models\City;
use App\Models\VenueType;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdvertisingController extends Controller
{

    public function index(Request $request)
    {
        $routeName=$request->route()->getName();
           if($routeName=="advertising.index"){
               $type="individual";
           }else{
               $type="company";
           }
        $advertising=self::filterAdvertising($request);
        $advertising=$advertising->whereHas("user",function ($r)use($type){
            $r->where("type_usage",$type);
        })->paginate(20);

        $city=City::all();
        $area=Area::all();

        $users=User::where("users.type","member")->where('users.is_enable',1);
		$users = $users->select('users.*','users.id as uid','advertisings.*')->join('advertisings','advertisings.user_id','=','users.id');
		$users = $users->groupBy('users.id')->get();
        return view("advertising.index",compact('advertising','users','area','city','type'));
    }
    public function createForm()
    {
        $city=City::all();
        $area=Area::all();
        $users=User::where("type","member")->get();
        $venueType=VenueType::where('type','Residential')->get();
        return view('advertising.create',compact('area','city','users','venueType'));


    }
    public function create(Request $request)
    {
            Validator::make($request->all(), [
                // 'title_en' => 'required',
                'user_id'=>"required"
            ])->validate();

           $area=Area::find($request->area_id);
           $user=User::find($request->user_id);
           $advertising= new Advertising();
           $advertising->user_id=$user->id;
           $advertising->area_id=$request->area_id;
           $advertising->city_id=$area->city_id;

           $today=   date("Y-m-d");
           $date = strtotime("+30 day",strtotime($today));
           $expireDate=date("Y-m-d",$date);

           $advertising->expire_at=$expireDate;
           $advertising->hash_number = Advertising::makeHashNumber();
           $this->updateAdvertising($request,$advertising);
           if($user->type_usage=="company"){
               $route="advertising.indexCompanies";
           }else{
               $route="advertising.index";
           }
           return redirect()->route($route)->with("success",true);

    }
    public function view($id)
    {
       $advertising= Advertising::with(["area","city","user.package"])->find($id);
        $imagePath=[];
        if($advertising->other_image!=null){
            $imagePath=json_decode($advertising->other_image);
        }

        return view('advertising.view',compact('advertising','imagePath'));
    }
    public function destroy($id)
    {
        Advertising::find($id)->delete();
        return redirect()->back();
    }
    public function accept($id)
    {
        Advertising::find($id)->update(['status'=>"accepted"]);
        return redirect()->back();

    }
    public function getDetails($id)
    {
        $advertising=Advertising::with(["user","area","city"])->find($id);
        $venueType=VenueType::where('type',$advertising->type)->get();
        $imagePath=[];
        if($advertising->other_image!=null){
            $imagePath=json_decode($advertising->other_image);
        }

        return view('advertising.details',compact("advertising","imagePath",'venueType'));

    }















    public static function filterAdvertising($request)
    {
        $advertising=Advertising::with(["user","area","city"]);
        if(isset($request->fromDate)){
            $fromDate=self::returnDateTimeFormat($request->fromDate);
            $advertising=$advertising->where('created_at','>=',$fromDate);
        }

        if(isset($request->toDate)){
            $toDate=self::returnDateTimeFormat($request->toDate);
            $advertising=$advertising->where('created_at','<=',$toDate);
        }

        if(isset($request->min_price) && !empty($request->min_price)){
            $advertising=$advertising->where('price','>=',$request->min_price);
        }

        if(isset($request->max_price) && !empty($request->max_price)){
            $advertising=$advertising->where('price','<=',$request->max_price);
        }
        if(isset($request->area_id) && $request->area_id!="all"){
            $advertising=$advertising->where('area_id',$request->area_id);
        }
		/*
        if(isset($request->city_id) && $request->city_id!="all"){
            $advertising=$advertising->where('city_id',$request->city_id);
        }
		*/
        if(isset($request->user_id) && $request->user_id!="all"){
            $advertising=$advertising->where('user_id',$request->user_id);
        }

        if(isset($request->type) && $request->type!="all"){
            $advertising=$advertising->where('type',$request->type);
        }

        if(isset($request->purpose) && $request->purpose!="all"){
            $advertising=$advertising->where('purpose',$request->purpose);
        }

        if(isset($request->hash_number)){
            $advertising=$advertising->where('hash_number', $request->hash_number);
        }
	  /*
      if(isset($request->venue_type) && $request->venue_type!="all"){
                $advertising=$advertising->where('venue_type',$request->venue_type);
      }
	  */
	  /*
      if(isset($request->user_type) && $request->user_type!="all"){
                $advertising=$advertising->whereHas("user",function ($r)use($request){
                    $r->where("type_usage",$request->user_type);
                });
      }*/

        $advertising=$advertising->orderBy("advertising_type","desc")->orderBy('id','desc');

        return $advertising;

    }


    public function update(Request $request)
    {
        // dd($request->all());
// dd($request->request);
        // Validator::make($request->all(), [
        //     'title_en' => ['required'],
        // ])->validate();
        $advertising=Advertising::find($request->id);
        if(isset($advertising)){
            $this->updateAdvertising($request, $advertising);
            return redirect()->back()->with("success",true);
        }




    }

    /**
     * @param Request $request
     * @param $advertising
     */
    private function updateAdvertising(Request $request, $advertising)
    {
        $advertising->title_en = $request->title_en;
        $advertising->title_ar = $request->title_ar;
        $advertising->price = $request->price;
        $advertising->type = $request->type;
        $advertising->venue_type = $request->venue_type;
        $advertising->purpose = $request->purpose;
        $advertising->advertising_type = $request->advertising_type;
        $advertising->phone_number = $request->phone_number;
        $advertising->number_of_bathrooms = $request->number_of_bathrooms;
        $advertising->number_of_parking = $request->number_of_parking;
        $advertising->number_of_balcony = $request->number_of_balcony;
        $advertising->number_of_floor = $request->number_of_floor;
        $advertising->number_of_miad_rooms = $request->number_of_miad_rooms;
        $advertising->description = $request->description;
        $advertising->surface = $request->surface;

        if (isset($request->security)) {
            $advertising->security = 1;
        } else {
            $advertising->security = 0;
        }
        if (isset($request->gym)) {
            $advertising->gym = 1;
        } else {
            $advertising->gym = 0;
        }
        if (isset($request->furnished)) {
            $advertising->furnished = 1;
        } else {
            $advertising->furnished = 0;
        }
        if (isset($request->pool)) {
            $advertising->pool = 1;
        } else {
            $advertising->pool = 0;
        }
        if (isset($request->status)) {
            $advertising->status = "accepted";
            $advertising->reject_message = "";
        } else {
            $advertising->status = "reject";
            $advertising->reject_message = $request->reject_message;
        }
// dd($request->main_image);
        if ($request->main_image != "") {
            $p = urldecode(str_replace(env("APP_URL"), "", $request->main_image));
            $advertising->main_image = $p;
        }

        if ($request->floor_plan != "") {
            $p = str_replace(env("APP_URL"), "", $request->floor_plan);
            $advertising->floor_plan = $p;
        }

        if ($request->video != "") {
            $v = str_replace(env("APP_URL"), "", $request->video);
            $advertising->video= $v;
        }

        $new_other_images = (array) optional(json_decode($advertising->other_image))->other_image;
        foreach((array) $request->deleted_images as $image) {
            if (($key = array_search($image, $new_other_images)) !== false) {
                unset($new_other_images[$key]);
            }
        }
        if ($request->other_image != "") {
// dd($request->other_image);
            $otherImage = str_replace("[", "", $request->other_image);
            $otherImage = str_replace("]", "", $otherImage);
            $otherImage = str_replace("\"", "", $otherImage);
            $otherImage = str_replace("\\", "", $otherImage);
            $path = explode(",", $otherImage);
            $newPath = [];

            foreach ($path as $key=>$item) {
                $itemImage = urldecode(str_replace(env("APP_URL"), "", $item));
                $r=intval($key)+1;
                $newPath[]=$itemImage;
            }
            // if(count($newPath)<10){
            //     $c=count($newPath)+1;
            //     for($i=$c;$i<=10;$i++){
            //         $name="other_image".$i;
            //         $newPath[$name]="";
            //     }
            // }


            $olds = isset($new_other_images) ? $new_other_images : (array) optional(json_decode($advertising->other_image))->other_image;
            $newPath = ['other_image' => array_merge($olds, $newPath)];
            $advertising->other_image = json_encode($newPath);
        } elseif(isset($new_other_images)) {
            $advertising->other_image = json_encode(['other_image' => $new_other_images]);
        }

        // delete main image if $request->delete_main
        if ($request->delete_main == 1) {
            $other_images = json_decode($advertising->other_image, true)['other_image'];
            $advertising->main_image = array_shift($other_images); // pop the first other_image to main_image
            $advertising->other_image = json_encode(['other_image' => $other_images]);
        }

        $advertising->save();
    }


}
