<?php

namespace MatthewPageUK\BittyEnums\Support\Traits;

trait WithContainerIterator
{
    protected int $position = 0;

    public function rewind(): void
    {
        $this->position = 0;
    }

    #[\ReturnTypeWillChange]
    public function current()
    {
        return $this->getChoices()[$this->position];
    }

    #[\ReturnTypeWillChange]
    public function key()
    {
        return $this->position;
    }

    public function next(): void
    {
        $this->position++;
    }

    public function valid(): bool
    {
        return isset($this->getChoices()[$this->position]);
    }
}
