<?php

declare(strict_types=1);

namespace Arcanedev\Gravatar\Helpers;

/**
 * Class     NumberChecker
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class NumberChecker
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Check if an integer is between two values.
     *
     * @param  int  $value
     * @param  int  $min
     * @param  int  $max
     *
     * @return bool
     */
    public static function isIntBetween(int $value, int $min, int $max): bool
    {
        return $value >= $min && $value <= $max;
    }

    /**
     * Check if value is integer.
     *
     * @param  mixed  $value
     *
     * @return bool
     */
    public static function isIntValue($value): bool
    {
        return is_int($value) || ctype_digit($value);
    }
}
