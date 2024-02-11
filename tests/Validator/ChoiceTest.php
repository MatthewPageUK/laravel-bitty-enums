<?php

use MatthewPageUK\BittyEnums\Exceptions\BittyEnumException;
use MatthewPageUK\BittyEnums\Support\Validator;
use MatthewPageUK\BittyEnums\Tests\Enums\Good;

// Choice is different enum to the container
it('throws exception if choice is a different enum', function () {
    $validator = new Validator(Good\Colour::class);
    $validator->validateChoice(Good\Warning::Brakes);

})->throws(BittyEnumException::class);
