<?php

namespace MatthewPageUK\BittyEnums\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use MatthewPageUK\BittyEnums\Contracts\BittyEnum;

/**
 * Validates the class is a BittyEnum interface
 */
class ClassType implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_a($value, BittyEnum::class, true)) {
            $fail("Invalid BittyEnum - not a BittyEnum Interface: {$value}");
        }
    }
}
