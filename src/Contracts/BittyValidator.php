<?php

namespace MatthewPageUK\BittyEnums\Contracts;

interface BittyValidator
{
    /**
     * Create a new BittyValidator instance.
     *
     * @return void
     */
    public function __construct(string $class);

    /**
     * Validate the class is of correct type.
     */
    public function validateClass(string $class): self;

    /**
     * Validate the number of cases.
     */
    public function validateCases(string $class): self;

    /**
     * Validate the values are powers of two.
     */
    public function validateValues(string $class): self;

    /**
     * Validate the choice is of correct type.
     */
    public function validateChoice(BittyEnum $choice): self;
}
