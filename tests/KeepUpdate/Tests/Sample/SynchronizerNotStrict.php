<?php

namespace KeepUpdate\Tests\Sample;

use KeepUpdate\Annotations;

/**
 * @Annotations\Synchronizer(strict=false);
 */
class SynchronizerNotStrict implements \JsonSerializable
{
    private $test = null;

    public function jsonSerialize()
    {
        return array(
            'testmyself' => $this->test
        );
    }
}
