<?php

namespace KeepUpdate\Tests\Sample;

use KeepUpdate\Annotations;

/**
 * @author Stagiaire
 * @Annotations\Synchronizer(strict=true);
 */
class SynchronizerFail implements \JsonSerializable
{
    private $test = null;

    public function jsonSerialize()
    {
        return array(
            'testmyself' => $this->test
        );
    }
}