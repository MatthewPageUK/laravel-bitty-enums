<?php

namespace MatthewPageUK\BitwiseEnums;

use MatthewPageUK\BitwiseEnums\Contracts\BitwiseEnum;

class BitwiseEnumContainer
{
    public function __construct(
        protected string $enumClass,
        protected int $selected = 0
    ) {
        $this->validateEnumClass($this->enumClass)
             ->validateEnumCases($this->enumClass)
             ->validateEnumValues($this->enumClass);
    }

    protected function validateEnumClass(string $class): self
    {
        if (! is_a($class, BitwiseEnum::class, true)) {
            throw new \InvalidArgumentException("Invalid enum - not a BitwiseEnum Interface: {$class}");
        }

        if (count($class::cases()) > 16) {
            throw new \InvalidArgumentException("Invalid enum - too many values, max 16 bits: {$class}");
        }

        return $this;
    }

    protected function validateEnumCases(string $class): self
    {
        if (count($class::cases()) > 16) {
            throw new \InvalidArgumentException("Invalid enum - too many values, max 16 bits: {$class}");
        }

        return $this;
    }

    protected function validateEnumValues(string $class): self
    {
        foreach ($class::cases() as $choice) {
            if (! $this->isPowerOfTwo($choice->value)) {
                throw new \InvalidArgumentException("Invalid enum - value not a power of two: {$choice->name}");
            }
        }

        return $this;
    }

    protected function isPowerOfTwo(int $value): bool
    {
        return ($value & ($value - 1)) === 0;
    }

    public function set(BitwiseEnum $choice): self
    {
        $this->validateChoice($choice);
        $this->selected |= $choice->value;

        return $this;
    }

    public function unset(BitwiseEnum $choice): self
    {
        $this->validateChoice($choice);
        $this->selected &= ~$choice->value;

        return $this;
    }

    public function has(BitwiseEnum $choice): bool
    {
        $this->validateChoice($choice);

        return $this->selected & $choice->value;
    }

    protected function validateChoice($choice): self
    {
        if (! is_a($choice, $this->enumClass)) {
            throw new \InvalidArgumentException("Invalid enum - expected {$this->enumClass}, found ....");
        }

        return $this;
    }

    public function getChoices(): array
    {
        return array_filter($this->enumClass::cases(), function ($choice) {
            return $this->has($choice);
        });
    }

    public function getValue(): int
    {
        return $this->selected;
    }

    public function clear(): self
    {
        $this->selected = 0;
        return $this;
    }

    public function setAll(): self
    {
        $this->selected = array_reduce(
            $this->enumClass::cases(),
            fn($carry, $item) => $carry + $item->value,
            0
        );

        return $this;
    }

}