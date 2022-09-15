<?php


namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use App\Models\PackageHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Johntaa\Arabic\I18N_Arabic;
class ApiBaseController extends Controller
{
    public function __construct()
    {
        if(\request()->get('language')){
           app()->setLocale(strtolower(request()->get('language')));
        }
    }
    public function success($message, $data=null, $status=1)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ]);
    }
    public function fail($message, $status=-1, $errors=null)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'errors' => $errors
        ]);
    }
    public static function getCreditUser($userId)
    {
        $date=date("Y-m-d");
        $packages=DB::table("user_package_history")
            ->where("expire_at",'>',$date)
            ->where('is_payed',1)
            ->where('accept_by_admin',1)
            ->where("user_id",$userId)
            ->whereColumn('count_advertising','>=','count_usage')
            ->whereColumn('count_premium','>=','count_usage_premium')
            ->orderBy('id','desc')->get();
        if($packages->count()>=1){
            $cp=0;
            $cn=0;

            $cpUse=0;
            $cnUse=0;

            foreach ($packages as $package){
                $cp+=$package->count_premium;
                $cn+=$package->count_advertising;

                $cpUse+=$package->count_usage_premium;
                $cnUse+=$package->count_usage;
            }
            $data['count_premium_advertising']=$cp-$cpUse;
            $data['count_normal_advertising']=$cn-$cnUse;
            return $data;
        }else{
            return [];
        }



    }
    public static function affectCreditUser($userId,$type)
    {
        $listBalance= PackageHistory::where("user_id",$userId)
            ->where("expire_at",">",date("Y-m-d"))
            ->where("accept_by_admin",1)
            ->where('is_payed',1)
            ->orderBy('id','desc');
        if($type=="normal"){
            $listBalance=$listBalance->whereColumn('count_advertising','>','count_usage');
        }else{
            $listBalance=$listBalance->whereColumn('count_premium','>','count_usage_premium');
        }
        $listBalance=$listBalance->first();
        if(isset($listBalance)){
            if($type=="normal"){
                $listBalance->count_usage=intval($listBalance->count_usage)+1;
            }else{
                $listBalance->count_usage_premium=intval($listBalance->count_usage_premium)+1;
            }
            $listBalance->save();
            return $listBalance->count_show_day;
        }
    }
    public static function isValidCreateAdvertising($userId,$type)
    {
       $result= self::getCreditUser($userId);
       if(count($result)>=1){
           if($type=="normal"){
               if($result["count_normal_advertising"]>=1){
                   return true;
               }
           }elseif($type=="premium" && $result["count_premium_advertising"]>=1){
               return true;
           }
           return false;
       }
       return false;
    }
    public function saveImage($image, $watermark = false)
    {
        $mainImageFile = $image;
        $fileName = $mainImageFile->getClientOriginalName();
        $storeName = uniqid(time()).$fileName;
        $path ='/resources/uploads/images/'.$storeName;
        $mainImageFile->move(public_path('resources/uploads/images/'), $storeName);
        return $path;
    }
    public function saveVideo($video)
    {
        $extension = $video->getClientOriginalExtension();
        $storeName = time().uniqid().".". $extension;
        $path = 'resources/uploads/videos/'. $storeName;
        $video->move(public_path('resources/uploads/videos/'), $storeName);
        return $path;

    }
	public static function mb_strrev($str){
    $r = '';
    for ($i = mb_strlen($str); $i>=0; $i--) {
        $r .= mb_substr($str, $i, 1);
    }
    return $r;
    }
}
