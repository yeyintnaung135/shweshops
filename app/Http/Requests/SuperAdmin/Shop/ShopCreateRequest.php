<?php

namespace App\Http\Requests\SuperAdmin\Shop;
use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;

class ShopCreateRequest extends FormRequest
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
    public function rules(): array
    {
        return[
            'name' => ['required', 'string', 'max:50'],
            'shop_name_url' => ['required', 'alpha_num', 'string', 'max:50', 'unique:shops'],
            'shop_logo' => ['required', 'mimes:jpeg,bmp,png,jpg'],
            'banner.*' => 'mimes:jpeg,bmp,png,jpg',
            'email' => ['required', 'string', 'email', 'max:50', 'unique:shops'],
            'password' => ['required', 'string', 'min:6','max:20', 'confirmed'],
            'shop_name' => ['required', 'string', 'max:50', 'unique:shops,shop_name'],
            'main_phone' => ['required', 'string', 'max:11', 'unique:shop_owners_and_staffs,phone', 'unique:shops,main_phone'],
            'description' => ['string', 'max:1255555'],
            'page_link' => ['required', 'string', 'max:1111'],
            // 'undamaged_product' => ['numeric'],
            // 'valuable_product' => [ 'numeric'],
            // 'damaged_product' => ['numeric'],
            'undamaged_product' => ['string', 'max:50'],
            'valuable_product' => ['string', 'max:50'],
            'damaged_product' => ['string', 'max:50'],
            'state' => ['required'],
            'township' => ['required'],
            'premium' => ['sometimes', 'required', 'string', 'in:yes,no'],
            'premium_template_id' => 'sometimes|required|exists:premium_templates,id',
        ];
    }
    protected function buildFailedValidationResponse(Request $request, array $errors)
    {
       

        return redirect()->back()
                        ->withInput($request->input())
                        ->withErrors($errors, $this->errorBag());
    }
}
