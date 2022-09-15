<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Setting;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function create()
    {

        $whatsapp = Setting::where('setting_key' , 'whatsapp')->value('setting_value');
        $instagram = Setting::where('setting_key' , 'instagram')->value('setting_value');
        $email = Setting::where('setting_key' , 'email')->value('setting_value');
        $website = Setting::where('setting_key' , 'website')->value('setting_value');
        $phone = Setting::where('setting_key' , 'phone')->value('setting_value');
		$phone2 = Setting::where('setting_key' , 'phone2')->value('setting_value');
        $address = Setting::where('setting_key' , 'address')->value('setting_value');
		$address_ar = Setting::where('setting_key' , 'address_ar')->value('setting_value');
        $info = [$whatsapp , $instagram , $email , $website , $phone , $address] ;
     

        return view('site.pages.contact' , compact('whatsapp','instagram','email','website','phone','phone2','address','address_ar'));
    }

    public function store(Request $request)
    {

        $locale = app()->getLocale();


        // Validate and store the message
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required|numeric|digits:8',
        ]);

        $message = new Message();

        $message->name = $request->name;
        $message->email = $request->email;
        $message->phone_number = $request->phone_number;
        $message->message = $request->message;

        $whatsapp = Setting::where('setting_key' , 'whatsapp')->value('setting_value');
        $instagram = Setting::where('setting_key' , 'instagram')->value('setting_value');
        $email = Setting::where('setting_key' , 'email')->value('setting_value');
        $website = Setting::where('setting_key' , 'website')->value('setting_value');
        $phone = Setting::where('setting_key' , 'phone')->value('setting_value');
        $address = Setting::where('setting_key' , 'address')->value('setting_value');
        $info = [$whatsapp , $instagram , $email , $website , $phone , $address] ;

        if($message->save()) {
            return redirect(app()->getLocale().'/contact#result' )->with(['status' => 'success', 'whatsapp','instagram','email','website','phone','address','locale' ]);
            //return redirect()->route( 'Message.create' , compact('whatsapp','instagram','email','website','phone','address','locale'))->with( [ 'status' => 'success' ] );
        } else {
            return redirect(app()->getLocale().'/contact#result' )->with(['status' => 'unsuccess', 'whatsapp','instagram','email','website','phone','address','locale']);
            //return redirect()->route( 'Message.create' , compact('whatsapp','instagram','email','website','phone','address','locale'))->with( [ 'status' => 'unsuccess'] );
        }
    }
	
	//get setting
public static function getSettingDetails($key){
return  Setting::where('setting_key' , $key)->value('setting_value');
}



}

