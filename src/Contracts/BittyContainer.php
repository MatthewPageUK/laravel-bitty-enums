<?php

namespace MatthewPageUK\BittyEnums\Contracts;

/**
 * A container for holding and querying bitwise enum cases.
 */
interface BittyContainer
{
    public function getValidator(): BittyValidator;

    /**
     * Create a new container to hold the provided enum class
     * and default to the selected integer value.
     */
    public function __construct(string $class, int $selected = 0);

    /**
     * Clear unset all the container selections
     */
    public function clear(): BittyContainer;

    /**
     * Get the choices set in the container as an array of enums
     */
    public function getChoices(): array;

    /**
     * Get the integer value of the container
     */
    public function getValue(): int;

    /**
     * Does the container have the provided case set
     */
    public function has(BittyEnum $choice): bool;

    /**
     * Does the container have all the provided cases set
     */
    public function hasAll(array|BittyContainer $choices): bool;

    /**
     * Does the container have any of the provided cases set
     */
    public function hasAny(array|BittyContainer $choices): bool;

    /**
     * Set the provided case in the container
     */
    public function set(array|BittyContainer|BittyEnum $choice): BittyContainer;

    /**
     * Sets all the cases in the container
     */
    public function setAll(): BittyContainer;

    public function setClass(string $class): BittyContainer;

    /**
     * Unset the provided case in the container
     */
    public function unset(array|BittyContainer|BittyEnum $choice): BittyContainer;

    /**
     * Create and return a new container from an array of enums.
     *
     * @todo ????
     *
     * @throws BittyEnumException
     */
    public static function fromArrayOfEnums(string $class, array $choices): BittyContainer;
}
