<?php

use MatthewPageUK\BittyEnums\Contracts\BittyContainer;
use MatthewPageUK\BittyEnums\Exceptions\BittyEnumException;
use MatthewPageUK\BittyEnums\Tests\Enums\Good;
use Tests\Models\Product;

/**
 * HasAny scope query tests
 */
it('can scope the whereBittyEnumHasAny query', function () {
    $container = app()->make(BittyContainer::class)
        ->setClass(Good\Colour::class)
        ->set([Good\Colour::Red, Good\Colour::Green]);

    $query = Product::whereBittyEnumHasAny('colours', $container);

    expect($query->get()->count())->toBe(3);
});

it('returns none if no values passed', function () {
    $container = app()->make(BittyContainer::class)
        ->setClass(Good\Colour::class);

    $query = Product::whereBittyEnumHasAny('colours', $container);

    expect($query->get()->count())->toBe(0);
});

it('can accept an array of values', function () {
    $query = Product::whereBittyEnumHasAny(
        'colours',
        [Good\Colour::Red, Good\Colour::Green]
    );

    expect($query->get()->count())->toBe(3);
});

/**
 * Validation tests
 */
it('throws exception if targeting non cast attribute', function () {
    $query = Product::whereBittyEnumHasAny('name', [Good\Colour::White]);
})->expectException(BittyEnumException::class);

it('throws exception if attribute is cast to a different class', function () {
    $query = Product::whereBittyEnumHasAny('colours', [Good\Warning::LowFuel]);
})->expectException(BittyEnumException::class);
