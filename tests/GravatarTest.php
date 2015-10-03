<?php namespace Arcanedev\Gravatar\Tests;

use Arcanedev\Gravatar\Gravatar;

/**
 * Class     GravatarTest
 *
 * @package  Arcanedev\Gravatar\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class GravatarTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var Gravatar */
    private $gravatar;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->gravatar = $this->app['arcanedev.gravatar'];
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->gravatar);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_be_instantiated()
    {
        $this->assertInstanceOf(Gravatar::class, $this->gravatar);
        $this->assertEquals('g', $this->gravatar->getRating());
        $this->assertEquals(80, $this->gravatar->getSize());
        $this->assertTrue($this->gravatar->isSecured());
    }

    /** @test */
    public function it_can_set_and_get_image_size()
    {
        $mix = 0;
        $max = 512;

        foreach (range($mix, $max) as $size) {
            $this->gravatar->setSize($size);

            $this->assertEquals($size, $this->gravatar->getSize());
        }
    }

    /**
     * @test
     *
     * @expectedException        \Arcanedev\Gravatar\Exceptions\InvalidImageSizeException
     * @expectedExceptionMessage Avatar size specified must be an integer.
     */
    public function it_must_throw_an_invalid_image_size_exception_on_type()
    {
        $this->gravatar->setSize('xl');
    }

    /**
     * @test
     *
     * @expectedException        \Arcanedev\Gravatar\Exceptions\InvalidImageSizeException
     * @expectedExceptionMessage Avatar size must be within 0 pixels and 512 pixels.
     */
    public function it_must_throw_an_invalid_image_size_exception_on_min_and_max()
    {
        $this->gravatar->setSize(513);
    }

    /** @test */
    public function it_can_disable_and_enable_the_secure_url()
    {
        $this->assertTrue($this->gravatar->isSecured());

        $this->gravatar->disableSecure();

        $this->assertFalse($this->gravatar->isSecured());

        $this->gravatar->enableSecure();

        $this->assertTrue($this->gravatar->isSecured());
    }

    /** @test */
    public function it_can_hash_email()
    {
        $emails = [
            $this->email,
            'ARCANEDEV.Maroc@gmail.com',
            '  ARCANEDEV.Maroc@gmail.com',
            'ARCANEDEV.Maroc@gmail.com   ',
            '  ARCANEDEV.Maroc@gmail.com   ',
        ];

        $expected = md5($this->email);

        foreach ($emails as $email) {
            $this->assertEquals(
                $expected, $this->gravatar->hashEmail($email)
            );
        }
    }

    /** @test */
    public function it_can_check_if_email_has_a_gravatar()
    {
        $this->assertTrue($this->gravatar->exists($this->email));

        $this->assertFalse($this->gravatar->exists('not-real@email.com'));
    }
}
