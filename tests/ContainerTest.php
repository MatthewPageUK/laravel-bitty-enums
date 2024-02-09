<?php

use MatthewPageUK\BittyEnums\BittyEnumContainer;
use MatthewPageUK\BittyEnums\Tests\Enums\Bad\BadValue;
use MatthewPageUK\BittyEnums\Tests\Enums\Bad\NoInterface;
use MatthewPageUK\BittyEnums\Tests\Enums\Bad\TooManyCases;
use MatthewPageUK\BittyEnums\Tests\Enums\Good\Warning;
use MatthewPageUK\BittyEnums\Tests\Enums\Good\Colour;

it('can create a new container', function () {
    $container = new BittyEnumContainer(Warning::class);

    expect($container)->toBeInstanceOf(BittyEnumContainer::class);
    expect($container->getValue())->toBe(0);
});

it('throws exception if creating a container with a non interfaced enum', function () {
    new BittyEnumContainer(NoInterface::class);
})->throws(\InvalidArgumentException::class);

it('throws exception if creating a container with an enum that has non power of 2 values', function () {
    new BittyEnumContainer(BadValue::class);
})->throws(\InvalidArgumentException::class);

it('throws exception if creating a container with an enum that has more than 16 cases [16 bit max]', function () {
    new BittyEnumContainer(TooManyCases::class);
})->throws(\InvalidArgumentException::class);

it('can set a value', function () {
    $container = (new BittyEnumContainer(Warning::class))
        ->set(Warning::LowFuel);       // 1

    expect($container->getValue())->toBe(1);
});

it('can set multiple values', function () {
    $container = (new BittyEnumContainer(Warning::class))
        ->set(Warning::LowFuel)          // 1
        ->set(Warning::CheckEngine);     // 2

    expect($container->getValue())->toBe(3);
});

it('can unset a value', function () {
    $container = (new BittyEnumContainer(Warning::class))
        ->set(Warning::LowFuel)          // 1
        ->set(Warning::CheckEngine)      // 2
        ->unset(Warning::LowFuel);       // -1

    expect($container->getValue())->toBe(2);
});

it('can check if a value is set', function () {
    $container = (new BittyEnumContainer(Warning::class))
        ->set(Warning::LowFuel)          // 1
        ->set(Warning::CheckEngine);     // 2

    expect($container->has(Warning::LowFuel))->toBeTrue();
    expect($container->has(Warning::CheckEngine))->toBeTrue();
    expect($container->has(Warning::TyrePressure))->toBeFalse();
    expect($container->has(Warning::Brakes))->toBeFalse();
});

it('returns an array of enums from getChoices()', function () {
    $container = (new BittyEnumContainer(Warning::class))
        ->set(Warning::LowFuel)          // 1
        ->set(Warning::CheckEngine)      // 2
        ->set(Warning::TyrePressure);    // 4

    expect($container->getChoices())->toBe([
        Warning::LowFuel,
        Warning::CheckEngine,
        Warning::TyrePressure,
    ]);
});

it('throws exception if wrong enum class is used in set()', function () {
    $container = (new BittyEnumContainer(Warning::class))
        ->set(Warning::CheckEngine)      // 2
        ->set(Warning::TyrePressure)     // 4
        ->set(Warning::Brakes)           // 8
        ->set(Colour::Red);              // 1 - but wrong class

})->throws(\InvalidArgumentException::class);

it('can clear the values', function () {
    $container = (new BittyEnumContainer(Warning::class))
        ->set(Warning::LowFuel)          // 1
        ->set(Warning::CheckEngine)      // 2
        ->clear();

    expect($container->getValue())->toBe(0);
});

it('can set all values', function () {
    $total = array_reduce(Warning::cases(), fn($carry, $item) => $carry + $item->value, 0);
    $container = (new BittyEnumContainer(Warning::class))
        ->setAll();

    expect($container->getValue())->toBe($total);
});
