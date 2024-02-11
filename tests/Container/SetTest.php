<?php

use MatthewPageUK\BittyEnums\Contracts\BittyContainer;
use MatthewPageUK\BittyEnums\Exceptions\BittyEnumException;
use MatthewPageUK\BittyEnums\Tests\Enums\Good;

/**
 * Setting single values
 */
it('can set a value', function () {
    $container = app()->make(BittyContainer::class)
        ->setClass(Good\Warning::class)
        ->set(Good\Warning::LowFuel);       // 1

    expect($container->getValue())->toBe(1);
});

it('can chain multiple sets', function () {
    $container = app()->make(BittyContainer::class)
        ->setClass(Good\Warning::class)
        ->set(Good\Warning::LowFuel)          // 1
        ->set(Good\Warning::CheckEngine)      // 2
        ->set(Good\Warning::TyrePressure);    // 4

    expect($container->getValue())->toBe(7);
});

it('throws exception if wrong enum type is set', function () {
    $container = app()->make(BittyContainer::class)
        ->setClass(Good\Warning::class)
        ->set(Good\Warning::CheckEngine)
        ->set(Good\Colour::Red);              // wrong class

})->throws(BittyEnumException::class);

/**
 * Setting all the values
 */
it('can set all values', function () {
    $total = array_reduce(Good\Warning::cases(), fn ($carry, $item) => $carry + $item->value, 0);
    $container = app()->make(BittyContainer::class)
        ->setClass(Good\Warning::class)
        ->setAll();

    expect($container->getValue())->toBe($total);
});

/**
 * Setting from an array of Enums
 */
it('can accept an array of enums', function () {
    $container = app()->make(BittyContainer::class)
        ->setClass(Good\Warning::class)
        ->set([
            Good\Warning::LowFuel,              // 1
            Good\Warning::CheckEngine,          // 2
            Good\Warning::TyrePressure,         // 4
        ]);

    expect($container->getValue())->toBe(7);
});

it('throws an exception if wrong enum type is passed in array', function () {
    $container = app()->make(BittyContainer::class)
        ->setClass(Good\Colour::class)
        ->set([
            Good\Colour::Red,
        ]);

    app()->make(BittyContainer::class)
        ->setClass(Good\Warning::class)
        ->set($container);          // wrong class, these are colours

})->throws(BittyEnumException::class);

/**
 * Setting from another BittyContainer
 */
it('can accept another BittyContainer', function () {
    $preferences = app()->make(BittyContainer::class)
        ->setClass(Good\Colour::class)
        ->set([
            Good\Colour::Red,       // 1
            Good\Colour::Green,     // 2
            Good\Colour::Blue,      // 4
        ]);

    $container = app()->make(BittyContainer::class)
        ->setClass(Good\Colour::class)
        ->set($preferences);

    expect($container->getValue())->toBe(7);
});

it('throws exception if wrong enum type is passed in BittyContainer', function () {
    $container = app()->make(BittyContainer::class)
        ->setClass(Good\Colour::class)
        ->set([
            Good\Colour::Red,
        ]);

    app()->make(BittyContainer::class)
        ->setClass(Good\Warning::class)
        ->set($container);          // wrong class, these are colours

})->throws(BittyEnumException::class);
