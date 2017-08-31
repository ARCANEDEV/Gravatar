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
