<?php

namespace App\Http\Controllers\site;

use App\Events\NewAdvertising;
use App\Http\Controllers\Controller;
use App\Http\Requests\Site\Advertising\StoreRequest;
use App\Models\Advertising;
use App\Models\AdvertisingView;
use App\Models\Area;
use App\Models\City;
use App\Models\InvalidKey;
use App\Models\PackageHistory;
use App\Models\VenueType;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
//use function GuzzleHttp\Promise\all;

class AdvertisingController extends Controller
{
    public function search(Request $request)
    {
        $advertisings = $this->bindFilter($request);
        $advertisings = $advertisings->with(['user', 'city', 'area'])->paginate(9)->appends(request()->query());
        $cities = City::orderBy('name_en')->get();
        $areas = Area::orderBy('name_en')->get();
        if ($request->wantsJson()) {
            return $this->success("", $advertisings);
        }
//        return $advertisings;
        return view('site.search-result.search-result', compact('advertisings', 'cities', 'areas'));
    }

    /**
     * @param Request $request
     * @return Builder
     */
    private function bindFilter(Request $request): Builder
    {
        $advertising = Advertising::getValidAdvertising()->whereNotNull('expire_at')
            ->where('expire_at', '>', date('Y-m-d'))->whereHas("user");
//        dd($request->all());
//        if (isset($request->city_id) && $request->city_id != "-1") {
//            $advertising = $advertising->where("city_id", $request->city_id);
//        }
        if (isset($request->area) && $request->area != "-1") {
          $area=  Area::where('name_en',$request->area)->first();
            $advertising = $advertising->where("area_id", $area->id);
        }
        if (isset($request->advertising_type) && is_array($request->advertising_type)) {
            $advertising = $advertising->whereIn("advertising_type", $request->advertising_type);
        } elseif (isset($request->advertising_type) && $request->advertising_type != "") {
            $advertising = $advertising->where("advertising_type", $request->advertising_type);
        }
        if (isset($request->type) && is_array($request->type)) {
            $advertising = $advertising->whereIn("type", $request->type);
        } elseif (isset($request->type) && !is_null($request->type)) {
            $advertising = $advertising->where("type", $request->type);
        }

        if (isset($request->venue_type) && !is_null($request->venue_type)) {
            $advertising = $advertising->where("venue_type", $request->venue_type);
        }
        if (isset($request->purpose) && !is_null($request->purpose)) {
            $advertising = $advertising->where("purpose", $request->purpose);
        }
        if (isset($request->keyword) && !is_null($request->keyword)) {
            $advertising = $advertising->where(function ($r) use ($request) {
                $r->where('title_en', 'like', '%' . $request->keyword . '%')->orWhere('title_ar', 'like', '%' . $request->keyword . '%');
            });
        }
        if (isset($request->min_price) && $request->min_price != "") {
            $minPrice = floatval(trim(str_replace("KD", "", $request->min_price)));
            $advertising = $advertising->where("price", '>=', $minPrice);
        }
        if (isset($request->max_price) && $request->max_price != "") {
            $p = floatval(trim(str_replace("KD", "", $request->max_price)));
            $advertising = $advertising->where("price", '<=', $p);
        }
        if (isset($request->number_of_rooms) && is_numeric($request->number_of_rooms)) {
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

    // add listing

    public function create()
    {
        $cities = City::orderBy('name_en')->get();
        $types = VenueType::where('type','Residential')->orderBy('title_en')->get();
        $purposes = ['rent', 'sell', 'exchange', 'required_for_rent'];
        $credit = $this->getCreditUser(auth()->id());
        if ($credit === [])
            $credit = ['count_premium_advertising' => 0, 'count_normal_advertising' => 0];
        if ($credit['count_premium_advertising'] === 0 && $credit['count_normal_advertising'] === 0)
            return redirect()->route('Main.buyPackage', app()->getLocale())->with(['status' => 'have_no_package']);

        return view('site.advertising.create', compact('cities', 'types', 'purposes', 'credit'));
    }



    /**
     *
     * premium ads menu
     *
     */


    public function premiums()
    {
        $premiums = Advertising::where('expire_at', '>', date('Y-m-d'))
            ->where('advertising_type', 'premium')
            ->whereNotNull('expire_at')
            ->orderBy('created_at', 'desc')
            ->paginate(18);

        return view('site.pages.premiums', [
            'premiums' => $premiums,
            'sort' => 'Latest Ads'
        ]);
    }

    public function latestPremiums()
    {
        $premiums = Advertising::where('expire_at', '>', date('Y-m-d'))
            ->where('advertising_type', 'premium')
            ->whereNotNull('expire_at')
            ->orderBy('created_at', 'desc')
            ->paginate(18);

        return view('site.pages.premiums', [
            'premiums' => $premiums,
            'sort' => 'Latest Ads'
        ]);
    }

    public function highestPricePremiums()
    {
        $premiums = Advertising::where('expire_at', '>', date('Y-m-d'))
            ->where('advertising_type', 'premium')
            ->whereNotNull('expire_at')
            ->orderBy('price', 'desc')
            ->paginate(18);

        return view('site.pages.premiums', [
            'premiums' => $premiums,
            'sort' => 'Highest price Ads'
        ]);
    }

    public function lowestPricePremiums()
    {
        $premiums = Advertising::where('expire_at', '>', date('Y-m-d'))
            ->where('advertising_type', 'premium')
            ->whereNotNull('expire_at')
            ->orderBy('price', 'asc')
            ->paginate(18);

        return view('site.pages.premiums', [
            'premiums' => $premiums,
            'sort' => 'Lowest price Ads'
        ]);
    }

    public function mostVisitedPremiums()
    {
        $premiums = Advertising::withCount('advertisingView')
            ->where('expire_at', '>', date('Y-m-d'))
            ->where('advertising_type', 'premium')
            ->whereNotNull('expire_at')
            ->orderBy('advertising_view_count', 'desc')->paginate(18);

        return view('site.pages.premiums', [
            'premiums' => $premiums,
            'sort' => 'Most Visited Ads'
        ]);
    }


    //////////////////////////////////
    // delete Ads
    //////////////////////////////////

    public function delete(Request $request, Advertising $advertising)
    {
        $this->authorize('delete', $advertising);
        $ad = Advertising::find($request->adid);

        if ($ad->delete()) {
            return redirect()->route('Main.myAds',app()->getLocale())->with(['status' => 'success']);
        } else {
            return redirect()->route('Main.myAds',app()->getLocale())->with(['status' => 'unsuccess']);
        }
    }

    /////////////////////////////////
    /// advertising details
    /////////////////////////////////


    public function details($locale,$hashNumber)
    {
        $this->addView($hashNumber);
        $advertising = Advertising::where('hash_number', $hashNumber)->whereDate('expire_at' , '>=' , Carbon::now())->with(['user','city','area', 'advertisingView', 'area', 'city', 'venue'])->firstOrFail();
//          dd(collect(json_decode($advertising->other_image))->toArray());
//        return $advertising->advertisingView;
        $relateds = Advertising::where('expire_at', '>=', Carbon::now())->orderBy('id', 'desc')->where('id', '!=', $advertising->id)->limit(6)->get();
        return view('site.advertising.details', compact('advertising', 'relateds'));
    }

    public function addView($hashNumber)
    {

        if (Auth::check()) {
            $advertising = Advertising::where('hash_number', $hashNumber)->with([ 'advertisingView'=>function($q){
                $q->where('user_id', Auth::user()->id)->orWhere('guest_ip', session()->get('user_guest'));
            }])->first();
//            dd(($advertising->advertisingView));
            if (count($advertising->advertisingView) === 0) {
                $advertising->advertisingView()->create([
                    'user_id' => Auth::user()->id,
                    'guest_ip' => session()->get('user_guest')
                ]);
            }
        } else {
            $advertising = Advertising::where('hash_number', $hashNumber)->with([ 'advertisingView'=>function($q){
                $q->Where('guest_ip', session()->get('user_guest'));
            }])->first();
            if (count($advertising->advertisingView) === 0) {
                $advertising->advertisingView()->create([
                    'guest_ip' =>session()->get('user_guest')
                ]);
            }
        }

    }

    public function payment_result()
    {
        dd(\request()->all());
    }


    public function getCities()
    {
//        dd(\request()->all());
        return City::orderBy('name_en')->get();
    }

    public function getAreas()
    {
        return Area::whereCityId(\request('city_id'))->orderBy('name_en')->get();
    }


	public function getVenueTypes()
    {
        return VenueType::where('type','Residential')->orderBy('title_en')->get();
    }

    public function store(StoreRequest $request)
    {
        try {
            $result = $this->filterKeywords($request->description);

            if (!$result[0]) {
                return $this->fail("invalid Keyword (" . $result[1] . ")", -1, $request->all());
            }
            $result2 = $this->filterKeywords($request->title_en);

            if (!$result2[0]) {
                return $this->fail("invalid Keyword (" . $result2[1] . ")", -1, $request->all());
            }

            $user = auth()->user();
            $isValid = $this->isValidCreateAdvertising($user->id, $request->advertising_type);

            if ($isValid) {
                DB::beginTransaction();
                $advertising = new Advertising();
                $advertising = $this->saveAdvertising($request, $advertising);
                $countShowDay = $this->affectCreditUser($user->id, $request->advertising_type);
                $today = date("Y-m-d");
                $date = strtotime("+$countShowDay day", strtotime($today));
                $expireDate = date("Y-m-d", $date);
                $advertising->expire_at = $expireDate;
                $advertising->save();
                DB::commit();
                // return $this->success("", ['advertising' => $advertising]);
                return redirect()->route('Main.myAds', app()->getLocale())->with('status', 'ad_created');
            }
            return $this->fail(trans("main.expire_your_credit"));
        } catch (\Exception $exception) {
            DB::rollback();
            // return $this->fail($exception->getMessage(), -1, $request->all());
            return redirect()->back()->withInput()->with('status', 'unsuccess');
        }
    }


    public function ajax_file_upload_handler(Request $request){
        $mainImageFile = $request->file;
        $fileName = $mainImageFile->getClientOriginalName();
        $storeName = time() .'-'.uniqid(time()).$fileName;
        $path =$storeName;
        $mainImageFile->move(public_path('resources/tempUploads/'), $storeName);
        return $path;
    }

    /**
     * @param Request $request
     * @param $user
     * @param Advertising $advertising
     * @return Advertising
     */
    private function saveAdvertising(Request $request, Advertising $advertising): Advertising
    {
        $advertising->user_id = Auth::user()->id;
        $advertising->phone_number = $request->phone_number;
        $advertising->city_id = $request->city_id;
        $advertising->area_id = $request->area_id;
        $advertising->type = 'residential';
        $advertising->venue_type = $request->venue_type;
        $advertising->purpose = $request->purpose;
        if (! in_array($request->method(), ['PUT', 'PATCH']))
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
        if (! in_array($request->method(), ['PUT', 'PATCH']))
            $advertising->hash_number = Advertising::makeHashNumber();
        $advertising->floor_plan = "";
        $advertising->main_image = "" ;
        $advertising->other_image = "" ;
        if ($request->hasFile('main_image')) {
            $advertising->main_image = $this->saveImage($request->main_image, true);
        } else  {
            //dd($request);
            $advertising->main_image = $request->main_image;
        }

        foreach((array) $request->deleted_images as $image) {
            ! file_exists(public_path(urldecode($image))) ?: unlink(public_path(urldecode($image)));
        }

        if ($request->hasFile('floor_plan')) {
            $advertising->floor_plan = $this->saveImage($request->floor_plan);
        } elseif ($request->floor_plan == "false") {
            $advertising->floor_plan = "";
        }

        $otherImage = [];
        if (is_array($request["other_image"] ) and count($request["other_image"])  > 0 ) {
            foreach ( $request["other_image"] as $i => $file){
                if ($request->hasFile("other_image.".  $i)) {
                    $path = $this->saveImage($request->file("other_image." . $i), true);
                } elseif (is_string($file)) {
                    $path = $file;
                } else {
                    $path = "";
                }
                $otherImage["other_image"][] = $path;
            }
        }
        if ($request->other_images_link) {
            foreach ($request->other_images_link as $i => $link) {
                rename(public_path('/resources/tempUploads/' . $link), public_path('resources/uploads/images/originals/' . $link));
                $this->watermark(public_path('resources/uploads/images/originals/' . $link));
                if ($i == 0 and ! ( $request->hasFile('main_image') or $request->exists('main_image') ) )
                    $advertising->main_image = '/resources/uploads/images/' . $link;
                else
                    $otherImage["other_image"][] = '/resources/uploads/images/' . $link;
            }
        }
        if ( ( $advertising->main_image == "" or  $advertising->main_image == null ) and isset($otherImage["other_image"][0]) ){
            $advertising->main_image = $otherImage["other_image"][0] ;
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
            } elseif ($request->video == "false") {
                $advertising->video = "";
            }
        }

        $advertising->save();

//        event(new NewAdvertising($advertising));
        return $advertising;
    }





    public function edit($locale,$hashNumber)
    {
        $advertising = Advertising::where('hash_number', $hashNumber)->whereDate('expire_at' , '>=' , Carbon::now())->firstOrFail();
//        $photo=collect(json_decode($advertising->other_image))->toArray();
//         dd($photo['other_image1']);

        $cities = City::orderBy('name_en')->get();
        $types = VenueType::where('type','Residential')->orderBy('title_en')->get();
        $purposes = ['rent', 'sell', 'exchange', 'required_for_rent'];
        $credit = $this->getCreditUser(auth()->id());
        if ($credit === [])
            $credit = ['count_premium_advertising' => 0, 'count_normal_advertising' => 0];

        return view('site.advertising.edit', compact('advertising', 'cities', 'types', 'purposes', 'credit'));
    }

    public function updateAdvertising(StoreRequest $request)
    {
        try {
            $advertising = Advertising::findOrFail($request->id);
            if (isset($advertising)) {
                $advertising = $this->saveAdvertising($request, $advertising);
                return redirect()->route('Main.myAds', app()->getLocale())->with('controller-success', trans('edited'));
            }
            return $this->fail("not_found_advertising");

        } catch (\Exception $exception) {
            return $this->fail( $exception->getMessage() .' '. $exception->getLine());
        }

    }

    public function destroyAdvertising()
    {
        $advertising = Advertising::whereId(\request('id'))->where('user_id', Auth::user()->id)->first();
//        dd($advertising);

        $massage = 'unsuccess';
        if ($advertising) {
            $massage = 'success';
            $advertising->delete();
        }
        return redirect()->route('Main.myAds',app()->getLocale())->with('status', $massage);
    }

    public function upgrade_premium(Request $request)
    {
        $isValid = $this->isValidCreateAdvertising(Auth::user()->id, 'premium');
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

            return redirect()->route('Main.myAds', app()->getLocale())->with('status', 'upgraded_premium');
        }
        return $this->fail(trans('un_success_alert_title'));
    }

    public function auto_extend(Request $request)
    {
        $status = $request->extend === 'enable' ? true : false;
        if($request->id) {
            Advertising::whereId($request->id)->whereDate('expire_at' , '>=' , Carbon::now())->update(['auto_extend' => $status]);
            return $status ? trans('enable_auto_extend') : trans('disable_auto_extend');
        }
        return trans('un_success_alert_title');
    }

    public function simpleSaveVideo()
    {
        dd($i = 1);
//        dd(\request()->all());
    }

    public function advertisingLocation($locale,$hashNumber)
    {
        $advertising=Advertising::where('hash_number',$hashNumber)->first();
        return view('site.advertising.location',compact('advertising'));
    }
    public function advertisingDirection($locale,$hashNumber)
    {
        $advertising=Advertising::where('hash_number',$hashNumber)->first();
//        return $advertising;
        return view('site.advertising.direction',compact('advertising'));
    }
}
