<?php

use Arcanedev\Gravatar\Contracts\Gravatar;

if ( ! function_exists('gravatar')) {
    /**
     * Get the gravatar instance.
     *
     * @return Arcanedev\Gravatar\Contracts\Gravatar
     */
    function gravatar(): Gravatar
    {
        return app(Gravatar::class);
    }
}
