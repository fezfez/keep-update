<?php

namespace KeepUpdate\Tests\Sample;

use KeepUpdate\Annotations;

/**
 * @author Stagiaire
 * @Annotations\Synchronizer(strict=true);
 */
class SynchronizerWithCamelCase implements \JsonSerializable
{
    private $testCamelCase = null;

    public function jsonSerialize()
    {
        return array(
            'test_camel_case' => $this->testCamelCase
        );
    }
}