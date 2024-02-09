<?php

namespace MatthewPageUK\BitwiseEnums\Traits;

use MatthewPageUK\BitwiseEnums\BitwiseEnumContainer;
use MatthewPageUK\BitwiseEnums\Contracts\BitwiseEnum;

trait WithBitwiseEnumQueryScope
{
    /**
     * Scope a query to only include records with a specific bitwise enum value.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $column
     * @param BitwiseEnum $choice
     * @todo
     */
    public function scopeWhereBitwiseEnumHas($query, $column, BitwiseEnum $choice)
    {
        // check casts to match choice to enum class...
        return $query->whereRaw("({$column} & {$choice->value}) = {$choice->value}");
    }

    /**
     * Scope a query to only include records with any of the
     * bitwise enum values in the provided container.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $column
     * @param BitwiseEnumContainer $choices
     */
    public function scopeWhereBitwiseEnumHasAny($query, $column, BitwiseEnumContainer $choices)
    {
        return $query->whereRaw("({$column} & {$choices->getValue()}) > 0");
    }

    /**
     * Scope a query to only include records with all of the
     * bitwise enum values in the provided container.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $column
     * @param BitwiseEnumContainer $choices
     */
    public function scopeWhereBitwiseEnumHasAll($query, $column, BitwiseEnumContainer $choices)
    {
        return $query->whereRaw("({$column} & {$choices->getValue()}) = {$choices->getValue()}");
    }
}