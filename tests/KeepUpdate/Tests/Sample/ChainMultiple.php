<?php

namespace KeepUpdate\Tests\Sample;

use KeepUpdate\Annotations;

class ChainMultiple implements \JsonSerializable
{
    /**
     * @Annotations\Chain(class="KeepUpdate\Tests\Sample\Chain");
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