<?php

if ( ! function_exists('gravatar')) {
    /**
     * Get the gravatar instance.
     *
     * @return Arcanedev\Gravatar\Contracts\Gravatar
     */
    function gravatar()
    {
        return app(Arcanedev\Gravatar\Contracts\Gravatar::class);
    }
}

if ( ! function_exists('is_val_integer')) {
    /**
     * Check if value is integer.
     *
     * @param  mixed  $value
     *
     * @return bool
     */
    function is_val_integer($value)
    {
        return is_int($value) || ctype_digit($value);
    }
}

if ( ! function_exists('is_int_not_between')) {
    /**
     * Check if an integer is between two values.
     *
     * @param  int         $needle
     * @param  int         $min
     * @param  int         $max
     *
     * @return bool
     */
    function is_int_not_between($needle, $min, $max)
    {
        return $needle < $min  || $needle >  $max;
    }
}
