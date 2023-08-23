<?php

namespace App\Http\Requests\ShopOwner;

use App\Rules\YkSixFourBitImageCheck;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Auth\Access\Response;


class ItemEditRequest extends FormRequest
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
            'name' => ['required', 'min:0', 'max:100'],
            'description' => ['required', 'min:0', 'max:2000'],
            'gender' => ["required", "max:255", Rule::in(['Kid', 'Men', 'Women', 'Couple', 'UniSex'])],

            'gems' => ['max:2000'],
            'weight' => ['max:2000'],
            'undamaged_product' => ['max:2114'],
            'damaged_product' => ['max:2114'],
            'valuable_product' => ['max:2114'],


            'diamond' => ['required', Rule::in(['Yes', 'No'])],


            'gold_quality' => ['required', Rule::in([
                '24K ၁၆ပဲရည်', '23K ၁၅ပဲရည်', '22K ၁၄ပဲ ၂ပြားရည်', '21K ၁၄ပဲရည်', '20K ၁၃ပဲရည်', '19K ၁၂ပဲ ၂ပြားရည်', '18K ၁၂ပဲရည်', '17K ၁၁ပဲ ၂ပြားရည်', '16K ၁၁ပဲရည်', '15K ၁၀ပဲရည်', '14K ၉ပဲရည်', '13K ၈ပဲ ၂ပြားရည်', '12K ၈ပဲရည်'
            ])],




            'file' => ['array', 'min:1', 'max:10'],
            // 'mid_files'=>['required','array','min:1','max:10'],
            'tags' => ['max:2000'],
            'formidphotos' => [new YkSixFourBitImageCheck],
            'forthumbphotos' => [new YkSixFourBitImageCheck],


            'stock' => ['required', 'regex:(In Stock|Out Of Stock)'],
            'default_photo' => ['required', 'max:300'],


            'file.*' => ['required', 'mimes:jpg,jpeg,png,bmp,gif'],
            // 'small_files.*'=>['required','mimes:jpg,jpeg,png,bmp,gif'],
            'stock_count' => ['required', 'integer', 'between:1,100'],
            'main_category' => ['required', 'integer', 'between:1,5'],
            'category_id' => ["required", "max:255", Rule::in(['footchain', 'headband', 'brooch', 'comb', 'bayat', 'ring', 'earring', 'necklace', 'nrrswel', 'swal_tee', 'braceket', 'hand_chain', 'pendant', 'hair_clip', 'accessories', 'pixiu', 'bayat'])],


            'handmade' => ['max:300'],
            'charge' => ['max:300']

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ])
        );
    }
}
