## Install

```
composer require dkvhin/laravel-model-histories
```

## Publish Configs

```
php artisan vendor:publish --provider="Dkvhin\LaravelModelHistories\LaravelModelHistoriesServiceProvider" --tag="config"
```

```
php artisan vendor:publish --provider="Dkvhin\LaravelModelHistories\LaravelModelHistoriesServiceProvider" --tag="migrations"
```


### Usage

Add interface and Trait to Your Model

```php

use Dkvhin\LaravelModelHistories\HasHistories;
use Dkvhin\LaravelModelHistories\HasHistoriesTrait;

class User extends Model implements HasHistories
{
    use HasHistoriesTrait;

    /**
     * Exclude from history
     * @var array<string>
     */
    public array $excludeFromHistory = [
        'password'
    ];
}

```