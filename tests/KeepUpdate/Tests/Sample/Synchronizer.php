<?php

namespace KeepUpdate\Tests\Sample;

use KeepUpdate\Annotations;

/**
 * @author Stagiaire
 * @Annotations\Synchronizer(strict=true);
 */
class Synchronizer implements \JsonSerializable
{
    private $test = null;

    public function jsonSerialize()
    {
        return array(
            'test' => $this->test
        );
    }
}