<?php


namespace App\Models;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    protected $guarded=['id'];
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }
    public function user()
    {
      return $this->belongsTo(User::class);
    }
    public function packageHistory()
    {
        return $this->belongsTo(PackageHistory::class,"package_history_id");
    }
    public function package()
    {
        return $this->belongsTo(Package::class);
    }


    public function order()
    {
       return $this->belongsTo(OrderTransaction::class,'ref_id','api_ref_id');
    }



}
