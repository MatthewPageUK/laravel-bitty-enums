# Laravel Bitwise Enums

[![Latest Version on Packagist](https://img.shields.io/packagist/v/matthewpageuk/laravel-bitty-enums.svg?style=for-the-badge)](https://packagist.org/packages/matthewpageuk/laravel-bitty-enums)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/matthewpageuk/laravel-bitty-enums/run-tests.yml?branch=main&label=tests&style=for-the-badge)](https://github.com/matthewpageuk/laravel-bitty-enums/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/matthewpageuk/laravel-bitty-enums/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=for-the-badge)](https://github.com/matthewpageuk/laravel-bitty-enums/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/matthewpageuk/laravel-bitty-enums.svg?style=for-the-badge)](https://packagist.org/packages/matthewpageuk/laravel-bitty-enums)
[![GitHub Issues](https://img.shields.io/github/issues/matthewpageuk/laravel-bitty-enums.svg?style=for-the-badge)](https://github.com/matthewpageuk/laravel-bitty-enums/issues)

This package helps you use bitwise enums in your Laravel application if you choose to, think before you do. It provides an Enum Container, a trait for your model query scopes and a model attribute cast.

You can think of this as a hasMany relationship but using a single integer column to store the data.

![bitty1](https://github.com/MatthewPageUK/laravel-bitty-enums/assets/46349796/faed58e5-8f08-456c-a24e-9a7f17870f15)

## Installation

You can install the package into your Laravel project via composer:

```bash
composer require matthewpageuk/laravel-bitty-enums
```

## Usage

- [Create an Enum](#create-an-enum)
- [Using the Bitty Enum Container](#using-the-bitty-enum-container)
- [Model Attribute Cast](#model-attribute-cast)
- [Scoped Queries](#scoped-queries)
- [Config settings](#config-settings)

## Create an Enum

You can create a new `enum` using the `bitty-enum:make` Artisan command. This command will create a new enum class in the `app/Enums` directory with the cases you supply. It will ensure the values and names are suitable for use with the package.

```bash
php artisan bitty-enum:make Colours
```

To use your own `enums` with this package they must :

- Implement the `MatthewPageUK\BittyEnums\Contracts\BittyEnum` interface.
- Return type `int`
- Values be a power of 2 starting from 1 in order

Invalid enums will throw an `BittyEnumException` when used with the container.

***There is a current limit of 16 cases (bits) per enum. This can be overiding in your config files.***

### Example of a Colour enum:

```php
use MatthewPageUK\BittyEnums\Contracts\BittyEnum;

enum Colour: int implements BittyEnum
{
    case Red = 1;
    case Green = 2;
    case Blue = 4;
    case White = 8;
    case Black = 16;
    case Pink = 32;
}
```

## Using the Bitty Enum Container

The container is used to store the selected enum values. It is a wrapper around the integer value and provides methods to manage and check the values. It also performs validation on the values you set to prevent accidental misuse.

### Creating a container

You can create a new container using the Contract binding in the Laravel app.

```php
use App\Enums\Colour;
use MatthewPageUK\BittyEnums\Contracts\BittyContainer;

$container = app()->make(BittyContainer::class)->setClass(Colour::class);
```

This will create a container suitable for the `Colour` enum.

You can also use the `MatthewPageUK\BittyEnums\Support\Container` directly.

```php
use MatthewPageUK\BittyEnums\Support\Container as BittyContainer;

$favouriteColours = (new BittyContainer(Colour::class))
    ->set(Colour::Red)
    ->set(Colour::Green)
    ->set(Colour::Blue);
```

### Example usage

```php

// Set values
$favouriteColours = app()->make(BittyContainer::class)
    ->setClass(Colour::class)
    ->set(Colour::Red)
    ->set(Colour::Green)
    ->set(Colour::Blue);

// Passing an array of values
$favouriteColours = app()->make(BittyContainer::class)
    ->setClass(Colour::class)
    ->set([Colour::Red, Colour::Green, Colour::Blue]);

// Unset a value
$favouriteColours->unset(Colour::Red);

// Check if the container has a value
if ($favouriteColours->has(Colour::Red)) {
    echo 'Red is one of your favourite colours';
}

// Check if the container has any of the values
if ($favouriteColours->hasAny([Colour::Red, Colour::Green])) {
    echo 'You like red or green';
}

// Check if the container has all of the values
if ($favouriteColours->hasAll([Colour::Red, Colour::Green])) {
    echo 'You like red and green';
}

// Pass another container to check if any of the values exist
if ($product->colours->hasAny($favouriteColours)) {
    echo 'This product is available in one of your favourite colours';
}
```

### Container public methods

```php
public function __construct(string $class, int $selected = 0);

public function clear(): BittyContainer;

public function getChoices(): array;

public function getValue(): int;

public function has(BittyEnum $choice): bool;

public function hasAll(array|BittyContainer $choices): bool;

public function hasAny(array|BittyContainer $choices): bool;

public function set(array|BittyContainer|BittyEnum $choice): BittyContainer;

public function setAll(): BittyContainer;

public function unset(array|BittyContainer|BittyEnum $choice): BittyContainer;
```

### Validation

The container also perfoms validation on the values you set, throwing a `BittyEnumException` if you try to set an invalid value or have a malformed enum.

## Model Attribute Cast

You can cast the `integer` column on your models to a `BittyEnumContainer` using the `MatthewPageUK\BittyEnums\Casts\BittyEnumCast` cast.

You must pass the enum class you intend to use as the second parameter.

Your database column should be a `BIGINT`.

@todo see also bit limit on enum, how many can we have?

### Example Laravel Model

```php
Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->unsignedBigInteger('colours');
    $table->unsignedInteger('price');
    $table->timestamps();
});

use App\Enums\Colour;
use MatthewPageUK\BittyEnums\Casts\BittyEnumCast;

class Product extends Model
{
    protected $casts = [
        'colours' => BittyEnumCast::class . ':' . Colour:class,
    ];
}
```
You can now use the container methods to update and retrieve the enum values direct from your model attribute.

### Example Usage

```php
$product = Product::find(1);
$product->colours->set(Colour::Blue)->unset(Colours::Red);
$product->save();
```

```php
// Check if value exists
$product = Product::find(1);
if ($product->colours->has(Colour::Blue)) {
    echo 'This product is available in blue';
}
```

```php
// Check if any of the values exist
$customerPreferences = app()->make(BittyContainer::class)
    ->setClass(Colour::class)
    ->set(Colour::Blue)
    ->set(Colour::Red)
    ->set(Colour::Green);

$product = Product::find(1);
if ($product->colours->hasAny($customerPreferences)) {
    echo 'This product is available in one of the customers preferred colours';
}
```

## Scoped Queries

To access the scoped queries in your model you need to use the `MatthewPageUK\BittyEnums\Traits\WithBittyEnumQueryScope` trait.

You should also ensure your model has the [BittyEnumCast](#model-attribute-cast) set on the column you want to query.

### Example Model

```php
use App\Enums\Colours;
use MatthewPageUK\BittyEnums\Traits\WithBittyEnumQueryScope;

class Product extends Model
{
    use WithBittyEnumQueryScope;

    ...
}
```

### Example Queries

```php
// Products with the colour blue
Product::whereBittyEnumHas('colours', Colour::Blue)->get();

// Products with the colour blue or red
Product::whereBittyEnumHasAny('colours', [Colour::Blue, Colour::Red])->get();

// Products with the colour blue and red
Product::whereBittyEnumHasAll('colours', [Colour::Blue, Colour::Red])->get();

// Products without the colour blue
Product::whereBittyEnumDoesntHave('colours', Colour::Blue)->get();

// Products without the colour blue or red
$customerPreferences = new BittyEnumContainer(Colour::class)
    ->set(Colour::Blue)
    ->set(Colour::Red);

Product::whereBittyEnumDoesntHaveAny('colours', $customerPreferences)->get();
```
Methods accepting multiple choices can be an array of `BittyEnum` or a `BittyEnumContainer`.

A `BittyEnumException` will be thrown if you pass the incorrect type or invalid enum to the query scope.

## Config settings

You can set the maximum number of bits for the container in the config file.

```php
return [
    'max_bits' => 16,
];
```

## Package Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Matthew Page](https://github.com/MatthewPageUK)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
