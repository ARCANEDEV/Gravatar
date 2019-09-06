# 2. Installation

## Table of contents

  1. [Installation and Setup](1-Installation-and-Setup.md)
  2. [Configuration](2-Configuration.md)
  3. [Usage](3-Usage.md)
    
## Version Compatibility

| Gravatar                         | Laravel                                                                                                             |
|:---------------------------------|:--------------------------------------------------------------------------------------------------------------------|
| ![Gravatar v1.x][gravatar_1_x]   | ![Laravel v5.0][laravel_5_0] ![Laravel v5.1][laravel_5_1] ![Laravel v5.2][laravel_5_2] ![Laravel v5.3][laravel_5_3] |
| ![Gravatar v2.0.x][gravatar_2_0] | ![Laravel v5.4][laravel_5_4]                                                                                        |
| ![Gravatar v2.1.x][gravatar_2_1] | ![Laravel v5.5][laravel_5_5]                                                                                        |
| ![Gravatar v2.2.x][gravatar_2_2] | ![Laravel v5.6][laravel_5_6]                                                                                        |
| ![Gravatar v2.3.x][gravatar_2_3] | ![Laravel v5.7][laravel_5_7]                                                                                        |
| ![Gravatar v2.4.x][gravatar_2_4] | ![Laravel v5.8][laravel_5_8]                                                                                        |
| ![Gravatar v3.0.x][gravatar_3_0] | ![Laravel v6.0][laravel_6_0]                                                                                        |

> **Note :** This is a framework-agnostic package, so you can use any version of this package in your PHP project.

[laravel_5_0]:    https://img.shields.io/badge/v5.0-supported-brightgreen.svg?style=flat-square "Laravel v5.0"
[laravel_5_1]:    https://img.shields.io/badge/v5.1-supported-brightgreen.svg?style=flat-square "Laravel v5.1"
[laravel_5_2]:    https://img.shields.io/badge/v5.2-supported-brightgreen.svg?style=flat-square "Laravel v5.2"
[laravel_5_3]:    https://img.shields.io/badge/v5.3-supported-brightgreen.svg?style=flat-square "Laravel v5.3"
[laravel_5_4]:    https://img.shields.io/badge/v5.4-supported-brightgreen.svg?style=flat-square "Laravel v5.4"
[laravel_5_5]:    https://img.shields.io/badge/v5.5-supported-brightgreen.svg?style=flat-square "Laravel v5.5"
[laravel_5_6]:    https://img.shields.io/badge/v5.6-supported-brightgreen.svg?style=flat-square "Laravel v5.6"
[laravel_5_7]:    https://img.shields.io/badge/v5.7-supported-brightgreen.svg?style=flat-square "Laravel v5.7"
[laravel_5_8]:    https://img.shields.io/badge/v5.8-supported-brightgreen.svg?style=flat-square "Laravel v5.8"
[laravel_6_0]:    https://img.shields.io/badge/v6.0-supported-brightgreen.svg?style=flat-square "Laravel v6.0"

[gravatar_1_x]: https://img.shields.io/badge/version-1.*-blue.svg?style=flat-square "Gravatar v1.*"
[gravatar_2_0]: https://img.shields.io/badge/version-2.0.*-blue.svg?style=flat-square "Gravatar v2.0.*"
[gravatar_2_1]: https://img.shields.io/badge/version-2.1.*-blue.svg?style=flat-square "Gravatar v2.1.*"
[gravatar_2_2]: https://img.shields.io/badge/version-2.2.*-blue.svg?style=flat-square "Gravatar v2.2.*"
[gravatar_2_3]: https://img.shields.io/badge/version-2.3.*-blue.svg?style=flat-square "Gravatar v2.3.*"
[gravatar_2_4]: https://img.shields.io/badge/version-2.4.*-blue.svg?style=flat-square "Gravatar v2.4.*"
[gravatar_3_0]: https://img.shields.io/badge/version-3.0.*-blue.svg?style=flat-square "Gravatar v3.0.*"

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
