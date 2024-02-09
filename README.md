# WIP!  This package helps you use bitwise enums

[![Latest Version on Packagist](https://img.shields.io/packagist/v/matthewpageuk/laravel-bitwise-enums.svg?style=flat-square)](https://packagist.org/packages/matthewpageuk/laravel-bitwise-enums)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/matthewpageuk/laravel-bitwise-enums/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/matthewpageuk/laravel-bitwise-enums/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/matthewpageuk/laravel-bitwise-enums/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/matthewpageuk/laravel-bitwise-enums/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/matthewpageuk/laravel-bitwise-enums.svg?style=flat-square)](https://packagist.org/packages/matthewpageuk/laravel-bitwise-enums)

This package helps you use bitwise enums in your Laravel application if you choose to, think before you do... It provides an Enum Container, a Trait for your model queries and a Model Cast.

## Installation

You can install the package via composer:

```bash
composer require matthewpageuk/laravel-bitwise-enums
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-bitwise-enums-config"
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
$bitwiseEnums = new MatthewPageUK\BitwiseEnums();
echo $bitwiseEnums->echoPhrase('Hello, MatthewPageUK!');
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
