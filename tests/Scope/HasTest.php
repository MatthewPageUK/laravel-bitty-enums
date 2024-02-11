<?php

use MatthewPageUK\BittyEnums\Exceptions\BittyEnumException;
use MatthewPageUK\BittyEnums\Tests\Enums\Good;
use Tests\Models\Product;

/**
 * Has scope query tests
 */
it('can scope the whereBittyEnumHas query', function () {
    $query = Product::whereBittyEnumHas('colours', Good\Colour::Red);
    expect($query->get()->count())->toBe(2);

    $query = Product::whereBittyEnumHas('colours', Good\Colour::White);
    expect($query->get()->count())->toBe(0);
});

/**
 * Validation tests
 */
it('throws exception if targeting non cast attribute', function () {
    $query = Product::whereBittyEnumHas('name', Good\Colour::White);
})->expectException(BittyEnumException::class);

it('throws exception if attribute is cast to a different class', function () {
    $query = Product::whereBittyEnumHas('colours', Good\Warning::LowFuel);
})->expectException(BittyEnumException::class);
