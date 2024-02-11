<?php

namespace MatthewPageUK\BittyEnums\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use MatthewPageUK\BittyEnums\Contracts\BittyEnum;

/**
 * Validates the class matches the expected type
 */
class MatchClass implements ValidationRule
{
    public function __construct(
        protected string $class = BittyEnum::class
    ) {
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_a($value, $this->class, true)) {
            $fail("Invalid BittyEnum - does not match expected type : {$this->class} ");
        }
    }
}
