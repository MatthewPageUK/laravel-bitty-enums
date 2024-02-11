<?php

namespace MatthewPageUK\BittyEnums\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Validates that a string is a valid BittyEnum case name
 *
 * https://www.php.net/manual/en/language.constants.php
 */
class CaseName implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! preg_match('/^[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*$/', $value)) {
            $fail("Invalid BittyEnum case name - {$value}");
        }
    }
}
