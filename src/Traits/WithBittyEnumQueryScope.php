<?php

namespace MatthewPageUK\BittyEnums\Traits;

use Illuminate\Database\Eloquent\Builder;
use MatthewPageUK\BittyEnums\Contracts\BittyContainer;
use MatthewPageUK\BittyEnums\Contracts\BittyEnum;
use MatthewPageUK\BittyEnums\Contracts\BittyValidator;

trait WithBittyEnumQueryScope
{
    protected function getBittyValidator(): BittyValidator
    {
        return app()->make(BittyValidator::class);
    }

    /**
     * Scope a query to only include records with a specific bitty enum value.
     *
     * @throws \MatthewPageUK\BittyEnums\Exceptions\BittyEnumException
     */
    public function scopeWhereBittyEnumHas(Builder $query, string $column, BittyEnum $choice): Builder
    {
        $this->getBittyValidator()->validateQuery($query, $column, $choice);

        return $query->whereRaw(
            sprintf('(%s & %d) = %d', $column, (int) $choice->value, (int) $choice->value)
        );
    }

    /**
     * Scope the query to only include records that don't have a specific bitty enum value.
     *
     * @throws \MatthewPageUK\BittyEnums\Exceptions\BittyEnumException
     */
    public function scopeWhereBittyEnumDoesntHave(Builder $query, string $column, BittyEnum $choice): Builder
    {
        $this->getBittyValidator()->validateQuery($query, $column, $choice);

        return $query->whereRaw(
            sprintf('(%s & %d) = 0', $column, (int) $choice->value)
        );
    }

    /**
     * Scope the query to only include records that do not have any of the
     * bitty enum values in the provided container.
     *
     * @throws \MatthewPageUK\BittyEnums\Exceptions\BittyEnumException
     */
    public function scopeWhereBittyEnumDoesntHaveAny(Builder $query, string $column, array|BittyContainer $choices): Builder
    {
        $this->getBittyValidator()->validateQuery($query, $column, $choices);

        $choices = $this->prepareBittyEnumChoices($choices);

        return $query->whereRaw(
            sprintf('(%s & %d) = 0', $column, (int) $choices->getValue())
        );
    }

    /**
     * Scope a query to only include records with any of the
     * bitty enum values in the provided container.
     *
     * @throws \MatthewPageUK\BittyEnums\Exceptions\BittyEnumException
     */
    public function scopeWhereBittyEnumHasAny(Builder $query, string $column, array|BittyContainer $choices): Builder
    {
        $this->getBittyValidator()->validateQuery($query, $column, $choices);

        $choices = $this->prepareBittyEnumChoices($choices);

        return $query->whereRaw(
            sprintf('(%s & %d) > 0', $column, (int) $choices->getValue())
        );
    }

    /**
     * Scope a query to only include records with all of the
     * bitty enum values in the provided container.
     *
     * @throws \MatthewPageUK\BittyEnums\Exceptions\BittyEnumException
     */
    public function scopeWhereBittyEnumHasAll(Builder $query, string $column, array|BittyContainer $choices)
    {
        $this->getBittyValidator()->validateQuery($query, $column, $choices);

        $choices = $this->prepareBittyEnumChoices($choices);

        return $query->whereRaw(
            sprintf('(%s & %d) = %d', $column, (int) $choices->getValue(), (int) $choices->getValue())
        );
    }

    /**
     * Prepare the choices for validation.
     */
    protected function prepareBittyEnumChoices(array|BittyContainer $choices): BittyContainer
    {
        if (is_array($choices)) {
            return app()->make(BittyContainer::class)
                ->setClass($choices[0]::class)
                ->set($choices);
        }

        return $choices;
    }
}
