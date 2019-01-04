<?php

namespace Ako\Shorturl\Tests\Unit;

use Ako\Shorturl\Tests\TestCase;
use http\Exception\InvalidArgumentException;

class TestLocalDriver extends TestCase
{

	public function test_get_driver_exception ()
	{
		$this->assertEquals(\Shorturl::getDriver(), 'local', 'The default driver is not local');
	}
}