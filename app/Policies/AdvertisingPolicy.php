<?php

namespace App\Policies;

use App\Models\Advertising;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdvertisingPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function delete(User $user, Advertising $advertising)
    {
        return $user->id === $advertising->user_id;
    }
}
