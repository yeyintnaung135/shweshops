<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemsRecapRequest extends FormRequest
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
            'name' => 'required',
            // 'အထည်မပျက်ပြန်သွင်း' =>'required|numeric|min:0',
            // 'အထည်ပျက်စီးချို့ယွင်း' => 'required|numeric|min:0',
            // 'တန်ဖိုးမြင့်' => 'required|numeric|min:0',
            'undamage' =>'required',
            'damage' => 'required',
            'valuable' => 'required',
        ];
    }

    public function messages()
    {
        return[
            'name.required' => 'Template Name ထည့်ပေးရန်',

            'undamage.required' => 'အထည်မပျက်ပြန်သွင်း ထည့်ပေးရန်',
            'undamage.min' => 'အထည်မပျက်ပြန်သွင်း 0 ထပ် မငယ်ရ',
            'undamage.numeric' => 'အထည်မပျက်ပြန်သွင်းသည် number ဖြစ်ရမည်',

            'damage.required' => 'အထည်ပျက်စီးချို့ယွင်း ထည့်ပေးရန်',
            'damage.min' => 'အထည်ပျက်စီးချို့ယွင်း 0 ထပ် မငယ်ရ',
            'damage.numeric' => 'အထည်ပျက်စီးချို့ယွင်းသည် number ဖြစ်ရမည်',


            'valuable.required' => 'တန်ဖိုးမြင့် အထည်နှင့်အထည်မပျက်ပြန်လဲ ထည့်ပေးရန်',
            'valuable.min' => 'တန်ဖိုးမြင့် အထည်နှင့်အထည်မပျက်ပြန်လဲ 0 ထပ် မငယ်ရ',
            'valuable.numeric' => 'တန်ဖိုးမြင့် အထည်နှင့်အထည်မပျက်ပြန်လဲသည် number ဖြစ်ရမည်',


            
        ];
    }
}
