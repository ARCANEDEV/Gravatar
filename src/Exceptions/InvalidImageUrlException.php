<?php

declare(strict_types=1);

namespace Arcanedev\Gravatar\Exceptions;

use InvalidArgumentException;

/**
 * Class     InvalidImageUrlException
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class InvalidImageUrlException extends InvalidArgumentException
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * @param  string  $image
     *
     * @return static
     */
    public static function make(string $image)
    {
        return new static(
            "The default image specified is not a recognized gravatar `default` and is not a valid URL: `{$image}`"
        );
    }
}
