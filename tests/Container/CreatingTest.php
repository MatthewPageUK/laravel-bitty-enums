<?php

use MatthewPageUK\BittyEnums\Contracts\BittyContainer;
use MatthewPageUK\BittyEnums\Exceptions\BittyEnumException;
use MatthewPageUK\BittyEnums\Tests\Enums\Bad;
use MatthewPageUK\BittyEnums\Tests\Enums\Good;

/**
 * Creating a new container
 */
it('can create a new container', function () {
    $container = app()->make(BittyContainer::class)
        ->setClass(Good\Warning::class);

    expect($container)->toBeInstanceOf(BittyContainer::class);
    expect($container->getValue())->toBe(0);
});

it('can create a new container with no class', function () {
    $container = app()->make(BittyContainer::class);

    expect($container)->toBeInstanceOf(BittyContainer::class);
    expect($container->getValue())->toBe(0);
});

it('can set container class after creation', function () {
    $container = app()->make(BittyContainer::class)
        ->setClass(Good\Warning::class)
        ->set(Good\Warning::LowFuel);       // 1

    expect($container)->toBeInstanceOf(BittyContainer::class);
    expect($container->getValue())->toBe(1);
});

it('registers bindings for BittyContainer contract', function () {
    $container = $this->app->make(BittyContainer::class);

    expect($container)->toBeInstanceOf(BittyContainer::class);
});

/**
 * Container validation
 */
it('throws an exception if the container enum class is invalid', function () {
    app()->make(BittyContainer::class)
        ->setClass(Bad\BadValue::class);

})->throws(BittyEnumException::class);
