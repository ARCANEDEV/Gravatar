<?php

declare(strict_types=1);

namespace Arcanedev\Gravatar\Exceptions;

use InvalidArgumentException;

/**
 * Class     InvalidImageRatingException
 *
 * @package  Arcanedev\Gravatar\Exceptions
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class InvalidImageRatingException extends InvalidArgumentException
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * @param  string  $rating
     *
     * @return static
     */
    public static function make(string $rating)
    {
        return new static(
            "Invalid rating '{$rating}' specified, only 'g', 'pg', 'r' or 'x' are supported."
        );
    }
}
