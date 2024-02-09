<?php

use MatthewPageUK\BitwiseEnums\BitwiseEnumContainer;
use MatthewPageUK\BitwiseEnums\Tests\Enums\Good\Colour;
use Tests\Models\Product;

it('can scope the query - has', function () {
    $query = Product::whereBitwiseEnumHas('colours', Colour::Red);
    expect($query->get()->count())->toBe(2);

    $query = Product::whereBitwiseEnum('colours', Colour::White);
    expect($query->get()->count())->toBe(0);
});

it('can scope the query - has any', function () {
    $container = (new BitwiseEnumContainer(Colour::class))
        ->set(Colour::Red)
        ->set(Colour::Green);

    $query = Product::whereBitwiseEnumHasAny('colours', $container);

    expect($query->get()->count())->toBe(3);
});

it('can scope the query - has all', function () {
    $container = (new BitwiseEnumContainer(Colour::class))
        ->set(Colour::Red)
        ->set(Colour::Blue);

    $query = Product::whereBitwiseEnumHasAll('colours', $container);

    expect($query->get()->count())->toBe(1);
});
