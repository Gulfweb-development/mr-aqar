<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class City extends Model
{
    use SoftDeletes;
    protected $guarded=['id'];

    public function areas()
    {
        return $this->hasMany(Area::class)->orderBy('name_en');
    }


}
