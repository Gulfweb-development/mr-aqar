<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
        if (! in_array($this->method(), ['PUT', 'PATCH'])) { // create
            $rules = [
                'image' => 'nullable|image|mimes:jpg,png,jpeg|max:1024',
                // Company name always should be required!!!!
                'company_name' => 'required|max:250',
                'company_phone' => 'required|digits:8|unique:users,company_phone',
                'email' => 'nullable|email',
                'instagram' => 'nullable',
                'twitter' => 'nullable',
            ];
        } else { // edit
            $rules = [
                'image' => 'nullable|image|mimes:jpg,png,jpeg|max:1024',
                // Company name always should be required!!!!
                'company_name' => 'required|max:250',
                'company_phone' => 'required|digits:8|unique:users,company_phone,' . $this->user()->id,
                'email' => 'nullable|email',
                'instagram' => 'nullable',
                'twitter' => 'nullable',
            ];
        }
        return $rules;
    }
}
