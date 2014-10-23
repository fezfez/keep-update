<?php

namespace KeepUpdate\Tests\Sample;

use KeepUpdate\Annotations;

class WithoutAnnotation implements \JsonSerializable
{
    private $test = null;

    public function jsonSerialize()
    {
        return array(
            'test' => $this->test
        );
    }
}
