<?php

namespace MatthewPageUK\BitwiseEnums;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use MatthewPageUK\BitwiseEnums\Commands\BitwiseEnumsCommand;

class BitwiseEnumsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-bitwise-enums')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-bitwise-enums_table')
            ->hasCommand(BitwiseEnumsCommand::class);
    }
}
