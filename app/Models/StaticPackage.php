<?php


namespace App\Models;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaticPackage extends Model
{
    use SoftDeletes;
    protected $guarded=['id'];
    protected $table="static_package";

    public function users()
    {
        return $this->hasMany(User::class);
    }


    public static function getPackageList()
    {
        return  Package::where("is_enable",1)->get();
    }

}
