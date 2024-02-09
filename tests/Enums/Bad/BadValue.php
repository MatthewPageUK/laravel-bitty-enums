<?php

namespace MatthewPageUK\BittyEnums\Tests\Enums\Bad;

use MatthewPageUK\BittyEnums\Contracts\BittyEnum;

enum BadValue: int implements BittyEnum
{
    case Red = 1;
    case Green = 2;
    case Blue = 4;
    case White = 8;
    case Black = 17;   // <-- Wrong value, not a power of two
}
