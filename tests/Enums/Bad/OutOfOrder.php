<?php

namespace MatthewPageUK\BittyEnums\Tests\Enums\Bad;

use MatthewPageUK\BittyEnums\Contracts\BittyEnum;

enum OutOfOrder: int implements BittyEnum
{
    case Red = 1;
    case Green = 4;     // <- Wrong order
    case Blue = 2;      // <- Wrong order
    case White = 8;
    case Black = 16;
}
