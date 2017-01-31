<?php namespace Arcanedev\Gravatar;

use Arcanedev\Support\PackageServiceProvider as ServiceProvider;

/**
 * Class     GravatarServiceProvider
 *
 * @package  Arcanedev\Gravatar
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class GravatarServiceProvider extends ServiceProvider
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Package name.
     *
     * @var string
     */
    protected $package = 'gravatar';

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer   = true;

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the base path of the package.
     *
     * @return string
     */
    public function getBasePath()
    {
        return dirname(__DIR__);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerConfig();
        $this->registerGravatar();
    }

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->publishConfig();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            Contracts\Gravatar::class,
        ];
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register Gravatar Helper.
     */
    private function registerGravatar()
    {
        $this->singleton(Contracts\Gravatar::class, function($app) {
            /** @var \Illuminate\Config\Repository $config */
            $config = $app['config'];

            return new Gravatar(
                $config->get('gravatar.default', 'mm'),
                $config->get('gravatar.size', 80),
                $config->get('gravatar.max-rating', 'g')
            );
        });
    }
}
