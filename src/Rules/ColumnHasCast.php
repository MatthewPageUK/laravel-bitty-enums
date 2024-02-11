<?php

namespace MatthewPageUK\BittyEnums\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use MatthewPageUK\BittyEnums\Casts\BittyEnumCast;

/**
 * Validates the query model column is cast to supplied class
 */
class ColumnHasCast implements ValidationRule
{
    public function __construct(
        protected string $column
    ) {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $modelCasts = collect($value->getModel()->getCasts());
        $cast = $modelCasts->has($this->column) ? $modelCasts[$this->column].':' : '';

        if (! str_contains($cast, BittyEnumCast::class)) {
            $fail("Invalid Bitty Query - The column '{$this->column}' is not cast to a BittyEnum.");
        }
    }
}
