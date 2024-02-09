<?php

namespace MatthewPageUK\BitwiseEnums\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use MatthewPageUK\BitwiseEnums\BitwiseEnumContainer;

class BitwiseEnumCast implements CastsAttributes
{
    public function __construct(
        protected string $enumClass
    ) { }

    public function get(Model $model, string $key, $value, array $attributes)
    {
        return new BitwiseEnumContainer($this->enumClass, $value);
    }

    public function set(Model $model, string $key, $value, array $attributes)
    {
        if ($value instanceof BitwiseEnumContainer) {
            return $value->getValue();
        }

        return $value;
    }
}