<?php

use MatthewPageUK\BittyEnums\Contracts\BittyContainer;
use MatthewPageUK\BittyEnums\Tests\Enums\Good;

/**
 * Get the selected choices from the container
 */
it('returns an array of enums from getChoices()', function () {
    $container = app()->make(BittyContainer::class)
        ->setClass(Good\Warning::class)
        ->set(Good\Warning::LowFuel)          // 1
        ->set(Good\Warning::CheckEngine)      // 2
        ->set(Good\Warning::TyrePressure);    // 4

    expect($container->getChoices())->toBe([
        Good\Warning::LowFuel,
        Good\Warning::CheckEngine,
        Good\Warning::TyrePressure,
    ]);
});
