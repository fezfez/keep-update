<?php

namespace KeepUpdate\Tests\Sample;

use KeepUpdate\Annotations;

class PlainTextInstanceOfDoesNotExist implements \JsonSerializable
{
    /**
     * @Annotations\PlainTextInstanceOf(class="doesNotExist")
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