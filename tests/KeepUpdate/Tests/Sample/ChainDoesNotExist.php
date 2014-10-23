<?php

namespace KeepUpdate\Tests\Sample;

use KeepUpdate\Annotations;

class ChainDoesNotExist implements \JsonSerializable
{
    /**
     * @Annotations\Chain(class="doesNotExist");
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
