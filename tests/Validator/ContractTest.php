<?php

use MatthewPageUK\BittyEnums\Exceptions\BittyEnumException;
use MatthewPageUK\BittyEnums\Support\Validator;
use MatthewPageUK\BittyEnums\Tests\Enums\Bad;

// Implement contract
it('throws exception if enum does not implement BittyEnum contract', function () {
    $validator = new Validator(Bad\NoInterface::class);

})->throws(BittyEnumException::class);
