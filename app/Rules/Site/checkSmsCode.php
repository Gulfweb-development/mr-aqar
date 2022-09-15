<?php

namespace App\Rules\Site;

use App\User;
use Illuminate\Contracts\Validation\Rule;

class checkSmsCode implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = User::where("mobile", request('mobile'))->first();
        if (isset($user) && $user->sms_code == $value) {
            $user->update([
                'sms_verified' => 1,
                'sms_code' => ''
            ]);
            return  true;
            }
        else return false;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans("main.sms_code_is_not_valid");
    }
}
