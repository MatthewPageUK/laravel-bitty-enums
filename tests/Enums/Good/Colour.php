<?php

namespace MatthewPageUK\BitwiseEnums\Tests\Enums\Good;

use MatthewPageUK\BitwiseEnums\Contracts\BitwiseEnum;

enum Colour: int implements BitwiseEnum
{
    case Red    = 1;
    case Green  = 2;
    case Blue   = 4;
    case White  = 8;
    case Black  = 16;
    case Pink   = 32;
}