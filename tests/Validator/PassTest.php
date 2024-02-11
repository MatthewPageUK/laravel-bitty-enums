<?php

use MatthewPageUK\BittyEnums\Contracts\BittyValidator;
use MatthewPageUK\BittyEnums\Support\Validator;
use MatthewPageUK\BittyEnums\Tests\Enums\Good;

// Pass a good enum class
it('passes a good enum class', function () {
    $validator = new Validator(Good\Colour::class);

    expect($validator)->toBeInstanceOf(BittyValidator::class);
});
