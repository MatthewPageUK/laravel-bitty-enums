<?php

namespace MatthewPageUK\BittyEnums\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use MatthewPageUK\BittyEnums\Contracts\BittyContainer;

/**
 * Model Cast for Bitty Enums
 *
 * Casts the integer column to a BittyContainer and vice versa
 */
class BittyEnumCast implements CastsAttributes
{
    public function __construct(
        protected string $enumClass
    ) {
    }

    public function get(Model $model, string $key, $value, array $attributes)
    {
        return app()->makeWith(BittyContainer::class, [
            'class' => $this->enumClass,
            'selected' => $value,
        ]);
    }

    public function set(Model $model, string $key, $value, array $attributes)
    {
        if ($value instanceof BittyContainer) {
            return $value->getValue();
        }

        return $value;
    }
}
