<?php

use MatthewPageUK\BittyEnums\Support;
use MatthewPageUK\BittyEnums\Tests\Enums\Good;

// Get choices
it('returns an array of enums from getChoices()', function () {
    $container = (new Support\Container(Good\Warning::class))
        ->set(Good\Warning::LowFuel)          // 1
        ->set(Good\Warning::CheckEngine)      // 2
        ->set(Good\Warning::TyrePressure);    // 4

    expect($container->getChoices())->toBe([
        Good\Warning::LowFuel,
        Good\Warning::CheckEngine,
        Good\Warning::TyrePressure,
    ]);
});

// Clear values
it('can clear the values', function () {
    $container = (new Support\Container(Good\Warning::class))
        ->set(Good\Warning::LowFuel)          // 1
        ->set(Good\Warning::CheckEngine)      // 2
        ->clear();

    expect($container->getValue())->toBe(0);
});

// Set all values from the enum
it('can set all values', function () {
    $total = array_reduce(Good\Warning::cases(), fn ($carry, $item) => $carry + $item->value, 0);
    $container = (new Support\Container(Good\Warning::class))
        ->setAll();

    expect($container->getValue())->toBe($total);
});
