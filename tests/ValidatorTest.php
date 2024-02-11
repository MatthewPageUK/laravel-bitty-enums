<?php

use Illuminate\Support\Facades\Validator as CoreValidator;
use MatthewPageUK\BittyEnums\Contracts\BittyValidator;
use MatthewPageUK\BittyEnums\Exceptions\BittyEnumException;
use MatthewPageUK\BittyEnums\Rules;
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

})->throws(BittyEnumException::class);

// Invalid / non power of two values
it('throws exception if enum contains non power of two values', function () {
    $validator = new Validator(Bad\BadValue::class);

})->throws(BittyEnumException::class);

// Too many cases
it('throws exception if enum has too many cases (16 bit)', function () {
    $validator = new Validator(Bad\TooManyCases::class);

})->throws(BittyEnumException::class);

// No cases
it('throws exception if enum has no cases', function () {
    $validator = new Validator(Bad\NoCases::class);

})->throws(BittyEnumException::class);

// Doesn't start at one
it('throws exception if enum values do not start at one', function () {
    $validator = new Validator(Bad\DoesntStartAtOne::class);

})->throws(BittyEnumException::class);

// Out of order
it('throws exception if enum values are out of order', function () {
    $validator = new Validator(Bad\OutOfOrder::class);

})->throws(BittyEnumException::class);

// Choice is different enum to the container
it('throws exception if choice is a different enum', function () {
    $validator = new Validator(Good\Colour::class);
    $validator->validateChoice(Good\Warning::Brakes);

})->throws(BittyEnumException::class);

// Case name validation
it('validates case name', function () {

    expect(CoreValidator::make(
        ['name' => 'bad name'],
        ['name' => new Rules\CaseName],
    )->passes())->toBe(false);

    expect(CoreValidator::make(
        ['name' => '1bad'],
        ['name' => new Rules\CaseName],
    )->passes())->toBe(false);

    expect(CoreValidator::make(
        ['name' => '-bad'],
        ['name' => new Rules\CaseName],
    )->passes())->toBe(false);

    expect(CoreValidator::make(
        ['name' => 'GoodName'],
        ['name' => new Rules\CaseName],
    )->passes())->toBe(true);

});
