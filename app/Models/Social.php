<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    public $timestamps = false;
    protected $fillable = ['user_id', 'address', 'type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
