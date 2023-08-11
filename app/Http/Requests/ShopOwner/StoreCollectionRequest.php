<?php

namespace App\Http\Requests\ShopOwner;

use Illuminate\Foundation\Http\FormRequest;

class StoreCollectionRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:collection',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name field must be a string.',
            'name.max' => 'The name field must not exceed 255 characters.',
            'name.unique' => 'The name field must be unique.',
        ];
    }
}
