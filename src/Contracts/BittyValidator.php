<?php

namespace MatthewPageUK\BittyEnums\Contracts;

interface BittyValidator
{
    /**
     * Create a new BittyValidator instance.
     *
     * @param string $class
     * @return void
     */
    public function __construct(string $class);

    /**
     * Validate the class is of correct type.
     *
     * @param string $class
     * @return self
     */
    public function validateClass(string $class): self;

    /**
     * Validate the number of cases.
     *
     * @param string $class
     * @return self
     */
    public function validateCases(string $class): self;

    /**
     * Validate the values are powers of two.
     *
     * @param string $class
     * @return self
     */
    public function validateValues(string $class): self;

    /**
     * Validate the choice is of correct type.
     *
     * @param BittyEnum $choice
     * @return self
     */
    public function validateChoice(BittyEnum $choice): self;

}