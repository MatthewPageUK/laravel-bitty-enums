<?php

namespace MatthewPageUK\BittyEnums\Tests\Enums\Bad;

use MatthewPageUK\BittyEnums\Contracts\BittyEnum;

enum DoesntStartAtOne: int implements BittyEnum
{
    case Green = 2;     // <- This should be 1
    case Blue = 4;
    case White = 8;
}
