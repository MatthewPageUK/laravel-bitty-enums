<?php

namespace MatthewPageUK\BittyEnums\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Validates the query model has the column specified
 */
class ModelHasColumn implements ValidationRule
{
    public function __construct(
        protected string $column
    ) {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $modelCasts = collect($value->getModel()->getCasts());

        if (! $modelCasts->has($this->column)) {
            $fail("Invalid Bitty Query - The column '{$this->column}' is not cast.");
        }
    }
}
