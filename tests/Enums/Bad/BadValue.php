<?php

namespace MatthewPageUK\BitwiseEnums\Tests\Enums\Bad;

use MatthewPageUK\BitwiseEnums\Contracts\BitwiseEnum;

enum BadValue: int implements BitwiseEnum
{
    case Red    = 1;
    case Green  = 2;
    case Blue   = 4;
    case White  = 8;
    case Black  = 17;   // <-- Wrong value, not a power of two
}