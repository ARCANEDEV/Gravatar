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
