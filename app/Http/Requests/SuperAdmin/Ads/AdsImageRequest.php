<?php

namespace App\Http\Requests\SuperAdmin\Ads;

use Illuminate\Foundation\Http\FormRequest;

class AdsImageRequest extends FormRequest
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
            "shop_id" => "required",
            "start" => "required",
            "end" => "required",
            "image" => "required",
        ];

    }

    public function messages()
    {
        return [
            "shop_id.required" => 'Shop  ရွေးပေးပါ',
            "start.required" => 'Start Date ထည့်ပေးရန်',
            "end.required" => 'End Date ထည့်ပေးရန်',
            "image.required" => 'Photo ထည့်ပေးရန်',
        ];
    }
}
