<?php

use MatthewPageUK\BittyEnums\Exceptions\BittyEnumException;
use MatthewPageUK\BittyEnums\Tests\Enums\Good;
use Tests\Models\Product;

/**
 * DoesntHave scope query tests
 */
it('can scope the whereBittyEnumDoesntHave query', function () {
    $query = Product::whereBittyEnumDoesntHave('colours', Good\Colour::Red);
    expect($query->get()->count())->toBe(2);
});

/**
 * Validation tests
 */
it('throws exception if targeting non cast attribute', function () {
    $query = Product::whereBittyEnumDoesntHave('name', Good\Colour::White);
})->expectException(BittyEnumException::class);

it('throws exception if attribute is cast to a different class', function () {
    $query = Product::whereBittyEnumDoesntHave('colours', Good\Warning::LowFuel);
})->expectException(BittyEnumException::class);
