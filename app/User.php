<?php

namespace App;

use App\Http\Controllers\Controller;
use App\Models\Advertising;
use App\Models\Package;
use App\Models\PackageHistory;
use App\Models\Payment;
use App\Models\StaticPackage;
use App\Models\Social;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;




class User extends Authenticatable //implements Illuminate\Contracts\Auth\CanResetPassword
{
    // Illuminate\Auth\Passwords\CanResetPassword;
    use Notifiable;
    protected $guarded=['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function advertising()
    {
        return $this->hasMany(Advertising::class)->orderBy('sort','asc');
    }


    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function sales()
    {
        return $this->hasMany(PackageHistory::class)->orderBy('id','desc');
    }
    public function archiveAdvertising()
    {
        return $this->belongsToMany(Advertising::class,'user_archive_advertising');
    }
    public function staticPackages()
    {
        return $this->belongsToMany(StaticPackage::class,"user_static_package")->withPivot(['user_id','static_package_id','count','count_usage','created_at','expire_at']);
    }

    public static function makeUser(array $data)
    {
        $user=User::create($data);
         return $user;
    }
    public static function getAllMembers()
    {
        return   User::where('type','member')->get();
    }
    public static function getAllCompanyUsers()
    {
        return   User::where('type_usage','company')->get();
    }

    public static function getAllPotentialUsers()
    {
     return   User::where('type','member')->whereHas("payments",function ($r){
            $r->where('status','canceled')->orWhere('status','failed');
        })->count();
    }
    public static function getAllIndividualUsers()
    {
        return   User::where('type_usage','individual')->get();
    }



    public static function pluckDeviceToken($list)
    {
        $deviceToken=[];
        foreach ($list as $item) {
            if($item->device_token!=null && $item->device_token!="" && $item->device_token!="null")
                $deviceToken[$item->id]=$item->device_token;
        }
        return $deviceToken;
    }

    public function socials()
    {
        return $this->hasMany(Social::class);
    }

    public function getIsCompanyAttribute()
    {
        return $this->type_usage === 'company';
    }
}

