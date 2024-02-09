<?php

namespace MatthewPageUK\BittyEnums\Contracts;

interface BittyContainer
{
    public function __construct(string $class, int $selected = 0);

    public function set(BittyEnum $choice): self;

    public function unset(BittyEnum $choice): self;

    public function has(BittyEnum $choice): bool;

    public function getChoices(): array;

    public function getValue(): int;

    public function clear(): self;

    public function setAll(): self;

}