<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NigerianCityInState implements ValidationRule
{
    protected $state;
    protected $cities;

    public function __construct($state)
    {
        $this->state = $state;
        $statesAndCities = config('nigerian_states_and_cities');
        $this->cities = $statesAndCities[$state] ?? [];
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! in_array($value, $this->cities)){
            $fail($this->message());
        }
    }

    public function message()
    {
        return 'The :attribute must be a valid city in ' . $this->state . '.';
    }
}

