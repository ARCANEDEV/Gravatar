<?php namespace Arcanedev\Gravatar\Tests;

use Arcanedev\Gravatar\Profile;

/**
 * Class     ProfileTest
 *
 * @package  Arcanedev\Gravatar\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class ProfileTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Arcanedev\Gravatar\Profile */
    protected $profile;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    public function setUp()
    {
        parent::setUp();

        $this->profile = new Profile;
    }

    protected function tearDown()
    {
        unset($this->profile);

        parent::tearDown();
    }

    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_can_set_and_get_format()
    {
        static::assertNull($this->profile->getFormat());

        foreach (['json', 'xml', 'php', 'vcf', 'qr'] as $expected) {
            $this->profile->setFormat($expected);

            static::assertSame($expected, $this->profile->getFormat());
        }
    }

    /** @test */
    public function it_can_get_url()
    {
        static::assertSame(
            'https://www.gravatar.com/00000000000000000000000000000000',
            $this->profile->getUrl()
        );

        static::assertSame(
            'https://www.gravatar.com/cb8419c1d471d55fbca0d63d1fb2b6ac',
            $this->profile->getUrl('hello@example.com')
        );

        static::assertSame(
            'https://www.gravatar.com/cb8419c1d471d55fbca0d63d1fb2b6ac.json?callback=sayHello',
            $this->profile->setFormat('json')->getUrl('hello@example.com', ['callback' => 'sayHello'])
        );
    }

    /** @test */
    public function it_can_switch_to_unsecured_url()
    {
        static::assertSame(
            'http://www.gravatar.com/cb8419c1d471d55fbca0d63d1fb2b6ac',
            $this->profile->getUrl('hello@example.com', [], false)
        );
    }

    /**
     * @test
     *
     * @expectedException         \Arcanedev\Gravatar\Exceptions\InvalidProfileFormatException
     * @expectedExceptionMessage  The format [csv] is invalid, the supported formats are: json, xml, php, vcf, qr
     */
    public function it_must_throw_an_exception_on_invalid_format()
    {
        $this->profile->setFormat('csv');
    }
}
