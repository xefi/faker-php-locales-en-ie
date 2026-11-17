# Faker PHP — en_IE locale

Irish English (`en_IE`) locale for [Faker PHP](https://github.com/xefi/faker-php).

## Installation

```bash
composer require --dev xefi/faker-php-locales-en-ie
```

The service provider is discovered automatically through Composer.

## Usage

```php
use Xefi\Faker\Faker;

$faker = new Faker('en_IE');
```

Generators without a `en_IE` variant fall back to the default locale.

## Locale-specific generators

```php
$faker->county();         // 'Galway'
$faker->province();       // 'Connacht'
$faker->postcode();       // Eircode, e.g. 'H91 X2Y3'
$faker->ppsn();           // PPS Number, valid modulus 23 check character
$faker->vat();            // 'IE1234567FA', valid modulus 23 check character
$faker->companyNumber();  // CRO number
$faker->iban();           // 'IE29AIBK93115212345678'
```

## Contributing

1. Fork the repository and create a branch from `main`.
2. Add an extension under `src/Extensions/` and register it in `FakerEnIeServiceProvider::boot()`.
3. Add a test under `tests/Unit/`.
4. Run the suite with `vendor/bin/phpunit` (or `docker compose run php vendor/bin/phpunit`).
5. Open a pull request against `main`.

## License

MIT
