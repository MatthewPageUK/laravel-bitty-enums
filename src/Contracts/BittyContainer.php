<?php

namespace MatthewPageUK\BittyEnums\Contracts;

interface BittyContainer
{
    public function __construct(string $class, int $selected = 0);

    public function set(BittyEnum $choice): BittyContainer;

    public function unset(BittyEnum $choice): BittyContainer;

    public function has(BittyEnum $choice): bool;

    /**
     * Get the choices in the container as an array of enums
     */
    public function getChoices(): array;

    /**
     * Get the integer value of the container
     */
    public function getValue(): int;

    /**
     * Clear the container selections
     */
    public function clear(): BittyContainer;

    /**
     * Sets all the cases in the container
     */
    public function setAll(): BittyContainer;

    /**
     * Create and return a new container from an array of enums.
     *
     * @throws \InvalidArgumentException
     */
    public static function fromArrayOfEnums(string $class, array $choices): BittyContainer;
}
