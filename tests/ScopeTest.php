<?php

use MatthewPageUK\BittyEnums\Support\Container as BittyEnumContainer;
use MatthewPageUK\BittyEnums\Tests\Enums\Good\Colour;
use Tests\Models\Product;

it('can scope the query - whereBittyEnumHas', function () {
    $query = Product::whereBittyEnumHas('colours', Colour::Red);
    expect($query->get()->count())->toBe(2);

    $query = Product::whereBittyEnum('colours', Colour::White);
    expect($query->get()->count())->toBe(0);
});

it('can scope the query - whereBittyEnumHasAny', function () {
    $container = (new BittyEnumContainer(Colour::class))
        ->set(Colour::Red)
        ->set(Colour::Green);

    $query = Product::whereBittyEnumHasAny('colours', $container);

    expect($query->get()->count())->toBe(3);
});

it('can scope the query - whereBittyEnumHasAll', function () {
    $container = (new BittyEnumContainer(Colour::class))
        ->set(Colour::Red)
        ->set(Colour::Blue);

    $query = Product::whereBittyEnumHasAll('colours', $container);

    expect($query->get()->count())->toBe(1);
});

it('can scope the query - whereBittyEnumDoesntHave', function () {
    $query = Product::whereBittyEnumDoesntHave('colours', Colour::Red);
    expect($query->get()->count())->toBe(2);
});

it('can scope the query - whereBittyEnumDoesntHaveAny', function () {
    $container = (new BittyEnumContainer(Colour::class))
        ->set(Colour::Red)
        ->set(Colour::Blue);

    $query = Product::whereBittyEnumDoesntHaveAny('colours', $container);
    expect($query->get()->count())->toBe(1);
});
