# WIP!  This package helps you use bitty enums

[![Latest Version on Packagist](https://img.shields.io/packagist/v/matthewpageuk/laravel-bitty-enums.svg?style=flat-square)](https://packagist.org/packages/matthewpageuk/laravel-bitty-enums)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/matthewpageuk/laravel-bitty-enums/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/matthewpageuk/laravel-bitty-enums/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/matthewpageuk/laravel-bitty-enums/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/matthewpageuk/laravel-bitty-enums/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/matthewpageuk/laravel-bitty-enums.svg?style=flat-square)](https://packagist.org/packages/matthewpageuk/laravel-bitty-enums)

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

- Creating an enum
- Migration
- Add cast to model
- Use trait in model
- Use enum container

```php
$bittyEnums = new MatthewPageUK\BittyEnums();
echo $bittyEnums->echoPhrase('Hello, MatthewPageUK!');
```


### Scoped Queries

```php

Model::whereBittyEnumHas('colours', Colours::Blue)->get();

xxx
Model::whereBittyEnumHasAny('colours', Colours::Blue)->get();

```






## Testing

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
