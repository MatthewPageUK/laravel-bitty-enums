<?php

namespace MatthewPageUK\BitwiseEnums\Tests\Enums\Bad;

use MatthewPageUK\BitwiseEnums\Contracts\BitwiseEnum;

enum TooManyCases: int implements BitwiseEnum
{
    case Case1   = 1;
    case Case2   = 2;
    case Case3   = 4;
    case Case4   = 8;
    case Case5   = 16;
    case Case6   = 32;
    case Case7   = 64;
    case Case8   = 128;
    case Case9   = 256;
    case Case10  = 512;
    case Case11  = 1024;
    case Case12  = 2048;
    case Case13  = 4096;
    case Case14  = 8192;
    case Case15  = 16384;
    case Case16  = 32768;
    case Case17  = 65536;
}