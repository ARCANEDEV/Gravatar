<?php

declare(strict_types=1);

namespace Arcanedev\Gravatar;

use Arcanedev\Gravatar\Exceptions\InvalidProfileFormatException;

/**
 * Class     Profile
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Profile
{
    /* -----------------------------------------------------------------
     |  Traits
     | -----------------------------------------------------------------
     */

    use Concerns\HashEmail;

    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    const BASE_URL   = 'http://www.gravatar.com/';
    const SECURE_URL = 'https://www.gravatar.com/';

    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * Profile's format.
     *
     * @var string
     */
    protected $format;

    /**
     * Supported format.
     *
     * @var array
     */
    protected static $supportedFormat = ['json', 'xml', 'php', 'vcf', 'qr'];

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Get the profile's format.
     *
     * @return string|null
     */
    public function getFormat(): ?string
    {
        return $this->format;
    }

    /**
     * Set the profile's format.
     *
     * @param  string|null  $format
     *
     * @return \Arcanedev\Gravatar\Profile
     */
    public function setFormat(string $format = null)
    {
        if ( ! is_null($format)) {
            self::checkFormat($format);
            $this->format = $format;
        }

        return $this;
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Build the profile URL based on the provided email address.
     *
     * @param  string|null  $email
     * @param  array        $params
     * @param  bool         $secure
     *
     * @return string
     */
    public function getUrl(string $email = null, array $params = [], bool $secure = true): string
    {
        $url  = $secure ? static::SECURE_URL : static::BASE_URL;
        $url .= is_null($email)
            ? str_repeat('0', 32)
            : static::hashEmail($email);

        if ($this->hasFormat())
            $url .= ".{$this->getFormat()}";

        if ( ! empty($params))
            $url .= '?'.http_build_query($params);

        return $url;
    }

    /**
     * Get the profile data.
     *
     * @param  string      $email
     * @param  mixed|null  $default
     *
     * @return array|mixed
     */
    public function get(string $email, $default = null)
    {
        $this->setFormat('php');

        $data = unserialize(
            file_get_contents($this->getUrl($email))
        );

        return (is_array($data) && isset($data['entry']))
            ? $data
            : $default;
    }

    /* -----------------------------------------------------------------
     |  Check Methods
     | -----------------------------------------------------------------
     */

    /**
     * Check if the format is not null.
     *
     * @return bool
     */
    public function hasFormat(): bool
    {
        return ! is_null($this->format);
    }

    /**
     * Check the format.
     *
     * @param  string  $format
     */
    private static function checkFormat(string &$format): void
    {
        $format = strtolower($format);

        if ( ! in_array($format, static::$supportedFormat)) {
            throw InvalidProfileFormatException::make($format, static::$supportedFormat);
        }
    }
}
