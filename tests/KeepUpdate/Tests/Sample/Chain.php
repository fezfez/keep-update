<?php

namespace KeepUpdate\Tests\Sample;

use KeepUpdate\Annotations;

class Chain implements \JsonSerializable
{
    /**
     * @Annotations\Chain(class="KeepUpdate\Tests\Sample\WithoutAnnotation");
     * @var unknown
     */
    private $test = null;

    public function jsonSerialize()
    {
        return array(
            'test' => $this->test
        );
    }
}