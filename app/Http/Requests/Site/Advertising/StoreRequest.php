<?php

namespace App\Http\Requests\Site\Advertising;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
           'phone_number' => 'required|digits:8',
           'advertising_type' => 'required|in:normal,premium',
           'venue_type' => 'required',
           'purpose' => 'required|in:rent,sell,exchange,required_for_rent',
           'city_id' => 'required',
           'area_id' => 'required',
           'price' => 'nullable|numeric',
//            'video' => 'nullable|mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4|max:20000',
//            // 'other_image' => 'nullable|array',
//            //   'other_image.*' => 'mimes:jpeg,bmp,png|max:2048',
//            'main_image' => 'nullable|mimes:jpeg,bmp,png|max:2048',
//            'floor_plan' => 'nullable|mimes:jpeg,bmp,png|max:2048',
//             'number_of_rooms' => 'nullable',
//             'number_of_bathrooms' => 'nullable',
//             'number_of_master_rooms' => 'nullable',
//             'number_of_parking' => 'nullable',
//            'gym' => 'required|in:1,0',
//            'pool' => 'required|in:1,0',
//            'furnished' => 'required|in:1,0',
        ];
        } else { // edit
            $rules = [
                'phone_number' => 'required|digits:8',
                'advertising_type' => 'nullable',
                'venue_type' => 'required',
                'purpose' => 'required|in:rent,sell,exchange,required_for_rent',
                'city_id' => 'required',
                'area_id' => 'required',
                'price' => 'nullable|numeric',
            ];
        }
        return $rules;
    }
}
