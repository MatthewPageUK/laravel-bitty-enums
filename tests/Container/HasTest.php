<?php

use MatthewPageUK\BittyEnums\Contracts\BittyContainer;
use MatthewPageUK\BittyEnums\Tests\Enums\Good;

/**
 * Checking a single value
 */
it('can check if the container has a value', function () {
    $container = app()->make(BittyContainer::class)
        ->setClass(Good\Warning::class)
        ->set(Good\Warning::LowFuel)          // 1
        ->set(Good\Warning::CheckEngine);     // 2

    expect($container->has(Good\Warning::LowFuel))->toBeTrue();
    expect($container->has(Good\Warning::CheckEngine))->toBeTrue();
    expect($container->has(Good\Warning::TyrePressure))->toBeFalse();
    expect($container->has(Good\Warning::Brakes))->toBeFalse();
});

/**
 * Checking multiple values - any
 */
it('can check if the container has any of the values', function () {
    $empty = app()->make(BittyContainer::class)
        ->setClass(Good\Warning::class);

    $emergencies = app()->make(BittyContainer::class)
        ->setClass(Good\Warning::class)
        ->set(Good\Warning::Brakes)           // 8
        ->set(Good\Warning::TyrePressure);    // 4

    $notifications = app()->make(BittyContainer::class)
        ->setClass(Good\Warning::class)
        ->set(Good\Warning::LowFuel)          // 1
        ->set(Good\Warning::CheckEngine);     // 2

    $container = app()->make(BittyContainer::class)
        ->setClass(Good\Warning::class)
        ->set(Good\Warning::LowFuel)          // 1
        ->set(Good\Warning::CheckEngine);     // 2

    expect($container->hasAny([Good\Warning::LowFuel, Good\Warning::CheckEngine]))->toBeTrue();
    expect($container->hasAny([Good\Warning::CheckEngine, Good\Warning::TyrePressure]))->toBeTrue();
    expect($container->hasAny($emergencies))->toBeFalse();
    expect($container->hasAny($notifications))->toBeTrue();
    expect($container->hasAny([]))->toBeFalse();
    expect($container->hasAny($empty))->toBeFalse();
});

/**
 * Checking all values
 */
it('can check if the container has all the values', function () {
    $empty = app()->make(BittyContainer::class)
        ->setClass(Good\Warning::class);

    $emergencies = app()->make(BittyContainer::class)
        ->setClass(Good\Warning::class)
        ->set(Good\Warning::Brakes)           // 8
        ->set(Good\Warning::TyrePressure);    // 4

    $notifications = app()->make(BittyContainer::class)
        ->setClass(Good\Warning::class)
        ->set(Good\Warning::LowFuel)          // 1
        ->set(Good\Warning::CheckEngine);     // 2

    $container = app()->make(BittyContainer::class)
        ->setClass(Good\Warning::class)
        ->set(Good\Warning::LowFuel)          // 1
        ->set(Good\Warning::CheckEngine);     // 2

    expect($container->hasAll([Good\Warning::LowFuel, Good\Warning::CheckEngine]))->toBeTrue();
    expect($container->hasAll([Good\Warning::CheckEngine, Good\Warning::TyrePressure]))->toBeFalse();
    expect($container->hasAll($emergencies))->toBeFalse();
    expect($container->hasAll($notifications))->toBeTrue();
    expect($container->hasAll([]))->toBeFalse();
    expect($container->hasAll($empty))->toBeFalse();
});
