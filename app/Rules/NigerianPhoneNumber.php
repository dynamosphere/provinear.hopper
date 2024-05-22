<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NigerianPhoneNumber implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! preg_match('/^(?:\+234|0)[789]\d{9}$/', $value)){
            $fail($this->message());
        }
    }

    public function message()
    {
        return 'The :attribute must be a valid Nigerian phone number.';
    }
}
