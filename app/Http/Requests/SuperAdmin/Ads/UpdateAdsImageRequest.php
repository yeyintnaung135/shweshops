<?php

namespace App\Http\Requests\SuperAdmin\Ads;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdsImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            "shop_id" => "required|exists:shops,id",
            "links" => "nullable|url",
            "start" => "required|date",
            "end" => "required|date|after:start",
            "image" => "required|image|mimes:gif,jpg,bmp,png,jpeg",
            "image_for_mobile" => "required|image|mimes:gif,jpg,bmp,png,jpeg",
        ];
    }
}
