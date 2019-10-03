<?php namespace Arcanedev\Gravatar;

use Arcanedev\Support\Providers\PackageServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

/**
 * Class     GravatarServiceProvider
 *
 * @package  Arcanedev\Gravatar
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class GravatarServiceProvider extends PackageServiceProvider implements DeferrableProvider
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * Package name.
     *
     * @var string
     */
    protected $package = 'gravatar';

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        parent::register();

        $this->registerConfig();

        $this->singleton(Contracts\Gravatar::class, function($app) {
            return new Gravatar(
                $app['config']->get('gravatar.default', 'mm'),
                $app['config']->get('gravatar.size', 80),
                $app['config']->get('gravatar.max-rating', 'g')
            );
        });
    }

    /**
     * Boot the service provider.
     */
    public function boot(): void
    {
        $this->publishConfig();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [
            Contracts\Gravatar::class,
        ];
    }
}
