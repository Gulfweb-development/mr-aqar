<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\City;
use App\Models\InvalidKey;
use App\Models\Setting;
use App\Models\VenueType;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    public function index()
    {
        $settings = Setting::orderBy('id', 'asc')->get();
        return view('settings.index', compact('settings'));
    }

    public function updateInvalidKeywords(Request $request)
    {
        $key=$request->invalid_keywords;
        $json=json_encode($key);
        $res= InvalidKey::first();
        if(!$res){
            InvalidKey::create(['key_title'=>$json]);
        }else{
            $res->key_title=$json;
            $res->save();
        }
        return redirect()->back();

    }
    public function invalidKeywords()
    {
        $keys=  InvalidKey::first();
        if(isset($keys)){
           $items=json_decode($keys->key_title);
        }else{
            $items=[];
        }
        return view("settings.invalid-key",compact('items'));
    }
    public function createAjax(Request $request)
    {
        try {
            Setting::create([
                'setting_key' => $request->key,
                'setting_value' => $request->value,
                'setting_placeholder' => $request->placeholder
            ]);

            return response()->json(["success" => true, "message" => "$request->key created successfully!"]);
        } catch (\Exception $exception) {
            return response()->json(["success" => false, "message" => $exception->getMessage()]);
        }
    }
    public function updateAjax(Request $request)
    {
        try {
            $setting = Setting::find($request->key);
            $setting->setting_value=$request->value;
            // if(isset($request->placeholder)){
            //     $setting->setting_placeholder=$request->placeholder;
            // }
            if(isset($request->is_enable)){
                $setting->is_enable=$request->is_enable=="true"??0;
            }
            $setting->save();
            return response()->json(["success" => true, "message" => "$setting->setting_key updated successfully!"]);
        } catch (\Exception $exception) {
            return response()->json(["success" => false, "message" => $exception->getMessage()]);
        }
    }
    public function removeAjax(Request $request)
    {
        try {
            $setting = Setting::find($request->key);
            $setting_key = $setting->setting_key;
            $setting->delete();

            return response()->json(["success" => true, "message" => "$setting_key removed successfully!"]);
        } catch (\Exception $exception) {
            return response()->json(["success" => false, "message" => $exception->getMessage()]);
        }
    }

    public function venueType(Request $request)
    {
        $venueType = VenueType::orderBy('id','desc');
        if(! is_null($request->title_en)){
            $venueType=$venueType->where('title_en','like',"%".$request->title_en."%");
        }
        if(! is_null($request->title_ar)){
            $venueType=$venueType->where('title_ar','like',"%".$request->title_ar."%");
        }

        $venueType=$venueType->paginate(30);
        return view('venueType.index', compact('venueType'));
    }

    public function storeVenueType(Request $request)
    {
        VenueType::create(['title_en' => $request->name_en,'title_ar'=>$request->name_ar,'type'=>$request->type]);
        return redirect(route('venueType'));
    }

    public function updateVenueType(Request $request)
    {
        try {
            VenueType::find($request->venueType)->update(['title_en' => $request->title_en,'title_ar'=>$request->title_ar,'type'=>$request->type]);
            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }

    }

    public function destroyVenueType($item)
    {
        $item = VenueType::find($item);
        $item->delete();
        return redirect(route('venueType'));

    }



    public function getVenueTypeByType($type)
    {

        $venueType=VenueType::where("type",$type)->get();
        return response()->json($venueType);


    }







}
