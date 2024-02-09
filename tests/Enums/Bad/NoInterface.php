<?php

namespace MatthewPageUK\BittyEnums\Tests\Enums\Bad;

enum NoInterface: int   // <-- missing interface
{
    case Red = 1;
    case Green = 2;
    case Blue = 4;
    case White = 8;
    case Black = 16;
}
