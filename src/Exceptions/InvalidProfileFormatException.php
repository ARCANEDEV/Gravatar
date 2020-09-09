<?php

declare(strict_types=1);

namespace Arcanedev\Gravatar\Exceptions;

use InvalidArgumentException;

/**
 * Class     InvalidProfileFormatException
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class InvalidProfileFormatException extends InvalidArgumentException
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Make a new exception.
     *
     * @param  string  $format
     * @param  array   $supportedFormat
     *
     * @return \Arcanedev\Gravatar\Exceptions\InvalidProfileFormatException
     */
    public static function make(string $format, array $supportedFormat)
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
