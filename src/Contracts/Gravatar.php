<?php

declare(strict_types=1);

namespace Arcanedev\Gravatar\Contracts;

/**
 * Interface  Gravatar
 *
 * @author    ARCANEDEV <arcanedev.maroc@gmail.com>
 */
interface Gravatar
{
    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
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
     * @return $this
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
     * @param  int  $size - The avatar size to use, must be less than 512 and greater than 0.
     *
     * @return $this
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
     * @return $this
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

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
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
     * @return \Arcanedev\Html\Elements\Img
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
     * @return $this
     */
    public function enableSecure();

    /**
     * Disable the use of the secure protocol for image URLs.
     *
     * @return $this
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
    public static function hashEmail(string $email): string;
}
