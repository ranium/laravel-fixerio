# Laravel Fixer.io

Provides an easy to use Laravel package for [fixer.io](https://fixer.io) exchange rates and currency conversion JSON API. This is basically a Laravel wrapper for [ranium/fixerio-php-client](https://github.com/ranium/fixerio-php-client).

## Installation

Run the following from the root of your Laravel app

`composer require ranium/laravel-fixerio`

## Configuration

Publish the config file

`php artisan vendor:publish --tag=laravel-fixerio`

Edit the `config/fixerio.php` and put your access key and tweak other config options as needed. Note that the `secure` option works only with the paid plans of fixer.io.

## Usage

```php
// Resolve the client class instance out of the service container
$fixerio = app(\Ranium\LaravelFixerio\Client::class);

// Find latest rates
$latestRates = $fixerio->latest();

echo $latestRates['rates']['INR'];

// Find historical rates
$historicalRates = $fixerio->historical(['date' => '2019-01-01']);

echo $historicalRates['rates']['INR'];
```

You can use the provided Facade as well
```php
use Fixerio;

$latestRates = Fixerio::latest();
```
As there is a hard limit on number of requests you can make to fixer.io, this package provides an easy way to cache the responses. Default cache storage is used for caching.

Modify the `config/fixerio.php` to enable the caching.

```php
'cache' => [
    'enabled' => true,
    'expire_after' => 60, // In minutes, change this as per requirement
];
```

You can disable cache in the runtime.

```php
use Fixerio;

Fixerio::disableCache();

$latestRates = Fixerio::latest();

// Enable cache again for other calls
Fixerio::enableCache();

// Other calls to the API...
```

Please refer [ranium/fixerio-php-client](https://github.com/ranium/fixerio-php-client) for all available API calls and other details.

The response for all the above calls will be a Guzzle Command Result object. Please refer fixer.io's [documentation](https://fixer.io/documentation) for further details about various endpoints, request parameters and response objects.

## License

This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
