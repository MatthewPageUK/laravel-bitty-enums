<?php

namespace MatthewPageUK\BittyEnums\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use MatthewPageUK\BittyEnums\BittyEnumContainer;

class BittyEnumCast implements CastsAttributes
{
    public function __construct(
        protected string $enumClass
    ) { }

    public function get(Model $model, string $key, $value, array $attributes)
    {
        return new BittyEnumContainer($this->enumClass, $value);
    }

    public function set(Model $model, string $key, $value, array $attributes)
    {
        if ($value instanceof BittyEnumContainer) {
            return $value->getValue();
        }

        return $value;
    }
}