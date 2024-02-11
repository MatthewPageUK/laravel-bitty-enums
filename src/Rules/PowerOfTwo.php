<?php

namespace MatthewPageUK\BittyEnums\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Validates the class has values that are a power of two
 */
class PowerOfTwo implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        foreach ($value::cases() as $choice) {
            if ($choice->value & ($choice->value - 1) !== 0) {
                $fail("Invalid BittyEnum - value not a power of two: {$value} {$choice->name}");
            }
        }
    }
}
