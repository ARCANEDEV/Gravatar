# 2. Installation

## Table of contents

  1. [Installation and Setup](1-Installation-and-Setup.md)
  2. [Configuration](2-Configuration.md)
  3. [Usage](3-Usage.md)

## Server Requirements

The Gravatar package has a few system requirements:

    - PHP >= 7.0
    
## Version Compatibility

| Gravatar                       | Laravel                                                                                                             |
|:-------------------------------|:--------------------------------------------------------------------------------------------------------------------|
| ![Gravatar v1.x][gravatar_1_x] | ![Laravel v5.0][laravel_5_0] ![Laravel v5.1][laravel_5_1] ![Laravel v5.2][laravel_5_2] ![Laravel v5.3][laravel_5_3] |
| ![Gravatar v2.x][gravatar_2_x] | ![Laravel v5.4][laravel_5_4]                                                                                        |
| ![Gravatar v3.x][gravatar_3_x] | ![Laravel v5.3][laravel_5_3]                                                                                        |

> **Note :** This is a framework-agnostic package, so you can use any version of this package in your PHP project.

[laravel_5_0]:    https://img.shields.io/badge/v5.0-supported-brightgreen.svg?style=flat-square "Laravel v5.0"
[laravel_5_1]:    https://img.shields.io/badge/v5.1-supported-brightgreen.svg?style=flat-square "Laravel v5.1"
[laravel_5_2]:    https://img.shields.io/badge/v5.2-supported-brightgreen.svg?style=flat-square "Laravel v5.2"
[laravel_5_3]:    https://img.shields.io/badge/v5.3-supported-brightgreen.svg?style=flat-square "Laravel v5.3"
[laravel_5_4]:    https://img.shields.io/badge/v5.4-supported-brightgreen.svg?style=flat-square "Laravel v5.4"
[laravel_5_5]:    https://img.shields.io/badge/v5.5-supported-brightgreen.svg?style=flat-square "Laravel v5.5"

[gravatar_1_x]: https://img.shields.io/badge/version-1.*-blue.svg?style=flat-square "Gravatar v1.*"
[gravatar_2_x]: https://img.shields.io/badge/version-2.*-blue.svg?style=flat-square "Gravatar v2.*"
[gravatar_3_x]: https://img.shields.io/badge/version-3.*-blue.svg?style=flat-square "Gravatar v3.*"

## Composer

You can install this package via [Composer](http://getcomposer.org/) by running this command: `composer require arcanedev/gravatar`.

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
