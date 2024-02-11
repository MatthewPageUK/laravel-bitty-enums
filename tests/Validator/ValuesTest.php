<?php

use MatthewPageUK\BittyEnums\Exceptions\BittyEnumException;
use MatthewPageUK\BittyEnums\Support\Validator;
use MatthewPageUK\BittyEnums\Tests\Enums\Bad;

// Invalid / non power of two values
it('throws exception if enum contains non power of two values', function () {
    $validator = new Validator(Bad\BadValue::class);

})->throws(BittyEnumException::class);

// Doesn't start at one
it('throws exception if enum values do not start at one', function () {
    $validator = new Validator(Bad\DoesntStartAtOne::class);

})->throws(BittyEnumException::class);

// Out of order
it('throws exception if enum values are out of order', function () {
    $validator = new Validator(Bad\OutOfOrder::class);

})->throws(BittyEnumException::class);
