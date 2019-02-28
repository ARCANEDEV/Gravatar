<?php namespace Arcanedev\Gravatar\Exceptions;

/**
 * Class     InvalidProfileFormatException
 *
 * @package  Arcanedev\Gravatar\Exceptions
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class InvalidProfileFormatException extends \InvalidArgumentException
{
    /**
     * Make a new exception.
     *
     * @param  string  $format
     * @param  array   $supportedFormat
     *
     * @return \Arcanedev\Gravatar\Exceptions\InvalidProfileFormatException
     */
    public static function make($format, array $supportedFormat)
    {
        return new static(
            sprintf(
                'The format [%s] is invalid, the supported formats are: %s',
                $format,
                implode(', ', $supportedFormat)
            )
        );
    }
}
