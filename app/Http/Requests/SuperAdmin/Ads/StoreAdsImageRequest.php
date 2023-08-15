<?php

namespace App\Http\Requests\SuperAdmin\Ads;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdsImageRequest extends FormRequest
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
            "shop_id" => "required|exists:shops,id", // Validate that shop_id exists in the 'shops' table
            "start" => "required|date", // Validate that 'start' is a valid date
            "end" => "required|date|after:start", // Validate that 'end' is a valid date and comes after 'start'
            "image" => "required|image|mimes:jpeg,png,gif", // Validate that 'image' is an uploaded image with allowed extensions
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
