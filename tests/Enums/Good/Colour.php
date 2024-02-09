<?php

namespace MatthewPageUK\BittyEnums\Tests\Enums\Good;

use MatthewPageUK\BittyEnums\Contracts\BittyEnum;

enum Colour: int implements BittyEnum
{
    case Red    = 1;
    case Green  = 2;
    case Blue   = 4;
    case White  = 8;
    case Black  = 16;
    case Pink   = 32;
}