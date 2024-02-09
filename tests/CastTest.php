<?php

use Illuminate\Support\Facades\DB;
use MatthewPageUK\BittyEnums\BittyEnumContainer;
use MatthewPageUK\BittyEnums\Tests\Enums\Good\Colour;
use Tests\Models\Product;

it('can cast from a model attribute', function () {
    $product = Product::find(1);

    expect($product->colours)->toBeInstanceOf(BittyEnumContainer::class);
    expect($product->colours->getValue())->toBe(Colour::Red->value);
});

it('can cast to a model attribute', function () {

    $container = (new BittyEnumContainer(Colour::class))->set(Colour::Pink);
    $product = Product::create([
        'name' => 'Pink Product',
        'colours' => $container,
        'price' => 400,
    ]);

    $value = DB::table('products')->where('id', $product->id)->first()?->colours;

    expect($value)->toBe(Colour::Pink->value);
});
