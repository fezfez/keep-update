<?php

namespace KeepUpdate\Tests\ArrayValidatorFactory;

use KeepUpdate\ArrayValidatorFactory;

class GetInstanceTest extends \PHPUnit_Framework_TestCase
{
	public function testInstance()
	{
		$this->assertInstanceOf('KeepUpdate\ArrayValidator', ArrayValidatorFactory::getInstance());
	}
}