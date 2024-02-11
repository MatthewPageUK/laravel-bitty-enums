<?php

namespace MatthewPageUK\BittyEnums\Contracts;

use Illuminate\Database\Eloquent\Builder;

/**
 * Bitty Enum Validator
 *
 * Used to make sure any BittyEnums used are well formed and valid.
 *
 * @method BittyValidator validateClass(string $class)
 * @method BittyValidator validateCases(string $class)
 * @method BittyValidator validateValues(string $class)
 * @method BittyValidator validateChoice(BittyEnum $choice, ?string $class = null)
 * @method BittyValidator validateQuery(Builder $query, string $column, BittyEnum $choice)
 */
interface BittyValidator
{
    /**
     * Create a new BittyValidator instance set to the provided
     * bitty enum class.
     *
     * @throws BittyEnumException
     */
    public function __construct(string $class);

    /**
     * Validate the class is of correct type.
     *
     * @throws BittyEnumException
     */
    public function validateClass(string $class): BittyValidator;

    /**
     * Validate the number of cases.
     *
     * @throws BittyEnumException
     */
    public function validateCases(string $class): BittyValidator;

    /**
     * Validate the values are powers of two.
     *
     * @throws BittyEnumException
     */
    public function validateValues(string $class): BittyValidator;

    /**
     * Validate the choice is of correct type.
     *
     * @throws BittyEnumException
     */
    public function validateChoice(BittyEnum $choice, ?string $class = null): BittyValidator;

    /**
     * Validate the scope query to ensure the column is cast to a BittyEnum
     * and the choice is of the correct type.
     *
     * @throws BittyEnumException
     */
    public function validateQuery(Builder $query, string $column, BittyEnum $choice): BittyValidator;
}
