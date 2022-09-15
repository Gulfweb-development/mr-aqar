<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StaticPackagesController extends Controller
{
    public function createValidator(array $data)
    {
        return Validator::make($data, [
            'title_en' => ['required'],
            'title_ar' => ['required'],
            'price' => ['required','numeric'],
            'old_price' => ['nullable','numeric'],
            'count_day' => ['required','numeric'],
            'count_show_day' => ['required','numeric'],
            'count_advertising' => ['required','numeric'],
            'count_premium' => ['required','numeric'],
        ]);
    }

    public function index(Request $request)
    {
        $packages=Package::where("type","static")->where("is_visible",1)->get();
        return view("staticPackages.index",compact('packages'));
    }

    public function create()
    {
        return view('staticPackages.create');
    }
    public function store(Request $request)
    {
        $this->createValidator($request->all())->validate();
        Package::create(['type'=>"static",'title_en'=>$request->title_en,'title_ar'=>$request->title_ar,'description_en'=>$request->description_en,'description_ar'=>$request->description_ar,'note_en'=>$request->note_en,'note_ar'=>$request->note_ar,'price'=>$request->price,'old_price'=>$request->old_price,'count_day'=>$request->count_day,'count_show_day'=>$request->count_show_day,'count_advertising'=>$request->count_advertising,'count_premium'=>$request->count_premium,'user_type'=>$request->user_type]);

        return redirect(route('staticPackages.index'));
    }

    public function edit($id)
    {
        $package =Package::find($id);
        return view('staticPackages.edit', compact('package'));
    }

    public function update(Request $request, $userId)
    {
        $package = Package::find($userId);
        $this->createValidator($request->all())->validate();

        $package->update(['title_en'=>$request->title_en,'title_ar'=>$request->title_ar,'description_en'=>$request->description_en,'description_ar'=>$request->description_ar,'note_en'=>$request->note_en,'note_ar'=>$request->note_ar,'old_price'=>$request->old_price,'price'=>$request->price,'count_day'=>$request->count_day,'count_show_day'=>$request->count_show_day,'count_advertising'=>$request->count_advertising,'count_premium'=>$request->count_premium,'user_type'=>$request->user_type]);

        if($request->is_enable=="on"){
            $package->is_enable=1;
        }else{
            $package->is_enable=0;
        }

      if($request->is_premium=="on"){
                $package->is_premium=1;
       }else{
          $package->is_premium=0;
      }
      $package->save();

        return redirect(route('staticPackages.index'));
    }
    public function destroy($id)
    {
        Package::find($id)->delete();
        return redirect(route('staticPackages.index'));
    }
}
