<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneNumber implements Rule
{
    public function passes($attribute, $value)
    {
        if (!is_string($value) || !preg_match('/^\+?[0-9][0-9 ().-]*[0-9]$/D', $value)) {
            return false;
        }

        $digitCount = preg_match_all('/[0-9]/', $value);

        return $digitCount >= 7 && $digitCount <= 15;
    }

    public function message()
    {
        return 'The :attribute must be a valid phone number containing 7 to 15 digits.';
    }
}