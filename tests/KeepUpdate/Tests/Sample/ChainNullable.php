<?php

namespace KeepUpdate\Tests\Sample;

use KeepUpdate\Annotations;

class ChainNullable implements \JsonSerializable
{
    /**
     * @Annotations\Chain(class="KeepUpdate\Tests\Sample\WithoutAnnotation", nullable=true);
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
