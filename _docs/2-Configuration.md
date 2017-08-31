# 3. Configuration (For Laravel Only)

## Table of contents

  1. [Installation and Setup](1-Installation-and-Setup.md)
  2. [Configuration](2-Configuration.md)
  3. [Usage](3-Usage.md)

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

> **Note :** You can also specify an image URL as a default image.

Example images can be viewed on [the Gravatar website](https://gravatar.com/site/implement/images/).

### Size

You can change the default size of all gravatar, by default is `80` (80px with and 80px height).

### Content Ratings

By default only "g" rated images will be shown.

| Value | Description                                                                                             |
|-------|---------------------------------------------------------------------------------------------------------|
| `g`   | suitable for display on all websites with any audience type.                                            |
| `pg`  | may contain rude gestures, provocatively dressed individuals, the lesser swear words, or mild violence. |
| `r`   | may contain such things as harsh profanity, intense violence, nudity, or hard drug use.                 |
| `x`   | may contain hardcore sexual imagery or extremely disturbing violence.                                   | 

The content rating can be changed by changing the `$rating` argument when calling `Gravatar::src` or `Gravatar::image`.
