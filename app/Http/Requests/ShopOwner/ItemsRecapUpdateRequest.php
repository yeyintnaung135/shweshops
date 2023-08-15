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
            'အလျော့တွက်' => 'integer|min:0|max:1000000000',
            'လက်ခ' => 'integer|min:0',
            'အထည်မပျက်ပြန်သွင်း' => 'integer|max:1000000000',
            'အထည်ပျက်စီးချို့ယွင်း' => 'integer|max:1000000000',
            'တန်ဖိုးမြင့်' => 'integer|max:1000000000',
        ];
    }
    public function messages()
    {
        return [
            'အလျော့တွက်.min' => 'အလျော့တွက်သည် 0 ထပ် မငယ်ရ',
            'အလျော့တွက်.integer' => 'အလျော့တွက်သည် number ဖြစ်ရမည်',

            'လက်ခ.min' => 'လက်ခသည် 0 ထပ် မငယ်ရ',
            'လက်ခ.integer' => 'လက်ခသည် number ဖြစ်ရမည်',

            'အထည်မပျက်ပြန်သွင်း.min' => 'အထည်မပျက်ပြန်သွင်းသည် 0 ထပ် မငယ်ရ',
            'အထည်မပျက်ပြန်သွင်း.integer' => 'အထည်မပျက်ပြန်သွင်းသည် number ဖြစ်ရမည်',

            'အထည်ပျက်စီးချို့ယွင်း.min' => 'အထည်ပျက်စီးချို့ယွင်းသည် 0 ထပ် မငယ်ရ',
            'အထည်ပျက်စီးချို့ယွင်း.integer' => 'အထည်ပျက်စီးချို့ယွင်းသည် number ဖြစ်ရမည်',


            'တန်ဖိုးမြင့်.min' => 'တန်ဖိုးမြင့် အထည်နှင့်အထည်မပျက်ပြန်လဲသည် 0 ထပ် မငယ်ရ',
            'တန်ဖိုးမြင့်.integer' => 'တန်ဖိုးမြင့် အထည်နှင့်အထည်မပျက်ပြန်လဲသည် number ဖြစ်ရမည်',

        ];
    }
}
