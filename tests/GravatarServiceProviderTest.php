<?php namespace Arcanedev\Gravatar\Tests;

use Arcanedev\Gravatar\GravatarServiceProvider;

/**
 * Class     GravatarServiceProviderTest
 *
 * @package  Arcanedev\Gravatar\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class GravatarServiceProviderTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var GravatarServiceProvider */
    private $provider;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->provider = $this->app->getProvider(GravatarServiceProvider::class);
    }

    public function tearDown()
    {
        unset($this->provider);

        parent::tearDown();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_be_instantiated()
    {
        $expectations = [
            \Illuminate\Support\ServiceProvider::class,
            \Arcanedev\Support\ServiceProvider::class,
            \Arcanedev\Support\PackageServiceProvider::class,
            \Arcanedev\Gravatar\GravatarServiceProvider::class,
        ];

        foreach ($expectations as $expected) {
            $this->assertInstanceOf($expected, $this->provider);
        }
    }

    /** @test */
    public function it_can_provides()
    {
        $expected = [
            'arcanedev.gravatar',
            \Arcanedev\Gravatar\Contracts\Gravatar::class,
        ];

        $this->assertEquals($expected, $this->provider->provides());
    }
}
