<?php

namespace KeepUpdate\Tests\Sample;

use KeepUpdate\Annotations;

class PlainTextClassImplements implements \JsonSerializable
{
    /**
     * @Annotations\PlainTextClassImplements(interface="KeepUpdate\Tests\Sample\DummieInterface")
     * @var string
     */
    private $test = null;

    public function jsonSerialize()
    {
        return array(
            'test' => $this->test
        );
    }
}
