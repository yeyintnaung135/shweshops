<?php

namespace App\Http\Requests\SuperAdmin\Ads;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StoreAdsImageRequest extends FormRequest
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
            "photo" => "required|mimes:gif,jpg,bmp,png,jpeg",
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
            "photo.required" => 'Photo ထည့်ပေးရန်',
            "photo.mimes" => 'Photo',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ])
        );
    }

}
