<?php


namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class InvalidKey extends Model
{
    protected $guarded=['id'];
    public $table="invalid_keys";
}