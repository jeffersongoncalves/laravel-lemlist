<div class="filament-hidden">

![Laravel Lemlist](https://raw.githubusercontent.com/jeffersongoncalves/laravel-lemlist/main/art/jeffersongoncalves-laravel-lemlist.png)

</div>

# Laravel Lemlist

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jeffersongoncalves/laravel-lemlist.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/laravel-lemlist)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/laravel-lemlist/tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/jeffersongoncalves/laravel-lemlist/actions?query=workflow%3Atests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/laravel-lemlist/pint.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/jeffersongoncalves/laravel-lemlist/actions?query=workflow%3A%22Fix+PHP+code+styling%22+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/jeffersongoncalves/laravel-lemlist.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/laravel-lemlist)
[![License](https://img.shields.io/packagist/l/jeffersongoncalves/laravel-lemlist.svg?style=flat-square)](LICENSE.md)

A Laravel client for the [Lemlist](https://lemlist.com) REST API. A fluent `Lemlist` facade covers cold-email campaigns, leads, unsubscribes, activities and webhooks, authenticates every request with HTTP Basic auth, and throws a `LemlistException` on a non-2xx response instead of returning a silent error array.

## Features

- **Team** — `info()`
- **Campaigns** — `list()`, `get()`, `stats()`, `export()`
- **Leads** — `list()`, `get()`, `add()`, `delete()`
- **Unsubscribes** — `list()`, `add()`, `delete()`
- **Activities** — `list()`
- **Webhooks** — `list()`, `create()`, `delete()`
- **Thin by design** — every method returns the raw decoded JSON response as an array, no DTOs
- **Fails loud** — a non-2xx API response throws a `LemlistException` carrying the API's error message and HTTP status code

## Installation

You can install the package via composer:

```bash
composer require jeffersongoncalves/laravel-lemlist
```

Optionally publish the config file:

```bash
php artisan vendor:publish --tag="lemlist-config"
```

## Configuration

Add to your `.env`:

```env
LEMLIST_API_KEY=your-api-key
```

Find your API key in Lemlist under Settings → Integrations → API Key.

### Config Options

```php
// config/lemlist.php
return [
    'api_key' => env('LEMLIST_API_KEY'),
    'base_url' => env('LEMLIST_BASE_URL', 'https://api.lemlist.com/api'),
];
```

## Usage

```php
use JeffersonGoncalves\Lemlist\Facades\Lemlist;
use JeffersonGoncalves\Lemlist\Exceptions\LemlistException;
```

### Team

```php
Lemlist::team()->info();
```

### Campaigns

```php
Lemlist::campaigns()->list(['limit' => 10, 'offset' => 0]);
Lemlist::campaigns()->get('campaign-id');
Lemlist::campaigns()->stats('campaign-id');
Lemlist::campaigns()->export('campaign-id');
```

### Leads

```php
Lemlist::leads()->list('campaign-id', ['limit' => 10]);
Lemlist::leads()->get('campaign-id', 'lead@acme.com');
Lemlist::leads()->add('campaign-id', 'lead@acme.com', [
    'first-name' => 'Jane',
    'last-name' => 'Doe',
    'company' => 'Acme',
]);
Lemlist::leads()->delete('campaign-id', 'lead@acme.com');
```

### Unsubscribes

```php
Lemlist::unsubscribes()->list(['limit' => 10]);
Lemlist::unsubscribes()->add('lead@acme.com');
Lemlist::unsubscribes()->delete('lead@acme.com');
```

### Activities

```php
Lemlist::activities()->list([
    'campaignId' => 'campaign-id',
    'type' => 'emailsOpened',
]);
```

### Webhooks

```php
Lemlist::webhooks()->list();
Lemlist::webhooks()->create('https://example.com/hook', 'emailsOpened');
Lemlist::webhooks()->delete('hook-id');
```

### Handling errors

```php
try {
    $result = Lemlist::campaigns()->get('campaign-id');
} catch (LemlistException $e) {
    // $e->getMessage() — the API's error message, or the raw response body
    // $e->errorBody()   — the full decoded JSON error response
}
```

## Testing

```bash
composer test
```

## Static Analysis

```bash
composer analyse
```

## Code Formatting

```bash
composer format
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

- [Jefferson Simão Gonçalves](https://github.com/jeffersongoncalves)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
