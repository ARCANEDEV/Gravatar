<?php namespace Arcanedev\Gravatar\Tests\Helpers;

use Arcanedev\Gravatar\Helpers\HtmlBuilder;
use Arcanedev\Gravatar\Tests\TestCase;

/**
 * Class     HtmlBuilderTest
 *
 * @package  Arcanedev\Gravatar\Tests\Helpers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class HtmlBuilderTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_build_image_tag()
    {
        $this->assertEquals(
            '<img src="assets/img/logo.png" class="img-responsive" required="required" alt="Logo">',
            HtmlBuilder::image('assets/img/logo.png', 'Logo', [
                'class'  => 'img-responsive', 'required'
            ])
        );
    }
}
