<?php

namespace MatthewPageUK\BittyEnums\Traits;

use Illuminate\Database\Eloquent\Builder;
use MatthewPageUK\BittyEnums\Contracts\BittyContainer;
use MatthewPageUK\BittyEnums\Contracts\BittyEnum;

trait WithBittyEnumQueryScope
{
    /**
     * Scope a query to only include records with a specific bitty enum value.
     *
     * @todo
     */
    public function scopeWhereBittyEnumHas(Builder $query, string $column, BittyEnum $choice): Builder
    {
        return $query->whereRaw(
            sprintf('(%s & %d) = %d', $column, (int) $choice->value, (int) $choice->value)
        );

        // Why does this not work?
        // return $query->whereRaw('(:col & :val) = :val', ['col' => $column, 'val' => $choice->value]);
    }

    /**
     * Scope the query to only include records that don't have a specific bitty enum value.
     */
    public function scopeWhereBittyEnumDoesntHave(Builder $query, string $column, BittyEnum $choice): Builder
    {
        return $query->whereRaw(
            sprintf('(%s & %d) = 0', $column, (int) $choice->value)
        );
    }

    /**
     * Scope the query to only include records that do not have any of the
     * bitty enum values in the provided container.
     */
    public function scopeWhereBittyEnumDoesntHaveAny(Builder $query, string $column, BittyContainer $choices): Builder
    {
        return $query->whereRaw(
            sprintf('(%s & %d) = 0', $column, (int) $choices->getValue())
        );
    }

    /**
     * Scope a query to only include records with any of the
     * bitty enum values in the provided container.
     */
    public function scopeWhereBittyEnumHasAny(Builder $query, string $column, BittyContainer $choices): Builder
    {
        return $query->whereRaw(
            sprintf('(%s & %d) > 0', $column, (int) $choices->getValue())
        );
    }

    /**
     * Scope a query to only include records with all of the
     * bitty enum values in the provided container.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $column
     */
    public function scopeWhereBittyEnumHasAll($query, $column, BittyContainer $choices)
    {
        return $query->whereRaw(
            sprintf('(%s & %d) = %d', $column, (int) $choices->getValue(), (int) $choices->getValue())
        );
    }
}
