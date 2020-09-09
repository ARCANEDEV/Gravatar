<?php

declare(strict_types=1);

namespace Arcanedev\Gravatar\Tests;

use Arcanedev\Gravatar\Exceptions\{
    InvalidImageRatingException, InvalidImageSizeException, InvalidImageUrlException
};
use Arcanedev\Gravatar\Gravatar;

/**
 * Class     GravatarTest
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class GravatarTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var \Arcanedev\Gravatar\Gravatar */
    private $gravatar;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    public function setUp(): void
    {
        parent::setUp();

        $this->gravatar = $this->app->make(\Arcanedev\Gravatar\Contracts\Gravatar::class);
    }

    public function tearDown(): void
    {
        unset($this->gravatar);

        parent::tearDown();
    }

    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_can_be_instantiated(): void
    {
        static::assertGravatarInstance($this->gravatar);

        // By a helper function
        static::assertGravatarInstance(gravatar());

        // By a Contract
        static::assertGravatarInstance(
            $this->app->make(\Arcanedev\Gravatar\Contracts\Gravatar::class)
        );
    }

    /** @test */
    public function it_can_set_and_get_image_size(): void
    {
        $mix = 0;
        $max = 512;

        foreach (range($mix, $max) as $size) {
            $this->gravatar->setSize($size);

            static::assertSame($size, $this->gravatar->getSize());
        }
    }

    /** @test */
    public function it_must_throw_an_invalid_image_size_exception_on_type(): void
    {
        $this->expectException(InvalidImageSizeException::class);
        $this->expectExceptionMessage('Avatar size specified must be an integer.');

        $this->gravatar->setSize('xl');
    }

    /** @test */
    public function it_must_throw_an_invalid_image_size_exception_on_min_and_max(): void
    {
        $this->expectException(InvalidImageSizeException::class);
        $this->expectExceptionMessage('Avatar size must be within 0 pixels and 512 pixels.');

        $this->gravatar->setSize(513);
    }

    /** @test */
    public function it_must_throw_an_invalid_rating_exception(): void
    {
        $this->expectException(InvalidImageRatingException::class);
        $this->expectExceptionMessage("Invalid rating 'mature' specified, only 'g', 'pg', 'r' or 'x' are supported.");

        $this->gravatar->setRating('mature');
    }

    /** @test */
    public function it_must_throw_invalid_image_url_when_setting_default_image(): void
    {
        $this->expectException(InvalidImageUrlException::class);
        $this->expectExceptionMessage('The default image specified is not a recognized gravatar `default` and is not a valid URL: `hello.com/img.png`');

        new Gravatar('hello.com/img.png');
    }

    /** @test */
    public function it_can_set_and_get_default_image_url(): void
    {
        $this->gravatar = new Gravatar('http://www.hello.com/img.png');

        static::assertSame(
            "https://secure.gravatar.com/avatar/00000000000000000000000000000000?s=80&r=g&d=http%3A%2F%2Fwww.hello.com%2Fimg.png&f=y",
            $this->gravatar->get('')
        );

        $hashed = md5($this->email);

        static::assertSame(
            "https://secure.gravatar.com/avatar/$hashed?s=80&r=g&d=http%3A%2F%2Fwww.hello.com%2Fimg.png",
            $this->gravatar->get($this->email)
        );
    }

    /** @test */
    public function it_can_disable_and_enable_the_secure_url(): void
    {
        static::assertTrue($this->gravatar->isSecured());

        $this->gravatar->disableSecure();

        static::assertFalse($this->gravatar->isSecured());

        $this->gravatar->enableSecure();

        static::assertTrue($this->gravatar->isSecured());
    }

    /** @test */
    public function it_can_hash_email(): void
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
            static::assertSame(
                $expected, $this->gravatar->hashEmail($email)
            );
        }
    }

    /** @test */
    public function it_can_get_gravatar_secure_url(): void
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

            static::assertSame(1, preg_match($pattern, $url));
        }
    }

    /** @test */
    public function it_can_get_gravatar_url_on_empty_email(): void
    {
        $expected = 'https://secure.gravatar.com/avatar/00000000000000000000000000000000?s=80&r=g&d=identicon&f=y';

        static::assertSame($expected, $this->gravatar->get(''));
        static::assertSame($expected, $this->gravatar->get('', false));
    }

    /** @test */
    public function it_can_get_gravatar_src_url(): void
    {
        $hashed = md5($this->email);

        static::assertSame(
            "https://secure.gravatar.com/avatar/$hashed?s=80&r=g&d=identicon",
            $this->gravatar->src($this->email)
        );

        $size   = 128;

        static::assertSame(
            "https://secure.gravatar.com/avatar/$hashed?s=$size&r=g&d=identicon",
            $this->gravatar->src($this->email, $size)
        );

        $rating = 'r';

        static::assertSame(
            "https://secure.gravatar.com/avatar/$hashed?s=$size&r=$rating&d=identicon",
            $this->gravatar->src($this->email, $size, $rating)
        );
    }

    /** @test */
    public function it_can_get_gravatar_image_tag(): void
    {
        $hashed = md5($this->email);

        static::assertSame(
            "<img src=\"https://secure.gravatar.com/avatar/{$hashed}?s=80&amp;r=g&amp;d=identicon\">",
            $this->gravatar->image($this->email)->toHtml()
        );

        $alt = 'ARCANEDEV';

        static::assertSame(
            "<img src=\"https://secure.gravatar.com/avatar/{$hashed}?s=80&amp;r=g&amp;d=identicon\" alt=\"{$alt}\">",
            $this->gravatar->image($this->email, $alt)->toHtml()
        );

        static::assertSame(
            "<img src=\"https://secure.gravatar.com/avatar/{$hashed}?s=80&amp;r=g&amp;d=identicon\" alt=\"{$alt}\" class=\"img-fluid\">",
            $this->gravatar->image($this->email, $alt, ['class'  => 'img-fluid'])->toHtml()
        );
    }

    /** @test */
    public function it_can_check_if_email_has_a_gravatar(): void
    {
        static::assertTrue($this->gravatar->exists($this->email));

        static::assertFalse($this->gravatar->exists('not-real@email.com'));
    }

    /** @test */
    public function it_can_set_false_to_default_image(): void
    {
        $this->gravatar = new Gravatar(false);

        static::assertSame(
            'https://secure.gravatar.com/avatar/00000000000000000000000000000000?s=80&r=g&f=y',
            $this->gravatar->get('')
        );
    }

    /** @test */
    public function it_can_set_size_from_height_or_width_attributes(): void
    {
        $this->gravatar->image('', null, ['width' => 32]);

        static::assertSame(32, $this->gravatar->getSize());

        $this->gravatar->image('', null, ['height' => 64]);

        static::assertSame(64, $this->gravatar->getSize());

        $this->gravatar->image('', null, ['width' => 64, 'height' => 128]);

        static::assertSame(128, $this->gravatar->getSize());

        $this->gravatar->image('', null, ['width' => 256, 'height' => 128]);

        static::assertSame(256, $this->gravatar->getSize());
    }

    /** @test */
    public function it_get_profile(): void
    {
        $data = $this->gravatar->profile('arcanedev.maroc@gmail.com');

        static::assertIsArray($data);
        static::assertArrayHasKey('entry', $data);
        static::assertCount(1, $data['entry']);
    }

    /** @test */
    public function it_can_check_if_image_type_is_supported(): void
    {
        $types = [
            '404',
            'mp',
            'identicon',
            'monsterid',
            'wavatar',
            'retro',
            'robohash',
            'blank',
        ];

        foreach ($types as $type) {
            $this->gravatar->setDefaultImage($type);

            static::assertSame($type, $this->gravatar->getDefaultImage());
        }
    }

    /** @test */
    public function it_must_throw_exception_when_default_image_not_supported(): void
    {
        $this->expectException(InvalidImageUrlException::class);
        $this->expectExceptionMessage('The default image specified is not a recognized gravatar `default` and is not a valid URL: `github`');

        $this->gravatar->setDefaultImage('github');
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Assert the gravatar instance.
     *
     * @param  \Arcanedev\Gravatar\Contracts\Gravatar  $gravatar
     */
    public function assertGravatarInstance($gravatar): void
    {
        static::assertInstanceOf(\Arcanedev\Gravatar\Gravatar::class, $gravatar);
        static::assertSame('g', $gravatar->getRating());
        static::assertSame(80, $gravatar->getSize());
        static::assertTrue($gravatar->isSecured());
    }
}
