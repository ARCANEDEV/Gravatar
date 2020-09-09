<?php

declare(strict_types=1);

namespace Arcanedev\Gravatar\Tests;

use Arcanedev\Gravatar\GravatarServiceProvider;

/**
 * Class     GravatarServiceProviderTest
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class GravatarServiceProviderTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Arcanedev\Gravatar\GravatarServiceProvider */
    private $provider;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    public function setUp(): void
    {
        parent::setUp();

        $this->provider = $this->app->getProvider(GravatarServiceProvider::class);
    }

    public function tearDown(): void
    {
        unset($this->provider);

        parent::tearDown();
    }

    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_can_be_instantiated(): void
    {
        $expectations = [
            \Illuminate\Support\ServiceProvider::class,
            \Illuminate\Contracts\Support\DeferrableProvider::class,
            \Arcanedev\Support\Providers\ServiceProvider::class,
            \Arcanedev\Support\Providers\PackageServiceProvider::class,
            \Arcanedev\Gravatar\GravatarServiceProvider::class,
        ];

        foreach ($expectations as $expected) {
            static::assertInstanceOf($expected, $this->provider);
        }
    }

    /** @test */
    public function it_can_provides(): void
    {
        $expected = [
            \Arcanedev\Gravatar\Contracts\Gravatar::class,
        ];

        static::assertSame($expected, $this->provider->provides());
    }
}
