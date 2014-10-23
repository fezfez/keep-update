<?php

namespace KeepUpdate;

use Doctrine\Instantiator\Instantiator;
use Doctrine\Common\Annotations\AnnotationReader;

class ArrayValidatorFactory
{
    /**
     * @return \KeepUpdate\ArrayValidator
     */
    public static function getInstance()
    {
        return new ArrayValidator(new Instantiator(), new AnnotationReader());
    }
}
