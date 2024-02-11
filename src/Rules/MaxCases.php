<?php

namespace MatthewPageUK\BittyEnums\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Validates the number of cases is less than or equal to the max bits
 */
class MaxCases implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (count($value::cases()) > config('bitty-enums.max_bits')) {
            $fail("Invalid BittyEnum - too many values, max 16 bits: {$value}");
        }
    }
}
