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

        $this->provider = new GravatarServiceProvider($this->app);
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->provider);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_get_what_it_provides()
    {
        $this->assertEquals(
            ['arcanedev.gravatar'],
            $this->provider->provides()
        );
    }
}
