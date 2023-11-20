<?php

namespace App\Http\Requests\SuperAdmin\Shop;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ShopUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard('super_admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(Request $request): array
    {
        return [
            'name' => ['required', 'string', 'max:50'],
            'shop_name_url' => ['required', 'alpha_num', 'string', 'max:50',  Rule::unique('shops')->ignore($request->id)],
            'shop_logo' => ['mimes:jpeg,bmp,png,jpg'],
            'banner.*' => 'mimes:jpeg,bmp,png,jpg',
            'email' => ['required', 'string', 'email', 'max:50', Rule::unique('shops')->ignore($request->id)],
            'shop_name' => [
                'required', 'string', 'max:50', Rule::unique('shops')->ignore($request->id)
            ],
            'main_phone' => [
                'required',
                Rule::unique('shops')->ignore($request->id),
                Rule::unique('shop_owners_and_staffs', 'phone')->ignore($request->id,'shop_id'),
            ],
            'description' => ['string', 'max:1255555'],
            'page_link' => ['required', 'string', 'max:1111'],
            // 'undamaged_product' => ['numeric'],
            // 'valuable_product' => [ 'numeric'],
            // 'damaged_product' => ['numeric'],
            'undamaged_product' => ['string', 'max:550'],
            'valuable_product' => ['string', 'max:550'],
            'damaged_product' => ['string', 'max:550'],
            'state' => ['required'],
            'township' => ['required'],
            // 'premium' => ['sometimes', 'required', 'string', 'in:yes,no'],
            // 'premium_template_id' => 'sometimes|required|exists:premium_templates,id',
        ];
    }
    protected function buildFailedValidationResponse(Request $request, array $errors)
    {

        return redirect()->back()
            ->withInput($request->input())
            ->withErrors($errors, $this->errorBag());
    }
}
