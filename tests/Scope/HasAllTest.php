<?php

use MatthewPageUK\BittyEnums\Contracts\BittyContainer;
use MatthewPageUK\BittyEnums\Exceptions\BittyEnumException;
use MatthewPageUK\BittyEnums\Tests\Enums\Good;
use Tests\Models\Product;

/**
 * HasAll scope query tests
 */
it('can scope the whereBittyEnumHasAll query', function () {
    $container = app()->make(BittyContainer::class)
        ->setClass(Good\Colour::class)
        ->set(Good\Colour::Red)
        ->set(Good\Colour::Blue);

    $query = Product::whereBittyEnumHasAll('colours', $container);

    expect($query->get()->count())->toBe(1);
});

it('can accept an array of values', function () {
    $query = Product::whereBittyEnumHasAll(
        'colours',
        [Good\Colour::Red, Good\Colour::Blue]
    );

    expect($query->get()->count())->toBe(1);
});

/**
 * Validation tests
 */
it('throws exception if targeting non cast attribute', function () {
    $query = Product::whereBittyEnumHasAll('name', [Good\Colour::White]);
})->expectException(BittyEnumException::class);

it('throws exception if attribute is cast to a different class', function () {
    $query = Product::whereBittyEnumHasAll('colours', [Good\Warning::LowFuel]);
})->expectException(BittyEnumException::class);
