<?php namespace Arcanedev\Gravatar\Exceptions;

use InvalidArgumentException;

/**
 * Class     InvalidImageUrlException
 *
 * @package  Arcanedev\Gravatar\Exceptions
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class InvalidImageUrlException extends InvalidArgumentException
{
    public static function make($image)
    {
        return new static(
            "The default image specified is not a recognized gravatar `default` and is not a valid URL: `{$image}`"
        );
    }
}
