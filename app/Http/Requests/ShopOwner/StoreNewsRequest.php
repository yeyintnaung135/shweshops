<?php

namespace App\Http\Requests\ShopOwner;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewsRequest extends FormRequest
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
            'title' => 'required|string|max:255|unique:news',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,bmp|max:2048'
        ];
    }
}
