<?php


namespace App\Http\Controllers\Api\V1;


use App\Models\PackageHistory;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends ApiBaseController
{
    public function paymentResult(Request $request)
    {
        $message=$request->get('message');
        $refId=$request->get('refid');
        $trackid=$request->get('trackid');
        $payment=Payment::with(['package','packageHistory'])->where('ref_id',$refId)->first();
        $order=DB::table('tbl_transaction_api')->where("api_ref_id",$refId)->first();

        if($payment){
            $packageHistory= PackageHistory::where("payment_id",$payment->id)->first();

            if($message=="CAPTURED"){
                    $payment->status="completed";
                    $packageHistory->accept_by_admin=1;
              }else{
                $payment->status="failed";
                $packageHistory->accept_by_admin=0;
              }
             $payment->description=$message;
              $payment->save();
              $packageHistory->save();
        }
        return view("front-api.payment-result",compact('message','refId','trackid','payment','order'));
    }
}