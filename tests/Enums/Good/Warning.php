<?php

namespace MatthewPageUK\BitwiseEnums\Tests\Enums\Good;

use MatthewPageUK\BitwiseEnums\Contracts\BitwiseEnum;

enum Warning: int implements BitwiseEnum
{
    case LowFuel        = 1;
    case CheckEngine    = 2;
    case TyrePressure   = 4;
    case Brakes         = 8;
}