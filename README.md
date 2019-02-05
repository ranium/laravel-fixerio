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
$fixerio = app(\Ranium\Fixerio\Client::class);

// Find latest rates
$latestRates = $fixerio->latest();

echo $latestRates['rates']['INR'];

// Find historical rates
$historicalRates = $fixerio->historical(['date' => '2019-01-01']);

echo $historicalRates['rates']['INR'];
```
Please refer [ranium/fixerio-php-client](https://github.com/ranium/fixerio-php-client) for all available API calls and other details.

The response for all the above calls will be a Guzzle Command Result object. Please refer fixer.io's [documentation](https://fixer.io/documentation) for further details about various endpoints, request parameters and response objects.
