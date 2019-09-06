# 4. Usage

## Table of contents

  1. [Installation and Setup](1-Installation-and-Setup.md)
  2. [Configuration](2-Configuration.md)
  3. [Usage](3-Usage.md)
     * [Hard coded](#hard-coded)
     * [Laravel](#laravel)
     * [API](#api)

### Hard coded

We start by creating a gravatar instance:

```php
<?php

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
<?php

echo $gravatar->get('your@email.com');

// or

echo $gravatar->src('your@email.com');
echo $gravatar->src('your@email.com', 512);
echo $gravatar->src('your@email.com', 512, 'g');
```

You can check if the email has a gravatar:

```php
<?php

if ($gravatar->exists('your@email.com')) {
    echo 'Nice avatar';
}
else {
    echo 'Faceless';
}
```

And last but not least, if you want to echo out the image:

```php
echo $gravatar->image('your@email.com')->toHtml();
echo $gravatar->image('your@email.com', 'Username')->toHtml();
echo $gravatar->image('your@email.com', 'Username', ['class' => 'img-responsive'])->toHtml();
echo $gravatar->image('your@email.com', 'Username', ['class' => 'img-responsive'], 'pg')->toHtml();
```

### Laravel

#### gravatar()->exists($email)

Returns a boolean telling if has a gravatar of the given `$email`.

#### gravatar()->src($email, $size = null, $rating = null)

Returns the https URL for the Gravatar of the specified email address.

Can optionally pass in the size required as an integer (range between 1 - 512). 

```html
<!-- Show image with default dimensions -->
<img src="{{ gravatar()->src('your@email.com') }}">

<!-- Show image at 256px -->
<img src="{{ gravatar()->src('your@email.com', 256) }}">
```

#### gravatar()->image($email, $alt = null, $attributes = [], $rating = null)

Returns the HTML for an `<img>` tag

```php
<?php

// Show image with default dimensions
echo gravatar()->image('your@email.com');

// Adding attributes
echo gravatar()->image('your@email.com', 'Your username', ['class' => 'img-responsive']);

// Or
echo gravatar()->image('your@email.com', 'Your username', ['width' => 200, 'height' => 200]);
```

 > For the blade engine use `{!! ... !!}` to echo out the images.

### API

This is the list of all available gravatar methods:

```php
/* ------------------------------------------------------------------------------------------------
 |  Getters & Setters
 | ------------------------------------------------------------------------------------------------
 */
/**
 * Get the current default image setting.
 *
 * @return string|false
 */
public function getDefaultImage();

/**
 * Set the default image to use for avatars.
 *
 * @param  string|false  $image
 *
 * @return self
 *
 * @throws \Arcanedev\Gravatar\Exceptions\InvalidImageUrlException
 */
public function setDefaultImage($image);

/**
 * Get the currently set avatar size.
 *
 * @return int
 */
public function getSize();

/**
 * Set the avatar size to use.
 *
 * @param integer $size - The avatar size to use, must be less than 512 and greater than 0.
 *
 * @return self
 *
 * @throws \Arcanedev\Gravatar\Exceptions\InvalidImageSizeException
 */
public function setSize($size);

/**
 * Get the current maximum allowed rating for avatars.
 *
 * @return string
 */
public function getRating();

/**
 * Set the maximum allowed rating for avatars.
 *
 * @param  string  $rating
 *
 * @return self
 *
 * @throws \Arcanedev\Gravatar\Exceptions\InvalidImageRatingException
 */
public function setRating($rating);

/**
 * Check if we are using the secure protocol for the image URLs.
 *
 * @return bool
 */
public function isSecured();

/* ------------------------------------------------------------------------------------------------
 |  Main Functions
 | ------------------------------------------------------------------------------------------------
 */
/**
 * Get Gravatar image source.
 *
 * @param  string       $email
 * @param  int|null     $size
 * @param  string|null  $rating
 *
 * @return string
 */
public function src($email, $size = null, $rating = null);

/**
 * Get the avatar URL based on the provided email address.
 *
 * @param  string  $email
 * @param  bool    $hash
 *
 * @return string
 */
public function get($email, $hash = true);

/**
 * Get Gravatar image tag.
 *
 * @param  string       $email
 * @param  string|null  $alt
 * @param  array        $attributes
 * @param  string|null  $rating
 *
 * @return string
 */
public function image($email, $alt = null, array $attributes = [], $rating = null);

/**
 * Get profile's data.
 *
 * @param  string      $email
 * @param  mixed|null  $default
 *
 * @return array|mixed
 */
public function profile($email, $default = null);

/**
 * Enable the use of the secure protocol for image URLs.
 *
 * @return self
 */
public function enableSecure();

/**
 * Disable the use of the secure protocol for image URLs.
 *
 * @return self
 */
public function disableSecure();

/**
 * Check if email has a gravatar.
 *
 * @param  string  $email
 *
 * @return bool
 */
public function exists($email);

/**
 * Get a hashed email.
 *
 * @param  string  $email
 *
 * @return string
 */
public function hashEmail($email);
```
