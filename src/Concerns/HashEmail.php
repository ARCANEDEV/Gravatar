<?php

declare(strict_types=1);

namespace Arcanedev\Gravatar\Concerns;

/**
 * Trait     HashEmail
 *
 * @package  Arcanedev\Gravatar\Concerns
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
trait HashEmail
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get a hashed email.
     *
     * @param  string  $email
     *
     * @return string
     */
    public static function hashEmail(string $email): string
    {
        return hash('md5', strtolower(trim($email)));
    }
}
