<?php

namespace MatthewPageUK\BittyEnums\Contracts;

/**
 * Bitty Enum Validator
 *
 * Used to make sure any BittyEnums used are well formed and valid.
 *
 * @method BittyValidator validateClass(string $class)
 * @method BittyValidator validateCases(string $class)
 * @method BittyValidator validateValues(string $class)
 * @method BittyValidator validateChoice(BittyEnum $choice, ?string $class = null)
 */
interface BittyValidator
{
    /**
     * Create a new BittyValidator instance set to the provided
     * bitty enum class.
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(string $class);

    /**
     * Validate the class is of correct type.
     *
     * @throws \InvalidArgumentException
     */
    public function validateClass(string $class): BittyValidator;

    /**
     * Validate the number of cases.
     *
     * @throws \InvalidArgumentException
     */
    public function validateCases(string $class): BittyValidator;

    /**
     * Validate the values are powers of two.
     *
     * @throws \InvalidArgumentException
     */
    public function validateValues(string $class): BittyValidator;

    /**
     * Validate the choice is of correct type.
     *
     * @throws \InvalidArgumentException
     */
    public function validateChoice(BittyEnum $choice, ?string $class = null): BittyValidator;
}
