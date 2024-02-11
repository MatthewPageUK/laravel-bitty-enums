<?php

namespace MatthewPageUK\BittyEnums\Contracts;

use Illuminate\Database\Eloquent\Builder;

/**
 * Bitty Enum Validator Contract
 *
 * Used to make sure any BittyEnums used are well formed and valid.
 *
 * @method BittyValidator setClass(string $class)
 * @method BittyValidator validateCaseName(string $name)
 * @method BittyValidator validateCases(string $class)
 * @method BittyValidator validateChoice(BittyEnum $choice, ?string $class = null)
 * @method BittyValidator validateClass(string $class)
 * @method BittyValidator validateQuery(Builder $query, string $column, BittyEnum $choice)
 * @method BittyValidator validateValues(string $class)
 */
interface BittyValidator
{
    /**
     * Create a new BittyValidator instance set to accept
     * the provided bitty enum class. If no class is provided
     * the validator will not be able to perform validations
     * against a class.
     *
     * @throws BittyEnumException
     */
    public function __construct(?string $class = null);

    /**
     * Set and validate the class to match choices against.
     *
     * @throws BittyEnumException
     */
    public function setClass(string $class): BittyValidator;

    /**
     * Validate the case name is a valid PHP constant name.
     *
     * @throws BittyEnumException
     */
    public function validateCaseName(string $name): BittyValidator;

    /**
     * Validate the number of cases.
     *
     * @throws BittyEnumException
     */
    public function validateCases(string $class): BittyValidator;

    /**
     * Validate the choice matches either the base class or the
     * supplied class.
     *
     * @throws BittyEnumException
     */
    public function validateChoice(BittyEnum $choice, ?string $class = null): BittyValidator;

    /**
     * Validate the class is of correct type (BittyEnum Interface)
     *
     * @throws BittyEnumException
     */
    public function validateClass(string $class): BittyValidator;

    /**
     * Validate the scope query to ensure the column is cast to
     * a BittyEnum and the choice is of the correct type.
     *
     * @throws BittyEnumException
     */
    public function validateQuery(Builder $query, string $column, BittyEnum $choice): BittyValidator;

    /**
     * Validate the values are powers of two, in order and
     * start at one.
     *
     * @throws BittyEnumException
     */
    public function validateValues(string $class): BittyValidator;
}
