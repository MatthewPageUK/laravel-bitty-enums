<?php

namespace MatthewPageUK\BittyEnums;

use Illuminate\Support\ServiceProvider;
use MatthewPageUK\BittyEnums\Commands\BittyEnumsCommand;
use MatthewPageUK\BittyEnums\Contracts;
use MatthewPageUK\BittyEnums\Support;

class BittyEnumsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(Contracts\BittyContainer::class, Support\Container::class);
    }


    // public function configurePackage(Package $package): void
    // {
    //     /*
    //      * This class is a Package Service Provider
    //      *
    //      * More info: https://github.com/spatie/laravel-package-tools
    //      */
    //     $package
    //         ->name('laravel-bitty-enums')
    //         ->hasConfigFile()
    //         ->hasViews()
    //         ->hasMigration('create_laravel-bitty-enums_table')
    //         ->hasCommand(BittyEnumsCommand::class);
    // }
}
