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

// WIP
// ---
// it('can create a new container from array of enums', function () {
//     $container = Support\Container::fromArrayOfEnums(Good\Warning::class, [
//         Good\Warning::LowFuel,              // 1
//         Good\Warning::CheckEngine,          // 2
//         Good\Warning::TyrePressure,         // 4
//     ]);
//     expect($container->getValue())->toBe(7);
// });

// it('throws an exception when creating a new container from array of enums with wrong class', function () {
//     Support\Container::fromArrayOfEnums(Good\Warning::class, [
//         Good\Warning::LowFuel,              // 1
//         Good\Colour::Red,                   // 1 - wrong class
//     ]);
// })->throws(\InvalidArgumentException::class);
