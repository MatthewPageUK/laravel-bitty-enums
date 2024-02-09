<?php

use Illuminate\Support\Facades\DB;
use MatthewPageUK\BitwiseEnums\BitwiseEnumContainer;
use MatthewPageUK\BitwiseEnums\Tests\Enums\Good\Colour;
use Tests\Models\Product;

it('can cast from a model attribute', function () {
    $product = Product::find(1);

    expect($product->colours)->toBeInstanceOf(BitwiseEnumContainer::class);
    expect($product->colours->getValue())->toBe(Colour::Red->value);
});

it('can cast to a model attribute', function () {

    $container = (new BitwiseEnumContainer(Colour::class))->set(Colour::Pink);
    $product = Product::create([
        'name' => 'Pink Product',
        'colours' => $container,
        'price' => 400,
    ]);

    $value = DB::table('products')->where('id', $product->id)->first()?->colours;

    expect($value)->toBe(Colour::Pink->value);
});
