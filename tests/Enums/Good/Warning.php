<?php

namespace MatthewPageUK\BittyEnums\Tests\Enums\Good;

use MatthewPageUK\BittyEnums\Contracts\BittyEnum;

enum Warning: int implements BittyEnum
{
    case LowFuel = 1;
    case CheckEngine = 2;
    case TyrePressure = 4;
    case Brakes = 8;
}
