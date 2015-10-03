<?php

if ( ! function_exists('gravatar')) {
    /**
     * Get the gravatar instance.
     *
     * @return \Arcanedev\Gravatar\Gravatar
     */
    function gravatar() {
        return app('arcanedev.gravatar');
    }
}

if ( ! function_exists('max_dimension')) {
    /**
     * Get max dimension from width or height attributes.
     *
     * @param  array  $attributes
     * @param  int    $default
     *
     * @return int|null
     */
    function get_max_dimension($attributes, $default) {
        $dimensions = [];

        if (array_key_exists('width', $attributes)) {
            $dimensions[] = $attributes['width'];
        }

        if (array_key_exists('height', $attributes)) {
            $dimensions[] = $attributes['height'];
        }

        return count($dimensions) ? min(512, max($dimensions)) : $default;
    }
}