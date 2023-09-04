<?php

namespace App\Http\Requests\ShopOwner;

use Illuminate\Foundation\Http\FormRequest;

class ItemsRecapUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'new_decrease' => 'integer|min:0|max:1000000000',
            'fee' => 'integer|min:0',
            'undamaged_product' => 'integer|max:1000000000',
            'damaged_product' => 'integer|max:1000000000',
            'valuable_product' => 'integer|max:1000000000',
        ];
    }
    public function messages()
    {
        return [
            'new_decrease.min' => 'အလျော့တွက်သည် 0 ထပ် မငယ်ရ',
            'new_decrease.integer' => 'အလျော့တွက်သည် number ဖြစ်ရမည်',

            'fee.min' => 'လက်ခသည် 0 ထပ် မငယ်ရ',
            'fee.integer' => 'လက်ခသည် number ဖြစ်ရမည်',

            'undamaged_product.min' => 'အထည်မပျက်ပြန်သွင်းသည် 0 ထပ် မငယ်ရ',
            'undamaged_product.integer' => 'အထည်မပျက်ပြန်သွင်းသည် number ဖြစ်ရမည်',

            'damaged_product.min' => 'အထည်ပျက်စီးချို့ယွင်းသည် 0 ထပ် မငယ်ရ',
            'damaged_product.integer' => 'အထည်ပျက်စီးချို့ယွင်းသည် number ဖြစ်ရမည်',

            'valuable_product.min' => 'တန်ဖိုးမြင့် အထည်နှင့်အထည်မပျက်ပြန်လဲသည် 0 ထပ် မငယ်ရ',
            'valuable_product.integer' => 'တန်ဖိုးမြင့် အထည်နှင့်အထည်မပျက်ပြန်လဲသည် number ဖြစ်ရမည်',

        ];
    }
}
