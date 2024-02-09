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

    public function validateClass(string $class): self
    {
        if (! is_a($class, BittyEnum::class, true)) {
            throw new \InvalidArgumentException("Invalid BittyEnum - not a BittyEnum Interface: {$class}");
        }

        return $this;
    }

    public function validateCases(string $class): self
    {
        if (count($class::cases()) > 16) {
            throw new \InvalidArgumentException("Invalid BittyEnum - too many values, max 16 bits: {$class}");
        }

        return $this;
    }

    public function validateValues(string $class): self
    {
        foreach ($class::cases() as $choice) {
            if ($choice->value & ($choice->value - 1) !== 0) {
                throw new \InvalidArgumentException("Invalid BittyEnum - value not a power of two: {$class} {$choice->name}");
            }
        }

        return $this;
    }

    public function validateChoice(BittyEnum $choice): self
    {
        if (! is_a($choice, $this->class)) {
            throw new \InvalidArgumentException("Invalid BittyEnum class - expected {$this->class}");
        }

        return $this;
    }
}
