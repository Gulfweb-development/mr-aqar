<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;
use App\Models\PackageHistory;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function index(Request $request)
    {
            $list=   Payment::with(["user","package","packageHistory","order"]);


            if($request->fromDate){
                $fromDate=self::returnDateTimeFormat($request->fromDate);
                $list=$list->where('created_at','>=',$fromDate);
            }

            if($request->toDate){
                $toDate=self::returnDateTimeFormat($request->toDate);
                $list=$list->where('created_at','<=',$toDate);
            }
            if($request->status && $request->status!="all"){
                $list=$list->where('status',$request->status);
            }

            $list=$list->orderBy('id',"desc")->paginate(30);
        return view("payments.index",compact('list'));
    }

    public function showDetail($id)
    {
        $payment=   Payment::with(["user","package","packageHistory","order"])->whereId($id)->first();
        return view("payments.view",compact("payment"));
    }
    public function userPayment($userId)
    {
          $list=Payment::where("user_id",$userId)->with(["user","package","packageHistory"])->orderBy('id',"desc")->paginate(30);
          return view("payments.index",compact('list'));
    }

    public function acceptPayment($id)
    {
        $packageHistory=PackageHistory::find($id);
        $packageHistory->accept_by_admin=1;
        $packageHistory->save();
        return redirect()->back();
    }
}
