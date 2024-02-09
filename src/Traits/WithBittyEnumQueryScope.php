<?php

namespace MatthewPageUK\BittyEnums\Traits;

use MatthewPageUK\BittyEnums\BittyEnumContainer;
use MatthewPageUK\BittyEnums\Contracts\BittyEnum;

trait WithBittyEnumQueryScope
{
    /**
     * Scope a query to only include records with a specific bitty enum value.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $column
     * @param BittyEnum $choice
     * @todo
     */
    public function scopeWhereBittyEnumHas($query, $column, BittyEnum $choice)
    {
        // check casts to match choice to enum class...
        return $query->whereRaw("({$column} & {$choice->value}) = {$choice->value}");
    }

    /**
     * Scope a query to only include records with any of the
     * bitty enum values in the provided container.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $column
     * @param BittyEnumContainer $choices
     */
    public function scopeWhereBittyEnumHasAny($query, $column, BittyEnumContainer $choices)
    {
        return $query->whereRaw("({$column} & {$choices->getValue()}) > 0");
    }

    /**
     * Scope a query to only include records with all of the
     * bitty enum values in the provided container.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $column
     * @param BittyEnumContainer $choices
     */
    public function scopeWhereBittyEnumHasAll($query, $column, BittyEnumContainer $choices)
    {
        return $query->whereRaw("({$column} & {$choices->getValue()}) = {$choices->getValue()}");
    }
}