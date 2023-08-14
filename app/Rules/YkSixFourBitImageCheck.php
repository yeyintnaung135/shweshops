<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class YkSixFourBitImageCheck implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $first_will_decode = json_decode($value, true);
        foreach ($first_will_decode as $fwd) {
            $data = explode(',', $fwd['data']);

            $decodedstring = base64_decode($data[1]);

            $img = imagecreatefromstring($decodedstring);

            if (!$img) {
                $fail('The :attribute must be image.');
                break;
            }

            $size = getimagesizefromstring($decodedstring);

            if (!$size || $size[0] == 0 || $size[1] == 0 || !$size['mime']) {
                $fail('The :attribute must be image.');
                break;
            }
        }
        //

    }
}
