<?php

namespace MatthewPageUK\BittyEnums\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoCases implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value::cases() === [] || $value::cases() === null) {
            $fail("Invalid BittyEnum - no cases defined: {$value}");
        }
    }
}
