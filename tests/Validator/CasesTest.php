<?php

use Illuminate\Support\Facades\Validator as CoreValidator;
use MatthewPageUK\BittyEnums\Exceptions\BittyEnumException;
use MatthewPageUK\BittyEnums\Rules;
use MatthewPageUK\BittyEnums\Support\Validator;
use MatthewPageUK\BittyEnums\Tests\Enums\Bad;

// Too many cases
it('throws exception if enum has too many cases (16 bit)', function () {
    $validator = new Validator(Bad\TooManyCases::class);

})->throws(BittyEnumException::class);

// No cases
it('throws exception if enum has no cases', function () {
    $validator = new Validator(Bad\NoCases::class);

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
