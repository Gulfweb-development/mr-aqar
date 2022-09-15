<?php

namespace App\Http\Requests\Site;

use App\Rules\Site\checkSmsCode;
use Illuminate\Foundation\Http\FormRequest;

class verifySmsCodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mobile' => ['required','digits:8'],
            'code' => ['required',new checkSmsCode()]
        ];
    }
}
