<?php namespace Arcanedev\Gravatar\Facades;

use Arcanedev\Gravatar\Contracts\Gravatar as GravatarContract;
use Illuminate\Support\Facades\Facade;

/**
 * Class     Gravatar
 *
 * @package  Arcanedev\Gravatar\Facades
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Gravatar extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return GravatarContract::class; }
}
