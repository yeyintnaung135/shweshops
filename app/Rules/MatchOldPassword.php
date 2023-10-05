<?php
  
namespace App\Rules;
  
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
  
class MatchOldPassword implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if(Auth::guard('super_admin')->check()){
            return Hash::check($value, Auth::guard('super_admin')->user()->password);
        }
        else if(Auth::guard('pos_super_admin')->check()){
            return Hash::check($value, Auth::guard('pos_super_admin')->user()->password);
        }
        else{
            return Hash::check($value, Auth::guard('shop_owners_and_staffs')->user()->password);
        }
    }
   
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute is match with old password.';
    }
}