<?php namespace Arcanedev\Gravatar;

use Arcanedev\Gravatar\Helpers\NumberChecker;
use Arcanedev\Html\Elements\Img;
use Illuminate\Support\Arr;

/**
 * Class     Gravatar
 *
 * @package  Arcanedev\Gravatar
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Gravatar implements Contracts\Gravatar
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    const BASE_URL   = 'http://www.gravatar.com/avatar/';
    const SECURE_URL = 'https://secure.gravatar.com/avatar/';

    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The default image to use (gravatar-recognized type, url or false = default gravatar image)
     *
     * @var mixed
     */
    protected $defaultImage     = false;

    /**
     * The maximum rating to allow for the avatar.
     *
     * @var string
     */
    protected $rating           = 'g';

    /**
     * The avatar size.
     *
     * @var int
     */
    protected $size             = 80;

    /**
     * Should we use the secure (HTTPS) URL base ?
     *
     * @var bool
     */
    protected $secure           = false;

    /**
     * A temporary internal cache of the URL parameters.
     *
     * @var array|null
     */
    protected $cachedParams     = null;

    /**
     * Supported image defaults.
     *
     * @var array
     */
    private $supportedImages    = ['404', 'mm', 'identicon', 'monsterid', 'wavatar', 'retro'];

    /**
     * Supported image ratings.
     *
     * @var array
     */
    private $supportedRatings   = ['g', 'pg', 'r', 'x'];

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * Make a gravatar instance.
     *
     * @param  string  $default
     * @param  int     $size
     * @param  string  $rating
     */
    public function __construct($default = 'mm', $size = 80, $rating = 'g')
    {
        $this->setDefaultImage($default);
        $this->setSize($size);
        $this->setRating($rating);
        $this->enableSecure();
    }

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Get the current default image setting.
     *
     * @return string|false
     */
    public function getDefaultImage()
    {
        return $this->defaultImage;
    }

    /**
     * Set the default image to use for avatars.
     *
     * @param  string|false  $image
     *
     * @return \Arcanedev\Gravatar\Gravatar
     *
     * @throws \Arcanedev\Gravatar\Exceptions\InvalidImageUrlException
     */
    public function setDefaultImage($image)
    {
        if ($image !== false) {
            $this->cachedParams = null;

            $image = in_array(strtolower($image), $this->supportedImages)
                ? strtolower($image)
                : $this->checkImageUrl($image);
        }

        $this->defaultImage = $image;

        return $this;
    }

    /**
     * Get the currently set avatar size.
     *
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set the avatar size to use.
     *
     * @param integer $size - The avatar size to use, must be less than 512 and greater than 0.
     *
     * @return \Arcanedev\Gravatar\Gravatar
     *
     * @throws \Arcanedev\Gravatar\Exceptions\InvalidImageSizeException
     */
    public function setSize($size)
    {
        $this->cachedParams = null;

        $this->checkSize($size);

        $this->size = $size;

        return $this;
    }

    /**
     * Get the current maximum allowed rating for avatars.
     *
     * @return string
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set the maximum allowed rating for avatars.
     *
     * @param  string  $rating
     *
     * @return \Arcanedev\Gravatar\Gravatar
     *
     * @throws \Arcanedev\Gravatar\Exceptions\InvalidImageRatingException
     */
    public function setRating($rating)
    {
        $this->cachedParams = null;

        $rating = strtolower($rating);

        if ( ! in_array($rating, $this->supportedRatings))
            throw Exceptions\InvalidImageRatingException::make($rating);

        $this->rating = $rating;

        return $this;
    }

    /**
     * Check if we are using the secure protocol for the image URLs.
     *
     * @return bool
     */
    public function isSecured()
    {
        return $this->secure;
    }

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
    public function src($email, $size = null, $rating = null)
    {
        if (is_null($size)) {
            $size = $this->getSize();
        }

        $size = max(1, min(512, $size));

        $this->setSize($size);

        if ( ! is_null($rating)) {
            $this->setRating($rating);
        }

        return $this->get($email);
    }

    /**
     * Get the avatar URL based on the provided email address.
     *
     * @param  string  $email
     * @param  bool    $hash
     *
     * @return string
     */
    public function get($email, $hash = true)
    {
        $url  = $this->isSecured() ? static::SECURE_URL : static::BASE_URL;
        $url .= empty($email)
            ? str_repeat('0', 32)
            : ($hash ? $this->hashEmail($email) : $email);

        $params = $this->getParams($email);

        return $url.'?'.http_build_query($params);
    }

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
    public function image($email, $alt = null, array $attributes = [], $rating = null)
    {
        $dimensions = array_values(
            Arr::only($attributes, ['width', 'height'])
        );

        $size = count($dimensions)
            ? min(512, max($dimensions))
            : $this->getSize();

        return Img::make()
                  ->src($this->src($email, $size, $rating))
                  ->attributeUnless(is_null($alt), 'alt', $alt)
                  ->attributes($attributes);
    }

    /**
     * Enable the use of the secure protocol for image URLs.
     *
     * @return \Arcanedev\Gravatar\Gravatar
     */
    public function enableSecure()
    {
        $this->secure = true;

        return $this;
    }

    /**
     * Disable the use of the secure protocol for image URLs.
     *
     * @return \Arcanedev\Gravatar\Gravatar
     */
    public function disableSecure()
    {
        $this->secure = false;

        return $this;
    }

    /**
     * Check if email has a gravatar.
     *
     * @param  string  $email
     *
     * @return bool
     */
    public function exists($email)
    {
        $this->setDefaultImage('404');

        $headers = get_headers($this->get($email), 1);

        return strpos($headers[0], '200') ? true : false;
    }

    /**
     * Get a hashed email.
     *
     * @param  string  $email
     *
     * @return string
     */
    public function hashEmail($email)
    {
        return hash('md5', strtolower(trim($email)));
    }

    /* -----------------------------------------------------------------
     |  Check Methods
     | -----------------------------------------------------------------
     */

    /**
     * Check image url.
     *
     * @param  string  $image
     *
     * @return string
     *
     * @throws \Arcanedev\Gravatar\Exceptions\InvalidImageUrlException
     */
    private function checkImageUrl($image)
    {
        if ( ! filter_var($image, FILTER_VALIDATE_URL)) {
            throw Exceptions\InvalidImageUrlException::make();
        }

        return $image;
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get params.
     *
     * @param  string  $email
     *
     * @return array
     */
    private function getParams($email)
    {
        $params = $this->cachedParams;

        if (is_null($this->cachedParams)) {
            $params['s'] = $this->getSize();
            $params['r'] = $this->getRating();

            if ($this->getDefaultImage() !== false) {
                $params['d'] = $this->getDefaultImage();
            }

            $this->cachedParams = $params;
        }

        if (empty($email)) {
            $params['f'] = 'y';
        }

        return (array) $params;
    }

    /**
     * Check the image size.
     *
     * @param  int  $size
     */
    private function checkSize(&$size)
    {
        if ( ! NumberChecker::isIntValue($size)) {
            throw new Exceptions\InvalidImageSizeException(
                'Avatar size specified must be an integer.'
            );
        }

        $size = (int) $size;

        if ( ! NumberChecker::isIntBetween($size, 0, 512)) {
            throw new Exceptions\InvalidImageSizeException(
                'Avatar size must be within 0 pixels and 512 pixels.'
            );
        }
    }
}
