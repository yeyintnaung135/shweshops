<?php

namespace App\Rules;

use App\Models\PasswordResetForShop;
use Carbon\Carbon;

use Illuminate\Contracts\Validation\Rule;

class LoginTrottle implements Rule
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
        $toomanyattemp = PasswordResetForShop::where([['emailorphone', '=', $value], ['expire_at', '>', Carbon::now()]]);
        if (count($toomanyattemp->get()) > 5) {
            return false;
        } else{
            return true;
        }


    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Too Many Attempt';
    }
}
