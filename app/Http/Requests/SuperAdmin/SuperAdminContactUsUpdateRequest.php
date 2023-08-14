<?php

namespace App\Http\Requests\SuperAdmin;

use Illuminate\Foundation\Http\FormRequest;

class SuperAdminContactUsUpdateRequest extends FormRequest
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
            'top_text' => ['required', 'max:1000'],
            'phone' => ['required', 'max:30'],
            'email' => ['required', 'max:30'],
            'mid_text' => ['required', 'max:1000'],
            'address' => ['required', 'max:1000'],
            'map' => ['required', 'max:1000'],
            'image' => (isset($this->image) || !empty($this->image)) ? 'image' : 'nullable',
        ];
    }
}
