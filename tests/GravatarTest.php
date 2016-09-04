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
    /** @var \Arcanedev\Gravatar\Gravatar */
    private $gravatar;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->gravatar = $this->app->make('arcanedev.gravatar');
    }

    public function tearDown()
    {
        unset($this->gravatar);

        parent::tearDown();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_be_instantiated()
    {
        $this->assertGravatarInstance($this->gravatar);

        // By a helper function
        $this->assertGravatarInstance(gravatar());

        // By a Contract
        $this->assertGravatarInstance(
            $this->app->make(\Arcanedev\Gravatar\Contracts\Gravatar::class)
        );
    }

    /** @test */
    public function it_can_set_and_get_image_size()
    {
        $mix = 0;
        $max = 512;

        foreach (range($mix, $max) as $size) {
            $this->gravatar->setSize($size);

            $this->assertSame($size, $this->gravatar->getSize());
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

    /**
     * @test
     *
     * @expectedException        \Arcanedev\Gravatar\Exceptions\InvalidImageRatingException
     * @expectedExceptionMessage Invalid rating 'mature' specified, only 'g', 'pg', 'r' or 'x' are supported.
     */
    public function it_must_throw_an_invalid_rating_exception()
    {
        $this->gravatar->setRating('mature');
    }

    /**
     * @test
     *
     * @expectedException        \Arcanedev\Gravatar\Exceptions\InvalidImageUrlException
     * @expectedExceptionMessage The default image specified is not a recognized gravatar "default" and is not a valid URL
     */
    public function it_must_throw_invalid_image_url_on_setting_default_image()
    {
        new Gravatar('hello.com/img.png');
    }

    /** @test */
    public function it_can_set_and_get_default_image_url()
    {
        $this->gravatar = new Gravatar('http://www.hello.com/img.png');

        $this->assertSame(
            "https://secure.gravatar.com/avatar/00000000000000000000000000000000?s=80&r=g&d=http%3A%2F%2Fwww.hello.com%2Fimg.png&f=y",
            $this->gravatar->get('')
        );

        $hashed = md5($this->email);

        $this->assertSame(
            "https://secure.gravatar.com/avatar/$hashed?s=80&r=g&d=http%3A%2F%2Fwww.hello.com%2Fimg.png",
            $this->gravatar->get($this->email)
        );
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
            $this->assertSame(
                $expected, $this->gravatar->hashEmail($email)
            );
        }
    }

    /** @test */
    public function it_can_get_gravatar_secure_url()
    {
        $pattern = '/^http(s?):\/\/secure.gravatar.com\/avatar\/[0-9a-z]{32}\?s=80&r=g&d=identicon$/';

        $emails = [
            $this->email,
            'ARCANEDEV.Maroc@gmail.com',
            '  ARCANEDEV.Maroc@gmail.com',
            'ARCANEDEV.Maroc@gmail.com   ',
            '  ARCANEDEV.Maroc@gmail.com   ',
        ];

        foreach($emails as $email) {
            $url = $this->gravatar->get($email);

            $this->assertSame(1, preg_match($pattern, $url));
        }
    }

    /** @test */
    public function it_can_get_gravatar_url_on_empty_email()
    {
        $expected = 'https://secure.gravatar.com/avatar/00000000000000000000000000000000?s=80&r=g&d=identicon&f=y';

        $this->assertSame($expected, $this->gravatar->get(''));
        $this->assertSame($expected, $this->gravatar->get('', false));
    }

    /** @test */
    public function it_can_get_gravatar_src_url()
    {
        $hashed = md5($this->email);

        $this->assertSame(
            "https://secure.gravatar.com/avatar/$hashed?s=80&r=g&d=identicon",
            $this->gravatar->src($this->email)
        );

        $size   = 128;

        $this->assertSame(
            "https://secure.gravatar.com/avatar/$hashed?s=$size&r=g&d=identicon",
            $this->gravatar->src($this->email, $size)
        );

        $rating = 'r';

        $this->assertSame(
            "https://secure.gravatar.com/avatar/$hashed?s=$size&r=$rating&d=identicon",
            $this->gravatar->src($this->email, $size, $rating)
        );
    }

    /** @test */
    public function it_can_get_gravatar_image_tag()
    {
        $hashed = md5($this->email);

        $this->assertSame(
            "<img src=\"https://secure.gravatar.com/avatar/$hashed?s=80&r=g&d=identicon\">",
            $this->gravatar->image($this->email)
        );

        $alt = 'ARCANEDEV';

        $this->assertSame(
            "<img src=\"https://secure.gravatar.com/avatar/$hashed?s=80&r=g&d=identicon\" alt=\"$alt\">",
            $this->gravatar->image($this->email, $alt)
        );

        $this->assertSame(
            "<img src=\"https://secure.gravatar.com/avatar/$hashed?s=80&r=g&d=identicon\" class=\"img-responsive\" alt=\"$alt\">",
            $this->gravatar->image($this->email, $alt, ['class'  => 'img-responsive'])
        );
    }

    /** @test */
    public function it_can_check_if_email_has_a_gravatar()
    {
        $this->assertTrue($this->gravatar->exists($this->email));

        $this->assertFalse($this->gravatar->exists('not-real@email.com'));
    }

    /** @test */
    public function it_can_set_false_to_default_image()
    {
        $this->gravatar = new Gravatar(false);

        $this->assertSame(
            'https://secure.gravatar.com/avatar/00000000000000000000000000000000?s=80&r=g&f=y',
            $this->gravatar->get('')
        );
    }

    /** @test */
    public function it_can_set_size_from_height_or_width_attributes()
    {
        $this->gravatar->image('', null, ['width' => 32]);

        $this->assertSame(32, $this->gravatar->getSize());

        $this->gravatar->image('', null, ['height' => 64]);

        $this->assertSame(64, $this->gravatar->getSize());

        $this->gravatar->image('', null, ['width' => 64, 'height' => 128]);

        $this->assertSame(128, $this->gravatar->getSize());

        $this->gravatar->image('', null, ['width' => 256, 'height' => 128]);

        $this->assertSame(256, $this->gravatar->getSize());
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Assert the gravatar instance.
     *
     * @param  \Arcanedev\Gravatar\Contracts\Gravatar  $gravatar
     */
    public function assertGravatarInstance($gravatar)
    {
        $this->assertInstanceOf(\Arcanedev\Gravatar\Gravatar::class, $gravatar);
        $this->assertSame('g', $gravatar->getRating());
        $this->assertSame(80, $gravatar->getSize());
        $this->assertTrue($gravatar->isSecured());
    }
}
