# A Laravel cast to convert strings to DateTimeZone instances

[![Latest Version on Packagist](https://img.shields.io/packagist/v/maartenpaauw/laravel-date-time-zone-cast.svg?style=flat-square)](https://packagist.org/packages/maartenpaauw/laravel-date-time-zone-cast)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/maartenpaauw/laravel-date-time-zone-cast/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/maartenpaauw/laravel-date-time-zone-cast/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/maartenpaauw/laravel-date-time-zone-cast/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/maartenpaauw/laravel-date-time-zone-cast/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/maartenpaauw/laravel-date-time-zone-cast.svg?style=flat-square)](https://packagist.org/packages/maartenpaauw/laravel-date-time-zone-cast)

A Laravel cast that allows you to store and retrieve `DateTimeZone` objects in your Eloquent models. This cast
automatically converts timezone strings (e.g. 'Europe/Amsterdam') to PHP `DateTimeZone` instances and vice versa when
interacting with your database.

## Support Me

<p class="filament-hidden">
    <a href="https://filamentphp.com/plugins/maartenpaauw-model-states">
        <img src="https://raw.githubusercontent.com/maartenpaauw/model-states-for-filament-docs/main/assets/images/model-states-for-filament-banner.jpg"
            alt="Model States for Filament"
            width="700px" />
    </a>
</p>

You can support me by [buying Model States for Filament](https://filamentphp.com/plugins/maartenpaauw-model-states).

## Installation

You can install the package via composer:

```bash
composer require maartenpaauw/laravel-date-time-zone-cast
```

## Usage

### 1. Add the Cast to Your Model

Add the cast to your Eloquent model's `$casts` array:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Maartenpaauw\LaravelDateTimeZoneCast\DateTimeZoneCast;

class User extends Model
{
    protected $casts = [
        'timezone' => DateTimeZoneCast::class,
    ];
}
```

### 2. Database Schema

Ensure your database column is set up to store timezone strings:

```php
Schema::table('users', function (Blueprint $table) {
    $table->string('timezone')->nullable();
});
```

### 3. Working with the Model

```php
$user = new User();
$user->timezone = 'Europe/Amsterdam';
$user->save();

$timezone = $user->timezone; // DateTimeZone instance
echo $timezone->getName(); // 'Europe/Amsterdam'
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Maarten Paauw](https://github.com/maartenpaauw)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
