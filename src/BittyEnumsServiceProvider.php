<?php

namespace MatthewPageUK\BittyEnums;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use MatthewPageUK\BittyEnums\Commands\BittyEnumsCommand;

class BittyEnumsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-bitty-enums')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-bitty-enums_table')
            ->hasCommand(BittyEnumsCommand::class);
    }
}
