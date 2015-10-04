Gravatar [![For PHP][badge_php]](https://github.com/ARCANEDEV/Gravatar) [![For Laravel 5][badge_laravel]](https://github.com/ARCANEDEV/Gravatar) [![Packagist License][badge_license]](https://github.com/ARCANEDEV/Gravatar/blob/master/LICENSE.md)
==============
[![Travis Status][badge_build]](https://travis-ci.org/ARCANEDEV/Gravatar)
[![Coverage Status][badge_coverage]](https://scrutinizer-ci.com/g/ARCANEDEV/Gravatar/?branch=master)
[![Scrutinizer Code Quality][badge_quality]](https://scrutinizer-ci.com/g/ARCANEDEV/Gravatar/?branch=master)
[![Github Issues][badge_issues]](https://github.com/ARCANEDEV/Gravatar/issues)
[![Packagist Release][badge_release]](https://packagist.org/packages/arcanedev/gravatar)
[![Packagist Downloads][badge_downloads]](https://packagist.org/packages/arcanedev/gravatar)

[badge_php]:       https://img.shields.io/badge/PHP-Framework%20agnostic-4F5B93.svg?style=flat-square
[badge_laravel]:   https://img.shields.io/badge/for%20Laravel-5.1-orange.svg?style=flat-square
[badge_license]:   http://img.shields.io/packagist/l/arcanedev/gravatar.svg?style=flat-square
[badge_build]:     http://img.shields.io/travis/ARCANEDEV/Gravatar.svg?style=flat-square
[badge_coverage]:  https://img.shields.io/scrutinizer/coverage/g/ARCANEDEV/Gravatar.svg?style=flat-square
[badge_quality]:   https://img.shields.io/scrutinizer/g/ARCANEDEV/Gravatar.svg?style=flat-square
[badge_issues]:    http://img.shields.io/github/issues/ARCANEDEV/Gravatar.svg?style=flat-square
[badge_release]:   https://img.shields.io/packagist/v/arcanedev/gravatar.svg?style=flat-square
[badge_downloads]: https://img.shields.io/packagist/dt/arcanedev/gravatar.svg?style=flat-square

*By [ARCANEDEV&copy;](http://www.arcanedev.net/)*

Gravatar is a small library that provides an easy way to integrate and generate &hellip; Gravatars ??

Feel free to check out the [releases](https://github.com/ARCANEDEV/Gravatar/releases), [license](https://github.com/ARCANEDEV/Gravatar/blob/master/LICENSE.md), and [contribution guidelines](https://github.com/ARCANEDEV/Gravatar/blob/master/CONTRIBUTING.md).
  
### Features

  * Framework-agnostic (Works in any PHP projects).
  * Laravel 5 Supported.
  * Easy setup & configuration. 
  * Well tested (100% code coverage with maximum code quality).
  * Made with :heart: &amp; :coffee:.

## Installation

Update your `composer.json` file to include this package as a dependency

```json
"require": {
    "arcanedev/gravatar": "~1.0"
}
```

Then run `composer install` or `composer update`. 

### Laravel Setup

Register the Gravatar service provider by adding it to the providers array in the `config/app.php` file.

```php
'providers' => [
    // ...
    Arcanedev\Gravatar\GravatarServiceProvider::class,
],
```

Alias the Gravatar facade by adding it to the aliases array in the `config/app.php` file.

```php
'aliases' => [
    // ...
    'Gravatar' => Arcanedev\Gravatar\Facades\Gravatar::class,
],
```

## Configuration (Optional)

Publish the gravatar config file into your project by running:

```bash
$ php artisan vendor:publish --provider="Arcanedev\Gravatar\GravatarServiceProvider"
```

### Default Image

Update the config file `config\gravatar.php` to specify the default avatar size to use and a default image to be return if no Gravatar is found.

Allowed defaults:

| Value       | Description                                                                                                           |
|-------------|-----------------------------------------------------------------------------------------------------------------------|
| false       | (undefined)                                                                                                           |
| `404`       | do not load any image if none is associated with the email hash, instead return an HTTP 404 (File Not Found) response |
| `mm`        | (mystery-man) a simple, cartoon-style silhouetted outline of a person (does not vary by email hash).                  |
| `identicon` | a geometric pattern based on an email hash.                                                                           |
| `monsterid` | a generated 'monster' with different colors, faces, etc.                                                              |
| `wavatar`   | generated faces with differing features and backgrounds.                                                              |
| `retro`     | awesome generated, 8-bit arcade-style pixelated faces.                                                                |

Example images can be viewed on [the Gravatar website](https://gravatar.com/site/implement/images/).

### Content Ratings

By default only "g" rated images will be shown.

| Value | Description                                                                                             |
|-------|---------------------------------------------------------------------------------------------------------|
| `g`   | suitable for display on all websites with any audience type.                                            |
| `pg`  | may contain rude gestures, provocatively dressed individuals, the lesser swear words, or mild violence. |
| `r`   | may contain such things as harsh profanity, intense violence, nudity, or hard drug use.                 |
| `x`   | may contain hardcore sexual imagery or extremely disturbing violence.                                   | 

The content rating can be changed by changing the `$rating` argument when calling `Gravatar::src` or `Gravatar::image`.

## Usage (Hard coded)

We start by creating a gravatar instance:

```php

use Arcanedev\Gravatar\Gravatar;

$gravatar = new Gravatar;

// OR
 
$default  = 'mm';
$size     = 128;
$rating   = 'g';

$gravatar = new Gravatar($default, $size, $rating);
```

To get the gravatar url:

```php
echo $gravatar->get('your@email.com');

// or

echo $gravatar->src('your@email.com');
echo $gravatar->src('your@email.com', 512);
echo $gravatar->src('your@email.com', 512, 'g');
```

You can check if the email has a gravatar:

```php
if ($gravatar->exists('your@email.com')) {
    echo 'Nice avatar';
}
else {
    echo 'Faceless';
}
```

## Usage (Laravel)

### Gravatar::exists($email)

Returns a boolean telling if has a gravatar of the given `$email`.

### Gravatar::src($email, $size = null, $rating = null)

Returns the https URL for the Gravatar of the specified email address.

Can optionally pass in the size required as an integer (range between 1 - 512). 

```html
<!-- Show image with default dimensions -->
<img src="{{ Gravatar::src('your@email.com') }}">

<!-- Show image at 256px -->
<img src="{{ Gravatar::src('your@email.com', 256) }}">
```

### Gravatar::image($email, $alt = null, $attributes = [], $rating = null)

Returns the HTML for an `<img>` tag

```php
// Show image with default dimensions
echo Gravatar::image('your@email.com');

// Adding attributes
echo Gravatar::image('your@email.com', 'Your username', ['class' => 'img-responsive']);

// Or
echo Gravatar::image('your@email.com', 'Your username', [width' => 200, 'height' => 200]);
```

 > For the blade engine use `{!! ... !!}` to echo out the images.
