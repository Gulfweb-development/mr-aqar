<?php


namespace App\Events;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserRegistered
{
    use SerializesModels,Dispatchable;
    public $user;
    public function __construct($user)
    {
        $this->user = $user;
    }

}