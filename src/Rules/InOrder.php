<?php

namespace MatthewPageUK\BittyEnums\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Validates the values are in order
 */
class InOrder implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $nextValue = 1;
        foreach ($value::cases() as $choice) {
            if ($choice->value !== $nextValue) {
                $fail("Invalid BittyEnum - values must be in order: {$value} {$choice->name}");
            }

            $nextValue *= 2;
        }
    }
}
