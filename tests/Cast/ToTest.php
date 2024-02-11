<?php

use Illuminate\Support\Facades\DB;
use MatthewPageUK\BittyEnums\Contracts\BittyContainer;
use MatthewPageUK\BittyEnums\Tests\Enums\Good;
use Tests\Models\Product;

/**
 * Model attribute cast to BittyContainer
 */
it('can cast to a model attribute', function () {

    $container = app()->make(BittyContainer::class)
        ->setClass(Good\Colour::class)
        ->set(Good\Colour::Pink);

    $product = Product::create([
        'name' => 'Pink Product',
        'colours' => $container,
        'price' => 400,
    ]);

    $value = DB::table('products')->where('id', $product->id)->first()?->colours;

    expect($value)->toBe(Good\Colour::Pink->value);
});
