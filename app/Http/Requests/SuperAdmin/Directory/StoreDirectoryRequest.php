<?php

namespace App\Http\Requests\SuperAdmin\Directory;

use Illuminate\Foundation\Http\FormRequest;

class StoreDirectoryRequest extends FormRequest
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
            'shop_logo' => ['mimes:jpeg,bmp,png,jpg'],
            'shop_name' => ['required', 'string', 'max:50'],
            'shop_name_url' => ['required', 'string', 'max:50', 'unique:shop_directory,shop_name_url'],
            'main_phone' => ['string', 'max:11', 'unique:shop_directory,main_phone'],
            'address' => ['required', 'string'],
            'state' => ['required', 'string', 'min:3'],
            'township' => ['required', 'string', 'min:3'],
        ];
    }

    public function messages()
    {
        return [
            'state.min' => 'State field is required',
            'township.min' => 'Township field is required',
        ];
    }
}
