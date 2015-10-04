# 2. Installation

## Composer

You can install this package via [Composer](http://getcomposer.org/) by running this command: `composer require arcanedev/gravatar`.

Or by adding the package to your `composer.json`. 

```json
{
    "require": {
        "arcanedev/gravatar": "~1.0"
    }
}
```    

Then install it via `composer install` or `composer update`.

## Laravel Setup

Once the package is installed, you can register the service provider in `config/app.php` in the `providers` array:

```php
'providers' => [
    ...
    Arcanedev\Gravatar\GravatarServiceProvider::class,
],
```

**Optional :** Alias the Gravatar facade by adding it to the aliases array in the `config/app.php` file.

```php
'aliases' => [
    // ...
    'Gravatar' => Arcanedev\Gravatar\Facades\Gravatar::class,
],
```

### Artisan command

To publish the config file, run this command:
 
```bash
$ php artisan vendor:publish --provider="Arcanedev\Gravatar\GravatarServiceProvider"
```
