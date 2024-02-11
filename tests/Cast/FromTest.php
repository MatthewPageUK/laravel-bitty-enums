<?php

use MatthewPageUK\BittyEnums\Contracts\BittyContainer;
use MatthewPageUK\BittyEnums\Tests\Enums\Good;
use Tests\Models\Product;

/**
 * Model attribute cast from BittyContainer
 */
it('can cast from a model attribute', function () {
    $product = Product::find(1);

    expect($product->colours)->toBeInstanceOf(BittyContainer::class);
    expect($product->colours->getValue())->toBe(Good\Colour::Red->value);
});
