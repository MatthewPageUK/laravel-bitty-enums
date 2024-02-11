<?php

namespace MatthewPageUK\BittyEnums\Support;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator as CoreValidator;
use MatthewPageUK\BittyEnums\Contracts\BittyEnum;
use MatthewPageUK\BittyEnums\Contracts\BittyValidator;
use MatthewPageUK\BittyEnums\Exceptions\InvalidCaseException;
use MatthewPageUK\BittyEnums\Exceptions\InvalidClassException;
use MatthewPageUK\BittyEnums\Exceptions\InvalidQueryException;
use MatthewPageUK\BittyEnums\Exceptions\InvalidValueException;
use MatthewPageUK\BittyEnums\Rules;

class Validator implements BittyValidator
{
    public function __construct(
        protected ?string $class = null
    ) {
        if ($class) {
            $this->validateClass($class)
                ->validateCases($class)
                ->validateValues($class);
        }
    }

    // set class

    public function validateClass(string $class): BittyValidator
    {
        $validator = CoreValidator::make(
            ['class' => $class],
            ['class' => new Rules\ClassType],
        );

        if ($validator->fails()) {
            throw new InvalidClassException($validator->getMessageBag()->first());
        }

        return $this;
    }

    public function validateCases(string $class): BittyValidator
    {
        $validator = CoreValidator::make(
            ['class' => $class],
            ['class' => [
                new Rules\NoCases,
                new Rules\MaxCases,
            ]]);

        if ($validator->fails()) {
            throw new InvalidCaseException($validator->getMessageBag()->first());
        }

        return $this;
    }

    public function validateValues(string $class): BittyValidator
    {
        $validator = CoreValidator::make(
            ['class' => $class],
            ['class' => [
                new Rules\PowerOfTwo,
                new Rules\InOrder,
                new Rules\StartAtOne,
            ]]);

        if ($validator->fails()) {
            throw new InvalidValueException($validator->getMessageBag()->first());
        }

        return $this;
    }

    public function validateChoice(BittyEnum $choice, ?string $class = null): BittyValidator
    {
        $validator = CoreValidator::make(
            ['choice' => $choice],
            ['choice' => new Rules\MatchClass($class ?? $this->class)]
        );

        if ($validator->fails()) {
            throw new InvalidClassException($validator->getMessageBag()->first());
        }

        return $this;
    }

    public function validateQuery(Builder $query, string $column, BittyEnum $choice): BittyValidator
    {
        $validator = CoreValidator::make(
            [
                'query' => $query,
                'choice' => $choice,
            ], [
                'query' => [
                    new Rules\ModelHasColumn($column),
                    new Rules\ColumnHasCast($column),
                ],
                'choice' => new Rules\MatchCastClass($query, $column),
            ]
        );

        if ($validator->fails()) {
            throw new InvalidQueryException($validator->getMessageBag()->first());
        }

        return $this;
    }
}
