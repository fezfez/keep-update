<?php

namespace KeepUpdate\Tests\Sample;

use KeepUpdate\Annotations;

class PlainTextClassImplementsNullable implements \JsonSerializable
{
    /**
     * @Annotations\PlainTextClassImplements(interface="KeepUpdate\Tests\Sample\DummieImplementation", nullable=true)
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
