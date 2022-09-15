<?php

namespace App\Http\Controllers;

use App\Models\InvalidKey;
use App\Models\PackageHistory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

// use Intervention\Image\ImageManager;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function saveFile($file,$type="file")
    {
        $fileName = time() . '.' . $file->getClientOriginalName();
        $file->move('resources/assets/images/user_image/', $fileName);
        return '/resources/assets/images/user_image/'.$fileName;
    }

    public static function returnDateTimeFormat($date)
    {
        $time=strtotime($date);
        return date("Y-m-d H:i:s",$time);
    }

    public static function returnDateFormat($date)
    {
        $time=strtotime($date);
        return date("Y-m-d",$time);
    }



    public static  function sendSms($message,$mobile)
    {
        $post="msg=".urlencode($message)."&number=".$mobile."&key=".env('SMS_API_KEY')."&dezsmsid=".env('DEZSMS_ID')."&senderid=".env('SENDER_ID')."&xcode=965";
        return  self::__curl($post);
    }
    public static function __curl($post){
        try{
            $ch = curl_init(env('API_SMS_URL'));
            curl_setopt ($ch, CURLOPT_POST, 1);
            curl_setopt ($ch, CURLOPT_POSTFIELDS,  $post);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER , 1);
            $result= curl_exec ($ch);
            curl_close ($ch);
            unset($ch);
            if($result==100){
                unset($result);
                return true;
            }
            if($result==100){
                $message =   "SMS has been sent successfully";
            }else if($result==101){
                $message =   "This is Invalid user";
            }else if($result==102){
                $message =   "Invalid authentication key!";
            }else if($result==103){
                $message =   "Mobile number OR Message is required!";
            }else if($result==104){
                $message =   "You can send upto 200 maximum mobile numbers at once.";
            }else if($result==105){
                $message =   "SMS Sending failed.Please contact with your SMS provider.";
            }else if($result==106){
                $message =   "Arabic text should not be greater than 258";
            }else if($result==107){
                $message =   "English text should not be greater than 526";
            }else if($result==108){
                $message =   "Your account is not activeted";
            }else if($result==109){
                $message =   "Your account has been expired.";
            }else if($result==110){
                $message =   "SMS point is not enough to send sms";
            }else if($result==111){
                $message =  "Invalid Mobile number";
            }
            return false;
        }catch (\Exception $exception){
            return false;
        }

    }

    public function success($message, $data=null, $status=1)
    {
        return redirect()->back()->withInput()->with('controller-success', $message);
        // return response()->json([
        //     'status' => $status,
        //     'message' => $message,
        //     'data' => $data
        // ]);
    }
    public function fail($message, $status=-1, $errors=null)
    {
        return redirect()->back()->withInput()->withErrors(['fail' => $message]);
        // return response()->json([
        //     'status' => $status,
        //     'message' => $message,
        //     'errors' => $errors
        // ]);
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
    public function saveImage($image, $watermark = false)
    {
        $mainImageFile = $image;
        $fileName = $mainImageFile->getClientOriginalName();
        $storeName = uniqid(time()).$fileName;
        $path ='/resources/uploads/images/originals'.$storeName;
//        $mainImageFile->store('/resources/uploads/images/',config('filesystems.public'));
//        Storage::put(('public/resources/uploads/images/'),$mainImageFile  );

        $mainImageFile->move(public_path($path), $storeName);

        if ($watermark)
            $this->watermark($mainImageFile);
        else
            $mainImageFile->move(public_path('resources/uploads/images/'), $storeName);

        return $path;
    }

    public function watermark($image, $to = 'resources/uploads/images/')
    {
        $img = Image::make($image);
        // get width and height
        $w = $img->width();
        $h = $img->height();
        // check image is tall or wide
        // resize watermark based on it
        // give watermark a min-width and min-height (maybe)
        $watermark = Image::make(public_path('/images/main/watermark.png'))->opacity(65);
        // dd($w, $h, ($h / 10) * 2);
        if ($w > ($h * 2))
            $watermark->heighten((int) ($h / 10) * 2); // 20%
        elseif ($h > ($w * 2))
            $watermark->widen((int) ($w / 10) * 4); // 40%
        else
            $watermark->widen((int) ($w / 10) * 1.5); // 15%

        $img->insert($watermark, 'bottom-right', 10, 10);
        return $img->save(public_path($to . basename($image)));
    }

    public function saveVideo($video)
    {
        $extension = $video->getClientOriginalExtension();
        $storeName = time().uniqid().".". $extension;
        $path = 'resources/uploads/videos/'. $storeName;
        $video->move(public_path('resources/uploads/videos/'), $storeName);
        return $path;

    }
    public static function uploadBase64Image($inputName, $path)
    {
        $image_64 = \request($inputName);  // your base64 encoded
        $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf

        $replace = substr($image_64, 0, strpos($image_64, ',')+1);

        $image = str_replace($replace, '', $image_64);

        $image = str_replace(' ', '+', $image);

        $imageName = Str::random(10).'.'.$extension;
        Storage::put($path. '/' . $imageName, base64_decode($image));
        return $imageName;


    }
    public function filterKeywords($text)
    {
        $keys = explode(" ", $text);
        $invalidKeys = $this->getInvalidKeys();
        foreach ($keys as $key) {
            if (in_array($key, $invalidKeys)) {
                return [false, $key];
            }
        }
        return [true];
    }
    private function getInvalidKeys()
    {
        $keys = InvalidKey::first();
        if (isset($keys)) {
            $items = json_decode($keys->key_title);
        } else {
            $items = [];
        }
        return $items;
    }
}
