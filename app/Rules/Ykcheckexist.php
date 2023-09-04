<?php

namespace App\Rules;

use App\Models\ShopOwnersAndStaffs;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class Ykcheckexist implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //
        $check_shoprole = ShopOwnersAndStaffs::where('phone', $value)->count();
        if ($check_shoprole != 0) {
            return true;
        } else {
 
                return false;
          
            // else {
            //     $check_shoprole = User::where('phone', $value)->count();
            //     if ($check_shoprole != 0) {
            //         return true;
            //     } else {
            //         return false;

            //     }
            // }
        }



    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Your Phone does not exist in Our Records';
    }
}
