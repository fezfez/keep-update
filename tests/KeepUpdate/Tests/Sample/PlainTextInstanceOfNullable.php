<?php

namespace KeepUpdate\Tests\Sample;

use KeepUpdate\Annotations;

class PlainTextInstanceOfNullable implements \JsonSerializable
{
    /**
     * @Annotations\PlainTextInstanceOf(class="KeepUpdate\Tests\Sample\WithoutAnnotation", nullable=true)
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