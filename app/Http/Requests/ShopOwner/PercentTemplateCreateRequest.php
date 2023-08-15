<?php

namespace App\Http\Requests\ShopOwner;

use Illuminate\Foundation\Http\FormRequest;

class PercentTemplateCreateRequest extends FormRequest
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
            'name' =>  ['required', 'string', 'min:1', 'max:2000'],
            'undamaged_product' => ['string', 'min:1', 'max:2000'],
            'damaged_product' => ['string', 'min:1', 'max:2000'],
            'valuable_product' => ['string', 'min:1', 'max:2000'],

        ];
    }
    public function messages(): array
    {
        return [
            'name' =>  'Name Must Between 1 and 2000',
            'undamaged_product' => 'undamaged_product Must Between 1 and 2000',
            'damaged_product' => 'damaged_product Must Between 1 and 2000',
            'valuable_product' => 'valuable_product Must Between 1 and 2000',
        ];
    }
}
