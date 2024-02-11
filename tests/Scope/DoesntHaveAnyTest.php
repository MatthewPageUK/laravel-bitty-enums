<?php

use MatthewPageUK\BittyEnums\Contracts\BittyContainer;
use MatthewPageUK\BittyEnums\Exceptions\BittyEnumException;
use MatthewPageUK\BittyEnums\Tests\Enums\Good;
use Tests\Models\Product;

/**
 * DoesntHaveAny scope query tests
 */
it('can scope the whereBittyEnumDoesntHaveAny query', function () {
    $container = app()->make(BittyContainer::class)
        ->setClass(Good\Colour::class)
        ->set(Good\Colour::Red)
        ->set(Good\Colour::Blue);

    $query = Product::whereBittyEnumDoesntHaveAny('colours', $container);
    expect($query->get()->count())->toBe(1);
});

it('can accept an array of values', function () {
    $query = Product::whereBittyEnumDoesntHaveAny(
        'colours',
        [Good\Colour::Red, Good\Colour::Blue]
    );

    expect($query->get()->count())->toBe(1);
});

/**
 * Validation tests
 */
it('throws exception if targeting non cast attribute', function () {
    $query = Product::whereBittyEnumDoesntHaveAny('name', [Good\Colour::White]);
})->expectException(BittyEnumException::class);

it('throws exception if attribute is cast to a different class', function () {
    $query = Product::whereBittyEnumDoesntHaveAny('colours', [Good\Warning::LowFuel]);
})->expectException(BittyEnumException::class);
