<?php

namespace MatthewPageUK\BittyEnums;

use Illuminate\Support\ServiceProvider;
use MatthewPageUK\BittyEnums\Commands\MakeBittyEnum;

class BittyEnumsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/bitty-enums.php', 'bitty-enums');

        $this->app->bind(Contracts\BittyContainer::class, Support\Container::class);
        $this->app->bind(Contracts\BittyValidator::class, Support\Validator::class);
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeBittyEnum::class,
            ]);
        }
    }
}
