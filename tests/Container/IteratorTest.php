<?php

use MatthewPageUK\BittyEnums\Contracts\BittyContainer;
use MatthewPageUK\BittyEnums\Tests\Enums\Good;

/**
 * Container iterator tests
 */
it('can be iterated over by a foreach', function () {
    $container = app()->make(BittyContainer::class)
        ->setClass(Good\Warning::class)
        ->set(Good\Warning::LowFuel)          // 1
        ->set(Good\Warning::CheckEngine);     // 2

    $choices = [];
    foreach ($container as $choice) {
        $choices[] = $choice;
    }

    expect($choices[1])->toBe(Good\Warning::CheckEngine);
});
