<?php

namespace MatthewPageUK\BittyEnums\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Validates the class has cases defined
 */
class NoCases implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value::cases() === [] || $value::cases() === null) {
            $fail("Invalid BittyEnum - no cases defined: {$value}");
        }
    }
}
