<?php

namespace App\Http\Requests\SuperAdmin\Sign;

use Illuminate\Foundation\Http\FormRequest;

class StoreSignRequest extends FormRequest
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
            'name' => 'required',
            'title' => 'required',
            'description' => 'required',
            'photo' => 'required',
            'sign_logo' => 'required',
            'credit' => 'required',
        ];
    }
}
