<?php

namespace App\Http\Requests\SuperAdmin\Sign;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSignRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string'],
            'credit' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            // 'photo' => ['required', 'string', 'max:50'],
        ];
    }
}
