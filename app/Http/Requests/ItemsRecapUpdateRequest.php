<?php

namespace App\Http\Requests;

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
            'အလျော့တွက်' => 'numeric|min:0',
            'လက်ခ' => 'numeric|min:0',
            'အထည်မပျက်ပြန်သွင်း' =>'numeric|min:0',
            'အထည်ပျက်စီးချို့ယွင်း' => 'numeric|min:0',
            'တန်ဖိုးမြင့်' => 'numeric|min:0',
        ];
    }
    public function messages()
    {
        return[
            'အလျော့တွက်.min' => 'အလျော့တွက်သည် 0 ထပ် မငယ်ရ',
            'အလျော့တွက်.numeric' => 'အလျော့တွက်သည် number ဖြစ်ရမည်',

            'လက်ခ.min' => 'လက်ခသည် 0 ထပ် မငယ်ရ',
            'လက်ခ.numeric' => 'လက်ခသည် number ဖြစ်ရမည်',

            'အထည်မပျက်ပြန်သွင်း.min' => 'အထည်မပျက်ပြန်သွင်းသည် 0 ထပ် မငယ်ရ',
            'အထည်မပျက်ပြန်သွင်း.numeric' => 'အထည်မပျက်ပြန်သွင်းသည် number ဖြစ်ရမည်',

            'အထည်ပျက်စီးချို့ယွင်း.min' => 'အထည်ပျက်စီးချို့ယွင်းသည် 0 ထပ် မငယ်ရ',
            'အထည်ပျက်စီးချို့ယွင်း.numeric' => 'အထည်ပျက်စီးချို့ယွင်းသည် number ဖြစ်ရမည်',


            'တန်ဖိုးမြင့်.min' => 'တန်ဖိုးမြင့် အထည်နှင့်အထည်မပျက်ပြန်လဲသည် 0 ထပ် မငယ်ရ',
            'တန်ဖိုးမြင့်.numeric' => 'တန်ဖိုးမြင့် အထည်နှင့်အထည်မပျက်ပြန်လဲသည် number ဖြစ်ရမည်',

        ];
    }
}
