<?php

namespace KeepUpdate\Tests\Sample;


class CamelCase implements \JsonSerializable
{
	private $testCamelCase = null;

	public function jsonSerialize()
	{
		return array(
			'test_camel_case' => $this->testCamelCase
		);
	}
}