<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CatFilterRequest extends FormRequest
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
            'filtertype.selected_product_quality' => [Rule::in([
                'All',
                '24K ၁၆ပဲရည်', '23K ၁၅ပဲရည်', '22K ၁၄ပဲ ၂ပြားရည်', '21K ၁၄ပဲရည်', '20K ၁၃ပဲရည်', '19K ၁၂ပဲ ၂ပြားရည်', '18K ၁၂ပဲရည်', '17K ၁၁ပဲ ၂ပြားရည်', '16K ၁၁ပဲရည်', '15K ၁၀ပဲရည်', '14K ၉ပဲရည်', '13K ၈ပဲ ၂ပြားရည်', '12K ၈ပဲရည်'
            ])],
            'filtertype.sort' => [Rule::in([
                'all',
                'price_low_to_high', 'price_high_to_low', 'latest', 'popular', 'discountpercent'
            ])],
            'gender' => [Rule::in([
                'Kid',
                'Men', 'Women', 'Couple', 'UniSex', 'all'
            ])],
            'filtertype.discount' => [Rule::in([
                'yes',
                'no'
            ])],
            'filtertype.item_id' => [function ($attribute, $value, $fail) {
                if (is_int($value) || 'empty' === $value) {
                    return true;
                } else {
                    $fail($attribute . ' is invalid.');
                }
            }],
            'filtertype.cat_id' => ['array', 'max:30'],
            'filtertype.byshop.*' => [function ($attribute, $value, $fail) {
                if (is_int($value) || 'all' === $value) {
                    return true;
                } else {
                    $fail($attribute . ' is invalid.');
                }
            }],
            'filtertype.cat_id.*' => [Rule::in(['footchain', 'headband', 'brooch', 'comb', 'bayat', 'ring', 'earring', 'necklace', 'nrrswel', 'swal_tee', 'braceket', 'hand_chain', 'pendant', 'hair_clip', 'accessories', 'pixiu', 'bayat'])],
            'filtertype.price_range' => [function ($attribute, $value, $fail) {
                $str_toarray = explode(" ", str_replace("-", ' ', $value));
                if ($value == 'all' || (is_numeric($str_toarray[0]) && is_numeric($str_toarray[1]))) {
                    return true;
                } else {
                    $fail($attribute . ' is invalid.');
                }
            }],
            //
        ];
    }
}
