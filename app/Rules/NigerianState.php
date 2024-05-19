<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NigerianState implements ValidationRule
{
    protected $states;

    public function __construct()
    {
        $this->states = array_keys(config('nigerian_states_and_cities'));
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! in_array($value, $this->states)){
            $fail($this->message());
        }
    }


    public function message()
    {
        return 'The :attribute must be a valid Nigerian state.';
    }
}
