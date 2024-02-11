<?php

namespace MatthewPageUK\BittyEnums\Support;

use Iterator;
use MatthewPageUK\BittyEnums\Contracts\BittyContainer;
use MatthewPageUK\BittyEnums\Contracts\BittyEnum;
use MatthewPageUK\BittyEnums\Contracts\BittyValidator;
use MatthewPageUK\BittyEnums\Exceptions\InvalidClassException;
use MatthewPageUK\BittyEnums\Support\Traits\WithContainerIterator;

class Container implements BittyContainer, Iterator
{
    use WithContainerIterator;

    protected BittyValidator $validator;

    public function __construct(
        protected ?string $class = null,
        protected int $selected = 0
    ) {
        if ($this->class !== null) {
            $this->setClass($class);
        }
    }

    protected function setValidator(string $class): BittyContainer
    {
        $this->validator = app()->makeWith(BittyValidator::class, ['class' => $class]);

        return $this;
    }

    public function setClass(string $class): BittyContainer
    {
        $this->setValidator($class);
        $this->class = $class;

        return $this;
    }

    public function clear(): BittyContainer
    {
        $this->selected = 0;

        return $this;
    }

    public function getChoices(): array
    {
        $this->requiresClass();

        return array_filter($this->class::cases(), function ($choice) {
            return $this->has($choice);
        });
    }

    public function getValue(): int
    {
        return $this->selected;
    }

    public function getValidator(): BittyValidator
    {
        return $this->validator;
    }

    public function has(BittyEnum $choice): bool
    {
        $this->requiresClass()
            ->getValidator()
            ->validateChoice($choice);

        return $this->selected & $choice->value;
    }

    public function hasAny(array|BittyContainer $choices): bool
    {
        $this->requiresClass();

        // @todo - validateChoices()

        if ($choices instanceof BittyContainer) {
            $choices = $choices->getChoices();
        }

        foreach ($choices as $choice) {
            if ($this->has($choice)) {
                return true;
            }
        }

        return false;
    }

    public function hasAll(array|BittyContainer $choices): bool
    {
        $this->requiresClass();

        if ($choices instanceof BittyContainer) {
            $choices = $choices->getChoices();
        }

        if (count($choices) === 0) {
            return false;
        }

        foreach ($choices as $choice) {
            if (! $this->has($choice)) {
                return false;
            }
        }

        return true;
    }

    protected function requiresClass(): BittyContainer
    {
        if ($this->class === null) {
            throw new InvalidClassException('Invalid BittyEnum - container has no class, can not update values');
        }

        return $this;
    }

    public function set(array|BittyContainer|BittyEnum $choice): BittyContainer
    {
        $this->requiresClass();
        $this->rewind();

        if ($choice instanceof BittyContainer) {
            foreach ($choice->getChoices() as $item) {
                $this->set($item);
            }

            return $this;
        }

        if (is_array($choice)) {
            foreach ($choice as $item) {
                $this->set($item);
            }

            return $this;
        }

        $this->getValidator()->validateChoice($choice);
        $this->selected |= $choice->value;

        return $this;
    }

    public function setAll(): BittyContainer
    {
        $this->requiresClass();
        $this->rewind();

        // tidy this up, there's a neater way I suspect
        $this->selected = array_reduce(
            $this->class::cases(),
            fn ($carry, $item) => $carry + $item->value,
            0
        );

        return $this;
    }

    public function unset(array|BittyContainer|BittyEnum $choice): BittyContainer
    {
        $this->requiresClass();
        $this->rewind();

        if ($choice instanceof BittyContainer) {
            $choice = $choice->getChoices();
        }

        if (is_array($choice)) {
            foreach ($choice as $item) {
                $this->unset($item);
            }

            return $this;
        }

        $this->getValidator()->validateChoice($choice);

        $this->selected &= ~$choice->value;

        return $this;
    }

    public static function fromArrayOfEnums(string $class, array $choices): BittyContainer
    {
        $container = app()->makeWith(BittyContainer::class, ['class' => $class]);

        foreach ($choices as $choice) {
            $container->set($choice);
        }

        return $container;
    }
}
