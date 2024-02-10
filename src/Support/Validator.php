<?php

namespace MatthewPageUK\BittyEnums\Support;

use MatthewPageUK\BittyEnums\Contracts\BittyEnum;
use MatthewPageUK\BittyEnums\Contracts\BittyValidator;

class Validator implements BittyValidator
{
    public function __construct(
        protected string $class
    ) {
        $this->validateClass($this->class)
            ->validateCases($this->class)
            ->validateValues($this->class);
    }

    public function validateClass(string $class): BittyValidator
    {
        if (! is_a($class, BittyEnum::class, true)) {
            throw new \InvalidArgumentException("Invalid BittyEnum - not a BittyEnum Interface: {$class}");
        }

        return $this;
    }

    public function validateCases(string $class): BittyValidator
    {
        if ($class::cases() === [] || $class::cases() === null) {
            throw new \InvalidArgumentException("Invalid BittyEnum - no cases defined: {$class}");
        }

        if (count($class::cases()) > 16) {
            throw new \InvalidArgumentException("Invalid BittyEnum - too many values, max 16 bits: {$class}");
        }

        return $this;
    }

    public function validateValues(string $class): BittyValidator
    {
        if ($class::cases()[0]->value !== 1) {
            throw new \InvalidArgumentException("Invalid BittyEnum - first value must be 1: {$class}");
        }

        $value = 1;
        foreach ($class::cases() as $choice) {
            if ($choice->value & ($choice->value - 1) !== 0) {
                throw new \InvalidArgumentException("Invalid BittyEnum - value not a power of two: {$class} {$choice->name}");
            }

            if ($choice->value !== $value) {
                throw new \InvalidArgumentException("Invalid BittyEnum - values must be in order: {$class} {$choice->name}");
            }

            $value *= 2;
        }

        return $this;
    }

    public function validateChoice(BittyEnum $choice, ?string $class = null): BittyValidator
    {
        $class = $class ?? $this->class;

        if (! is_a($choice, $class)) {
            throw new \InvalidArgumentException("Invalid BittyEnum class - expected {$this->class}");
        }

        return $this;
    }
}
