# WIP!  This package helps you use bitty enums

[![Latest Version on Packagist](https://img.shields.io/packagist/v/matthewpageuk/laravel-bitty-enums.svg?style=flat-square)](https://packagist.org/packages/matthewpageuk/laravel-bitty-enums)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/matthewpageuk/laravel-bitty-enums/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/matthewpageuk/laravel-bitty-enums/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/matthewpageuk/laravel-bitty-enums/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/matthewpageuk/laravel-bitty-enums/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/matthewpageuk/laravel-bitty-enums.svg?style=flat-square)](https://packagist.org/packages/matthewpageuk/laravel-bitty-enums)
[![GitHub Issues](https://img.shields.io/github/issues/matthewpageuk/laravel-bitty-enums)](https://github.com/matthewpageuk/laravel-bitty-enums/issues)

This package helps you use bitty enums in your Laravel application if you choose to, think before you do... It provides an Enum Container, a Trait for your model queries and a Model Cast.

## Installation

WIP DO NOT DO THIS....


You can install the package via composer:

```bash
composer require matthewpageuk/laravel-bitty-enums
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-bitty-enums-config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

- [Create an Enum](#create-an-enum)
- [Using the Bitty Enum Container](#using-the-bitty-enum-container)
- [Model Attribute Cast](#model-attribute-cast)
- [Scoped Queries](#scoped-queries)

## Create an Enum

To use an `enum` with this package you must implement the `MatthewPageUK\BittyEnums\Contracts\BittyEnum` interface.

Return type must be `int` and the values must be a power of 2 starting from 1.

Invalid values will throw an `InvalidEnumValueException`.

There is a current limit of 16 cases (bits) per enum. @todo can this be 32 bits?

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

You can use the `MatthewPageUK\BittyEnums\Support\Container` to manage the enum values, perform checks and manage the values.

```php

use MatthewPageUK\BittyEnums\Support\Container as BittyEnumContainer;

$favouriteColours = new BittyEnumContainer(Colour::class)
    ->set(Colour::Red)
    ->set(Colour::Green)
    ->set(Colour::Blue);

// Check if the container has a value
if ($favouriteColours->has(Colour::Red)) {
    echo 'Red is one of your favourite colours';
}

// Methods
public function set(BittyEnum $choice): self;

public function unset(BittyEnum $choice): self;

public function has(BittyEnum $choice): bool;

public function getChoices(): array;

public function getValue(): int;

public function clear(): self;

public function setAll(): self;
```

The container also perfoms validation on the values you set, throwing a `InvalidArgumentException` if you try to set an invalid value or have a malformed enum.

## Model Attribute Cast

You can cast the `integer` column on your models to a `BittyEnumContainer` using the `MatthewPageUK\BittyEnums\Casts\BittyEnumCast` cast.

You must pass the enum class you intend to use as the second parameter.

Your database column should be a `BIGINT`. @todo see also bit limit on enum?

```php
use App\Enums\Colours;
use MatthewPageUK\BittyEnums\Casts\BittyEnumCast;

class Product extends Model
{
    protected $casts = [
        'colours' => BittyEnumCast::class . ':' . Colours:class,
    ];
}
```
You can now use the container methods to update and retrieve the enum values.

```php
// Set and update value
$product = Product::find(1);
$product->colours->set(Colours::Blue)->unset(Colours::Red);
$product->save();
```

```php
// Check if value exists
$product = Product::find(1);
if ($product->colours->has(Colours::Blue)) {
    echo 'This product is available in blue';
}
```

```php
// Check if any of the values exist
use MatthewPageUK\BittyEnums\Support\Container as BittyEnumContainer;

$customerPreferences = new BittyEnumContainer(Colours::class)
    ->set(Colours::Blue)
    ->set(Colours::Red)
    ->set(Colours::Green);

$product = Product::find(1);
if ($product->colours->hasAny($customerPreferences)) {
    echo 'This product is available in one of the customers preferred colours';
}
```

## Scoped Queries

To use the scoped queries you need to use the `MatthewPageUK\BittyEnums\Traits\WithBittyEnumQueryScope` trait in your model.

```php
use App\Enums\Colours;
use MatthewPageUK\BittyEnums\Traits\WithBittyEnumQueryScope;

class Product extends Model
{
    use WithBittyEnumQueryScope;

    ...
}
```

You can now use the following scope queries:

```php
// Products with the colour blue
Product::whereBittyEnumHas('colours', Colours::Blue)->get();

// Products with the colour blue or red
Product::whereBittyEnumHasAny('colours', [Colours::Blue, Colours::Red])->get();

// Products with the colour blue and red
Product::whereBittyEnumHasAll('colours', [Colours::Blue, Colours::Red])->get();

// Products without the colour blue
Product::whereBittyEnumDoesntHave('colours', Colours::Blue)->get();

// Products without the colour blue or red
$customerPreferences = new BittyEnumContainer(Colours::class)
    ->set(Colours::Blue)
    ->set(Colours::Red);

Product::whereBittyEnumDoesntHaveAny('colours', $customerPreferences)->get();

...xxx
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
