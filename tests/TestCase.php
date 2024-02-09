<?php

namespace MatthewPageUK\BittyEnums\Tests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use MatthewPageUK\BittyEnums\BittyEnumsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Tests\Models\Product;

class TestCase extends Orchestra
{
    // https://github.com/staudenmeir/eloquent-has-many-deep/blob/master/tests/TestCase.php
    protected string $database;

    protected function setUp(): void
    {
        // https://github.com/staudenmeir/eloquent-has-many-deep/blob/master/tests/TestCase.php
        $this->database = getenv('DB_CONNECTION') ?: 'sqlite';

        parent::setUp();

        $this->migrateDatabase();
        $this->seedDatabase();

        // Factory::guessFactoryNamesUsing(
        //     fn (string $modelName) => 'MatthewPageUK\\BittyEnums\\Database\\Factories\\'.class_basename($modelName).'Factory'
        // );
    }

    protected function migrateDatabase(): void
    {
        Schema::dropAllTables();

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('colours');
            $table->unsignedInteger('price');
            $table->timestamps();
        });
    }

    protected function seedDatabase(): void
    {
        Model::unguard();

        Product::create(['id' => 1, 'name' => 'Red Product', 'colours' => 1, 'price' => 100]);
        Product::create(['id' => 2, 'name' => 'Green Product', 'colours' => 2, 'price' => 200]);
        Product::create(['id' => 3, 'name' => 'Blue Product', 'colours' => 4, 'price' => 300]);
        Product::create(['id' => 4, 'name' => 'Red and Blue Product', 'colours' => 5, 'price' => 1000]);
    }

    protected function getPackageProviders($app)
    {
        return [
            BittyEnumsServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-bitty-enums_table.php.stub';
        $migration->up();
        */
    }
}
