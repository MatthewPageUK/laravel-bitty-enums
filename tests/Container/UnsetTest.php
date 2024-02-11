<?php

use MatthewPageUK\BittyEnums\Contracts\BittyContainer;
use MatthewPageUK\BittyEnums\Exceptions\BittyEnumException;
use MatthewPageUK\BittyEnums\Tests\Enums\Good;

/**
 * Unsetting single values
 */
it('can unset a value', function () {
    $container = app()->make(BittyContainer::class)
        ->setClass(Good\Warning::class)
        ->set(Good\Warning::LowFuel)          // 1
        ->set(Good\Warning::CheckEngine)      // 2
        ->unset(Good\Warning::LowFuel);       // -1

    expect($container->getValue())->toBe(2);
});

it('throws exception if wrong enum type is unset', function () {
    $container = app()->make(BittyContainer::class)
        ->setClass(Good\Warning::class)
        ->set(Good\Warning::CheckEngine)
        ->unset(Good\Colour::Red);              // wrong class

})->throws(BittyEnumException::class);

/**
 * Unsetting from an array of Enums
 */
it('can accept an array of enums', function () {
    $container = app()->make(BittyContainer::class)
        ->setClass(Good\Warning::class)
        ->set([
            Good\Warning::LowFuel,              // 1
            Good\Warning::CheckEngine,          // 2
            Good\Warning::TyrePressure,         // 4
        ])
        ->unset([
            Good\Warning::LowFuel,              // 1
            Good\Warning::CheckEngine,          // 2
        ]);

    expect($container->getValue())->toBe(4);
});

it('throws an exception if wrong enum type is passed in array', function () {
    $container = app()->make(BittyContainer::class)
        ->setClass(Good\Warning::class)
        ->set([
            Good\Warning::LowFuel,              // 1
        ])
        ->unset([
            Good\Warning::CheckEngine,          // 2
            Good\Colour::Red,                   // wrong class
        ]);

})->throws(BittyEnumException::class);

/**
 * Unsetting from another BitContainer
 */
it('can accept another BittyContainer', function () {
    $dislikes = app()->make(BittyContainer::class)
        ->setClass(Good\Colour::class)
        ->set([
            Good\Colour::Red,       // 1
            Good\Colour::Green,     // 2
        ]);

    $container = app()->make(BittyContainer::class)
        ->setClass(Good\Colour::class)
        ->set([
            Good\Colour::Red,       // 1
            Good\Colour::Green,     // 2
            Good\Colour::Blue,      // 4
        ])
        ->unset($dislikes);

    expect($container->getValue())->toBe(4);
});

it('throws exception if wrong enum type is passed in BittyContainer', function () {
    $container = app()->make(BittyContainer::class)
        ->setClass(Good\Colour::class)
        ->set([
            Good\Colour::Red,
        ]);

    app()->make(BittyContainer::class)
        ->setClass(Good\Warning::class)
        ->unset($container);          // wrong class, these are colours

})->throws(BittyEnumException::class);
