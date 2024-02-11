<?php

namespace MatthewPageUK\BittyEnums\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Validates the class values start at one
 */
class StartAtOne implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (collect($value::cases())->first()?->value !== 1) {
            $fail('Invalid BittyEnum - first value must be 1');
        }
    }
}
