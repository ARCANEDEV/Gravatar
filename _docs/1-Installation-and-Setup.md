# 2. Installation

## Table of contents

  1. [Installation and Setup](1-Installation-and-Setup.md)
  2. [Configuration](2-Configuration.md)
  3. [Usage](3-Usage.md)
    
## Version Compatibility

| Laravel                      | Gravatar                         |
|:-----------------------------|:---------------------------------|
| ![Laravel v8.x][laravel_8_x] | ![Gravatar v5.x][gravatar_5_x]   |
| ![Laravel v7.x][laravel_7_x] | ![Gravatar v4.x][gravatar_4_x]   |
| ![Laravel v6.x][laravel_6_x] | ![Gravatar v3.x][gravatar_3_x]   |
| ![Laravel v5.8][laravel_5_8] | ![Gravatar v2.4.x][gravatar_2_4] |
| ![Laravel v5.7][laravel_5_7] | ![Gravatar v2.3.x][gravatar_2_3] |
| ![Laravel v5.6][laravel_5_6] | ![Gravatar v2.2.x][gravatar_2_2] |
| ![Laravel v5.5][laravel_5_5] | ![Gravatar v2.1.x][gravatar_2_1] |
| ![Laravel v5.4][laravel_5_4] | ![Gravatar v2.0.x][gravatar_2_0] |
| ![Laravel v5.3][laravel_5_3] | ![Gravatar v1.x][gravatar_1_x]   |
| ![Laravel v5.2][laravel_5_2] | ![Gravatar v1.x][gravatar_1_x]   |
| ![Laravel v5.1][laravel_5_1] | ![Gravatar v1.x][gravatar_1_x]   |
| ![Laravel v5.0][laravel_5_0] | ![Gravatar v1.x][gravatar_1_x]   |

> **Note :** This is a framework-agnostic package, so you can use any version of this package in your PHP project.

[laravel_8_x]: https://img.shields.io/badge/version-8.x-blue.svg?style=flat-square "Laravel v8.x"
[laravel_7_x]: https://img.shields.io/badge/version-7.x-blue.svg?style=flat-square "Laravel v7.x"
[laravel_6_x]: https://img.shields.io/badge/version-6.x-blue.svg?style=flat-square "Laravel v6.x"
[laravel_5_8]: https://img.shields.io/badge/version-5.8-blue.svg?style=flat-square "Laravel v5.8"
[laravel_5_7]: https://img.shields.io/badge/version-5.7-blue.svg?style=flat-square "Laravel v5.7"
[laravel_5_6]: https://img.shields.io/badge/version-5.6-blue.svg?style=flat-square "Laravel v5.6"
[laravel_5_5]: https://img.shields.io/badge/version-5.5-blue.svg?style=flat-square "Laravel v5.5"
[laravel_5_4]: https://img.shields.io/badge/version-5.4-blue.svg?style=flat-square "Laravel v5.4"
[laravel_5_3]: https://img.shields.io/badge/version-5.3-blue.svg?style=flat-square "Laravel v5.3"
[laravel_5_2]: https://img.shields.io/badge/version-5.2-blue.svg?style=flat-square "Laravel v5.2"
[laravel_5_1]: https://img.shields.io/badge/version-5.1-blue.svg?style=flat-square "Laravel v5.1"
[laravel_5_0]: https://img.shields.io/badge/version-5.0-blue.svg?style=flat-square "Laravel v5.0"

[gravatar_5_x]: https://img.shields.io/badge/version-5.x-blue.svg?style=flat-square "Gravatar v5.x"
[gravatar_4_x]: https://img.shields.io/badge/version-4.x-blue.svg?style=flat-square "Gravatar v4.x"
[gravatar_3_x]: https://img.shields.io/badge/version-3.x-blue.svg?style=flat-square "Gravatar v3.x"
[gravatar_2_4]: https://img.shields.io/badge/version-2.4.x-blue.svg?style=flat-square "Gravatar v2.4.x"
[gravatar_2_3]: https://img.shields.io/badge/version-2.3.x-blue.svg?style=flat-square "Gravatar v2.3.x"
[gravatar_2_2]: https://img.shields.io/badge/version-2.2.x-blue.svg?style=flat-square "Gravatar v2.2.x"
[gravatar_2_1]: https://img.shields.io/badge/version-2.1.x-blue.svg?style=flat-square "Gravatar v2.1.x"
[gravatar_2_0]: https://img.shields.io/badge/version-2.0.x-blue.svg?style=flat-square "Gravatar v2.0.x"
[gravatar_1_x]: https://img.shields.io/badge/version-1.x-blue.svg?style=flat-square "Gravatar v1.x"

## Composer

You can install this package via [Composer](http://getcomposer.org/) by running this command: `composer require arcanedev/gravatar`.

## Laravel Setup

> **NOTE :** The package will automatically register itself if you're using Laravel `>= v5.5`, so you can skip this section.

Once the package is installed, you can register the service provider in `config/app.php` in the `providers` array:

```php
'providers' => [
    ...
    Arcanedev\Gravatar\GravatarServiceProvider::class,
],
```

### Artisan command

To publish the config file, run this command:

```bash
$ php artisan vendor:publish --provider="Arcanedev\Gravatar\GravatarServiceProvider"
```
