<?php

namespace MatthewPageUK\BittyEnums\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\Builder;

/**
 * Validates the choice matches the query model column cast class
 */
class MatchCastClass implements ValidationRule
{
    public function __construct(
        protected Builder $query,
        protected string $column,
    ) {
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $modelCasts = collect($this->query->getModel()->getCasts());

        $cast = $modelCasts->has($this->column) ? $modelCasts[$this->column] : ':';

        [$castType, $enumClass] = explode(':', $cast);

        if (! is_a($value, $enumClass)) {
            $fail("Invalid Bitty Query - The column '{$this->column}' is cast to a BittyEnum of type '{$enumClass}'.");
        }

    }
}
