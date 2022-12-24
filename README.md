# Hopex Logging

<p>
    <img alt="Version Badge" src="https://img.shields.io/endpoint?url=https://packages-api.hopex.ru/simplog/badges/version/package">
    <img alt="PHP Badge" src="https://img.shields.io/endpoint?url=https://packages-api.hopex.ru/simplog/badges/version/php">
    <img alt="Laravel Badge" src="https://img.shields.io/endpoint?url=https://packages-api.hopex.ru/simplog/badges/version/laravel">
    <img alt="License Badge" src="https://img.shields.io/endpoint?url=https://packages-api.hopex.ru/simplog/badges/license">
</p>

> The library contains a simple class, and it's facade, for simple data and exception logging.

### Installing
```
composer require hopex/simplog
```

### Usage in Laravel
Provider and facades will be automatically registered, however you can manually add them to `config/app.php`.
```php
'providers' => [
    // ...
    Hopex\Simplog\Providers\ServiceProvider::class,
],
'aliases' => Facade::defaultAliases()->merge([
    // ...
    'Logger' => \Hopex\Simplog\Logger::class,
])->toArray(),
```