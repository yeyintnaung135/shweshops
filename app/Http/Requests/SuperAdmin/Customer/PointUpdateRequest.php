<?php

namespace App\Http\Requests\SuperAdmin\Customer;

use Illuminate\Foundation\Http\FormRequest;

class PointUpdateRequest extends FormRequest
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
            'count1' => 'required|numeric',
            'count2' => 'required|numeric',
            'count3' => 'required|numeric',
            'count4' => 'required|numeric',
            'count5' => 'required|numeric',
            'count10' => 'required|numeric',
            'count6' => 'required|numeric',
            'count7' => 'required|numeric',
            'count8' => 'required|numeric',
            'count9' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'count1.required' => 'The register point count field is required.',
            'count1.numeric' => 'The register point count must be a number.',
            'count2.required' => 'The Daily Login count field is required.',
            'count2.numeric' => 'The Daily Login count must be a number.',
            'count3.required' => 'The Wishlist point count field is required.',
            'count3.numeric' => 'The Wishlist point count must be a number.',
            'count4.required' => 'The Buy Now point count field is required.',
            'count4.numeric' => 'The Buy Now point count must be a number.',
            'count5.required' => 'The Add To Cart point count field is required.',
            'count5.numeric' => 'The Add To Cart point count must be a number.',
            'count10.required' => 'The Profile Edit point count field is required.',
            'count10.numeric' => 'The Profile Edit point count must be a number.',
            'count6.required' => 'The Phone Number point count field is required.',
            'count6.numeric' => 'The Phone Number point count must be a number.',
            'count7.required' => 'The Birth Date Edit point count field is required.',
            'count7.numeric' => 'The Birth Date Edit point count must be a number.',
            'count8.required' => 'The Address Edit point count field is required.',
            'count8.numeric' => 'The Address Edit point count must be a number.',
            'count9.required' => 'The Username Edit point count field is required.',
            'count9.numeric' => 'The Username Edit point count must be a number.',
        ];
    }

}
