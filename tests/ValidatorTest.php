<?php

use MatthewPageUK\BittyEnums\Contracts\BittyValidator;
use MatthewPageUK\BittyEnums\Support\Validator;
use MatthewPageUK\BittyEnums\Tests\Enums\Bad;
use MatthewPageUK\BittyEnums\Tests\Enums\Good;

// Pass a good enum class
it('passes a good enum class', function () {
    $validator = new Validator(Good\Colour::class);

    expect($validator)->toBeInstanceOf(BittyValidator::class);
});

// Implement contract
it('throws exception if enum does not implement BittyEnum contract', function () {
    $validator = new Validator(Bad\NoInterface::class);

})->throws(\InvalidArgumentException::class);

// Invalid / non power of two values
it('throws exception if enum contains non power of two values', function () {
    $validator = new Validator(Bad\BadValue::class);

})->throws(\InvalidArgumentException::class);

// Too many cases
it('throws exception if enum has too many cases (16 bit)', function () {
    $validator = new Validator(Bad\TooManyCases::class);

})->throws(\InvalidArgumentException::class);

// No cases
it('throws exception if enum has no cases', function () {
    $validator = new Validator(Bad\NoCases::class);

})->throws(\InvalidArgumentException::class);

// Doesn't start at one
it('throws exception if enum values do not start at one', function () {
    $validator = new Validator(Bad\DoesntStartAtOne::class);

})->throws(\InvalidArgumentException::class);

// Out of order
it('throws exception if enum values are out of order', function () {
    $validator = new Validator(Bad\OutOfOrder::class);

})->throws(\InvalidArgumentException::class);

// Choice is different enum
it('throws exception if choice is a different enum', function () {
    $validator = new Validator(Good\Colour::class);
    $validator->validateChoice(Good\Warning::Brakes);

})->throws(\InvalidArgumentException::class);
