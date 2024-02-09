<?php

namespace MatthewPageUK\BittyEnums\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \MatthewPageUK\BittyEnums\BittyEnums
 */
class BittyEnums extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \MatthewPageUK\BittyEnums\BittyEnums::class;
    }
}
