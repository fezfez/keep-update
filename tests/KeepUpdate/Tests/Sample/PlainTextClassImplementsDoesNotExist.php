<?php

namespace KeepUpdate\Tests\Sample;

use KeepUpdate\Annotations;

class PlainTextClassImplementsDoesNotExist implements \JsonSerializable
{
    /**
     * @Annotations\PlainTextClassImplements(interface="doesNotExist")
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
