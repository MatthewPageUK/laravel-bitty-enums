<?php

namespace Tests\Models;

use Illuminate\Database\Eloquent\Model;
use MatthewPageUK\BittyEnums\Casts\BittyEnumCast;
use MatthewPageUK\BittyEnums\Tests\Enums\Good\Colour;
use MatthewPageUK\BittyEnums\Traits\WithBittyEnumQueryScope;

/**
 * Test product model with bitty enum cast and query scopes.
 */
class Product extends Model
{
    use WithBittyEnumQueryScope;

    protected $fillable = ['name', 'colours', 'price'];

    protected $casts = [
        'colours' => BittyEnumCast::class.':'.Colour::class,
    ];
}
