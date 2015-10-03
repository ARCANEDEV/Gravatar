<?php namespace Arcanedev\Gravatar;

use Arcanedev\Gravatar\Contracts\GravatarInterface;
use Arcanedev\Gravatar\Exceptions\InvalidImageRatingException;
use Arcanedev\Gravatar\Exceptions\InvalidImageSizeException;
use Arcanedev\Gravatar\Exceptions\InvalidImageUrlException;
use Arcanedev\Gravatar\Helpers\HtmlBuilder;

/**
 * Class     Gravatar
 *
 * @package  Arcanedev\Gravatar
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Gravatar implements GravatarInterface
{
    /* ------------------------------------------------------------------------------------------------
     |  Constants
     | ------------------------------------------------------------------------------------------------
     */
    const BASE_URL   = 'http://www.gravatar.com/avatar/';
    const SECURE_URL = 'https://secure.gravatar.com/avatar/';

    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The default image to use (gravatar-recognized type, url or false = default gravatar image)
     *
     * @var mixed
     */
    protected $defaultImage = false;

    /**
     * The maximum rating to allow for the avatar.
     *
     * @var string
     */
    protected $rating       = 'g';

    /**
     * The avatar default size.
     *
     * @var int
     */
    private $defaultSize    = 80;

    /**
     * The avatar size.
     *
     * @var int
     */
    protected $size         = 80;

    /**
     * Should we use the secure (HTTPS) URL base ?
     *
     * @var bool
     */
    protected $secure       = false;

    /**
     * A temporary internal cache of the URL parameters.
     *
     * @var string
     */
    protected $cachedParams  = null;

    /**
     * Supported image defaults.
     *
     * @var array
     */
    private $supportedImages    = [
        '404',        // Do not load any image if none is associated with the email hash,
                      // instead return an HTTP 404 response
        'mm',         // (mystery-man) a simple, cartoon-style silhouetted outline of a person.
        'identicon',  // a geometric pattern based on an email hash
        'monsterid',  // a generated 'monster' with different colors, faces, etc
        'wavatar',    // generated faces with differing features and backgrounds
        'retro',      // awesome generated, 8-bit arcade-style pixelated faces
        // 'blank',
    ];

    /**
     * Supported image ratings.
     *
     * @var array
     */
    private $supportedRatings   = [
        'g',   // suitable for display on all websites with any audience type.
        'pg',  // may contain rude gestures, provocatively dressed individuals, the lesser swear words, or mild violence.
        'r',   // may contain such things as harsh profanity, intense violence, nudity, or hard drug use.
        'x'    // may contain hardcore sexual imagery or extremely disturbing violence.
    ];

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Make a gravatar instance.
     *
     * @param  string  $default
     * @param  int     $defaultSize
     * @param  string  $rating
     */
    public function __construct($default = 'mm', $defaultSize = 80, $rating = 'g')
    {
        $this->setDefaultImage($default);
        $this->defaultSize = $defaultSize;
        $this->setRating($rating);

        $this->enableSecure();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
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
     * @return self
     *
     * @throws \Arcanedev\Gravatar\Exceptions\InvalidImageUrlException
     */
    public function setDefaultImage($image)
    {
        if ($image === false) {
            $this->defaultImage = $image;

            return $this;
        }

        $this->cachedParams = null;

        if (in_array(strtolower($image), $this->supportedImages)) {
            $image = strtolower($image);
        }
        else {
            $this->checkImageUrl($image);
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
     * @return self
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
     * @return self
     *
     * @throws \Arcanedev\Gravatar\Exceptions\InvalidImageRatingException
     */
    public function setRating($rating)
    {
        $this->cachedParams = null;
        $this->checkRating($rating);

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
    public function src($email, $size = null, $rating = null)
    {
        if (is_null($size)) {
            $size = $this->defaultSize;
        }

        $size = max(1, min(512, $size));

        $this->setSize($size);

        if ( ! is_null($rating)) {
            $this->setRating($rating);
        }

        return $this->get($email); // htmlentities($this->get($email));
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
        $url .= $this->getEmail($email, $hash);

        if (is_null($this->cachedParams)) {
            $params   = [
                's' => $this->getSize(),
                'r' => $this->getRating()
            ];

            if ($this->getDefaultImage() !== false) {
                $params['d'] = $this->getDefaultImage();
            }

            $this->cachedParams = '?' . http_build_query($params);
        }

        return $url . $this->cachedParams . $this->getForceDefault($email);
    }

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
    public function image($email, $alt = null, $attributes = [], $rating = null)
    {
        $dimensions = $this->getDimensions($attributes);

        $src = $this->src($email, $dimensions, $rating);

        return HtmlBuilder::image($src, $alt, $attributes);
    }

    /**
     * Enable the use of the secure protocol for image URLs.
     *
     * @return self
     */
    public function enableSecure()
    {
        $this->secure = true;

        return $this;
    }

    /**
     * Disable the use of the secure protocol for image URLs.
     *
     * @return self
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

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check the avatar size.
     *
     * @param  int  $size
     *
     * @throws \Arcanedev\Gravatar\Exceptions\InvalidImageSizeException
     */
    private function checkSize(&$size)
    {
        $this->checkSizeType($size);

        if ($size < 0 || $size > 512) {
            throw new InvalidImageSizeException(
                'Avatar size must be within 0 pixels and 512 pixels.'
            );
        }
    }

    /**
     * Check size type.
     *
     * @param  int  $size
     *
     * @throws \Arcanedev\Gravatar\Exceptions\InvalidImageSizeException
     */
    private function checkSizeType(&$size)
    {
        if ( ! is_int($size) && ! ctype_digit($size)) {
            throw new InvalidImageSizeException(
                'Avatar size specified must be an integer.'
            );
        }

        $size = (int) $size;
    }

    /**
     * Check image url.
     *
     * @param  string  $image
     *
     * @throws \Arcanedev\Gravatar\Exceptions\InvalidImageUrlException
     */
    private function checkImageUrl($image)
    {
        if ( ! filter_var($image, FILTER_VALIDATE_URL)) {
            throw new InvalidImageUrlException(
                'The default image specified is not a recognized gravatar "default" and is not a valid URL'
            );
        }
    }

    /**
     * Check the rating.
     *
     * @param  string  $rating
     *
     * @throws \Arcanedev\Gravatar\Exceptions\InvalidImageRatingException
     */
    private function checkRating(&$rating)
    {
        $rating = strtolower($rating);

        if ( ! in_array($rating, $this->supportedRatings)) {
            throw new InvalidImageRatingException(
                "Invalid rating '$rating' specified, only 'g', 'pg', 'r' or 'x' are supported."
            );
        }
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get email for gravatar url.
     *
     * @param  string  $email
     * @param  bool    $hash
     *
     * @return string
     */
    private function getEmail($email, $hash = true)
    {
        if (empty($email)) {
            return str_repeat('0', 32);
        }

        return $hash ? $this->hashEmail($email) : $email;
    }

    /**
     * Get dimensions from attributes.
     *
     * @param  array  $attributes
     *
     * @return int|null
     */
    private function getDimensions(array $attributes)
    {
        $dimensions = [];

        if (array_key_exists('width', $attributes)) {
            $dimensions[] = $attributes['width'];
        }

        if (array_key_exists('height', $attributes)) {
            $dimensions[] = $attributes['height'];
        }

        return count($dimensions) ? min(512, max($dimensions)) : $this->defaultSize;
    }

    /**
     * Get force default tail.
     *
     * @param  string  $email
     *
     * @return string
     */
    private function getForceDefault($email)
    {
        if ( ! empty($email)) {
            return '';
        }

        return ! empty($this->cachedParams) ? '&f=y' : '?f=y';
    }
}
