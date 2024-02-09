<?php

namespace Tests\Models;

use Illuminate\Database\Eloquent\Model;
use MatthewPageUK\BitwiseEnums\Casts\BitwiseEnumCast;
use MatthewPageUK\BitwiseEnums\Tests\Enums\Good\Colour;
use MatthewPageUK\BitwiseEnums\Traits\WithBitwiseEnumQueryScope;

/**
 * Test product model with bitwise enum cast and query scopes.
 *
 */
class Product extends Model
{
    use WithBitwiseEnumQueryScope;

    protected $fillable = ['name', 'colours', 'price'];

    protected $casts = [
        'colours' => BitwiseEnumCast::class . ':' . Colour::class,
    ];
}
