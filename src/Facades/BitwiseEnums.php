<?php

namespace MatthewPageUK\BitwiseEnums\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \MatthewPageUK\BitwiseEnums\BitwiseEnums
 */
class BitwiseEnums extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \MatthewPageUK\BitwiseEnums\BitwiseEnums::class;
    }
}
