<?php

namespace MatthewPageUK\BittyEnums\Support;

use MatthewPageUK\BittyEnums\Contracts\BittyContainer;
use MatthewPageUK\BittyEnums\Contracts\BittyEnum;
use MatthewPageUK\BittyEnums\Contracts\BittyValidator;

class Container implements BittyContainer
{
    protected BittyValidator $validator;

    public function __construct(
        protected string $class,
        protected int $selected = 0
    ) {
        $this->validator = new Validator($this->class);
    }

    public function set(BittyEnum $choice): BittyContainer
    {
        $this->validator->validateChoice($choice);
        $this->selected |= $choice->value;

        return $this;
    }

    public function unset(BittyEnum $choice): BittyContainer
    {
        $this->validator->validateChoice($choice);
        $this->selected &= ~$choice->value;

        return $this;
    }

    public function has(BittyEnum $choice): bool
    {
        $this->validator->validateChoice($choice);

        return $this->selected & $choice->value;
    }

    public function getChoices(): array
    {
        return array_filter($this->class::cases(), function ($choice) {
            return $this->has($choice);
        });
    }

    public function getValue(): int
    {
        return $this->selected;
    }

    public function clear(): BittyContainer
    {
        $this->selected = 0;

        return $this;
    }

    public function setAll(): BittyContainer
    {
        // tidy this up, there's a neater way I suspect
        $this->selected = array_reduce(
            $this->class::cases(),
            fn ($carry, $item) => $carry + $item->value,
            0
        );

        return $this;
    }

    public static function fromArrayOfEnums(string $class, array $choices): BittyContainer
    {
        $container = new self($class);

        foreach ($choices as $choice) {
            $container->set($choice);
        }

        return $container;
    }
}
