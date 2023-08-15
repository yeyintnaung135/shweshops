<?php

namespace App\Http\Requests\SuperAdmin\Ads;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdsVideoFormRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            "video" => "required|mimes:gif,jpg,bmp,png,jpeg",
            "image_for_mobile" => "required|image|mimes:gif,jpg,bmp,png,jpeg",
            "start" => "required|date",
            "end" => "required|date|after:start",
        ];
    }

    public function messages()
    {
        return [
            "start.required" => 'Start Date ထည့်ပေးရန်',
            "end.required" => 'End Date ထည့်ပေးရန်',
            "video.required" => 'Video ထည့်ပေးရန်',
            "video.mimes" => 'Image',
        ];
    }

}
