<?php


namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\City;
use Illuminate\Http\Request;

class CityAndAreaController extends Controller
{
    public function area(Request $request)
    {

        $cities = City::all();
        $areas = Area::with('city')->orderBy('id','desc');
        if(isset($request->cityId)){
            $areas=$areas->where('city_id',$request->cityId);
        }

        if(! is_null($request->name_en)){
            $areas=$areas->where('name_en','like',"%".$request->name_en."%");
        }
        if(! is_null($request->name_ar)){
            $areas=$areas->where('name_ar','like',"%".$request->name_ar."%");
        }


        $areas=$areas->paginate(30);
        return view('area.index', compact('cities', 'areas'));
    }
    public function storeArea(Request $request)
    {
        Area::create(['city_id' => $request->city_id,'name_en' => $request->name_en,'name_ar'=>$request->name_ar]);
        return redirect(route('areas'));
    }
    public function updateArea(Request $request)
    {
        try {
            Area::find($request->area)->update(['city_id'=>$request->city_id,'name_en' => $request->name_en,'name_ar'=>$request->name_ar]);
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
    public function destroyArea($area)
    {
        $item = Area::find($area);
        $item->delete();
        return redirect(route('areas'));
    }


    public function city(Request $request)
    {
        $cities = City::all();
        return view("city.index",compact("cities"));


    }
    public function storeCity(Request $request)
    {
        City::create(['name_en' => $request->name_en,'name_ar'=>$request->name_ar]);
        return redirect(route('cities'));
    }
    public function destroyCity($area)
    {
        $item = City::find($area);
        $item->delete();
        return redirect(route('cities'));
    }
    public function updateCity(Request $request)
    {
        try {
            City::find($request->id)->update(['name_en' => $request->name_en,'name_ar'=>$request->name_ar]);
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

}
