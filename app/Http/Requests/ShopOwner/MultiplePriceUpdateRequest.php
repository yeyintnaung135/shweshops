<?php

namespace App\Http\Requests\ShopOwner;

use Illuminate\Foundation\Http\FormRequest;

class MultiplePriceUpdateRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'price' => ['integer', 'min:1000', 'max:1000000000'],
        ];
    }
    public function messages(): array
    {
        return [
            'price.min' => 'Price သည် 1000 ထပ် မငယ်ရ',
            'price.integer' => 'Price သည် number ဖြစ်ရမည်',
        ];
    }
}
