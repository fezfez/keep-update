<?php

namespace KeepUpdate\Tests\Sample;

use KeepUpdate\Annotations;

class PlainTextInstanceOf implements \JsonSerializable
{
    /**
     * @Annotations\PlainTextInstanceOf(class="KeepUpdate\Tests\Sample\WithoutAnnotation")
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