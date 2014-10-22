<?php

namespace KeepUpdate\Tests\Sample;


class SimpleInstanceOfa implements \JsonSerializable
{
	private $test = null;

	public function jsonSerialize()
	{
		return array(
			'test' => $this->test
		);
	}
}