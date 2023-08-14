<?php

namespace App\Http\Requests\SuperAdmin\SuperAdminRole;

use App\Rules\MatchOldPassword;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSuperAdminRoleRequest extends FormRequest
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
        $rules = [
            'email' => ['required', 'string', 'email', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
        ];

        if ($this->filled('current_password') || $this->filled('new_password') || $this->filled('new_confirm_password')) {
            $rules = array_merge($rules, [
                'current_password' => ['required', 'min:8', new MatchOldPassword],
                'new_password' => ['required', 'min:8'],
                'new_confirm_password' => ['same:new_password'],
            ]);
        }

        return $rules;
    }
}
