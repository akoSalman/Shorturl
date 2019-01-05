<?php

namespace Ako\Shorturl\Tests\Unit;

use Ako\Shorturl\Tests\TestCase;
use http\Exception\InvalidArgumentException;

class TestLocalDriver extends TestCase
{

	public function test_shorten ()
	{
	    $long = "127.0.0.1:8000/here/is/a/long/url?x=12#asdlf";
        $shortened = \Shorturl::shorten($long);
        $this->assertNotEmpty($shortened);
        $this->assertNotNull($shortened);
	}

	public function test_expand ()
    {
        $long1 = \Shorturl::expand("127.0.0.1:8000/7777");

        $this->assertEquals("127.0.0.1:8000/here/is/a/long/url?x=12#asdlf", $long1);
    }

    public function test_get_driver ()
    {
        $this->assertEquals(config("shorturl.drivers.default"), \Shorturl::getDriver());
    }
}