<?php

use MatthewPageUK\BittyEnums\BittyEnumContainer;
use MatthewPageUK\BittyEnums\Tests\Enums\Good\Colour;
use Tests\Models\Product;

it('can scope the query - has', function () {
    $query = Product::whereBittyEnumHas('colours', Colour::Red);
    expect($query->get()->count())->toBe(2);

    $query = Product::whereBittyEnum('colours', Colour::White);
    expect($query->get()->count())->toBe(0);
});

it('can scope the query - has any', function () {
    $container = (new BittyEnumContainer(Colour::class))
        ->set(Colour::Red)
        ->set(Colour::Green);

    $query = Product::whereBittyEnumHasAny('colours', $container);

    expect($query->get()->count())->toBe(3);
});

it('can scope the query - has all', function () {
    $container = (new BittyEnumContainer(Colour::class))
        ->set(Colour::Red)
        ->set(Colour::Blue);

    $query = Product::whereBittyEnumHasAll('colours', $container);

    expect($query->get()->count())->toBe(1);
});
