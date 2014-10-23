<?php

namespace KeepUpdate\Tests\ArrayValidator\IsValid;

use KeepUpdate\ArrayValidator;
use Doctrine\Instantiator\Instantiator;
use Doctrine\Common\Annotations\AnnotationReader;

class CamelCaseTest extends \PHPUnit_Framework_TestCase
{
    public function testClassFailWithChainIsNotAnArray()
    {
        $sUT  = new ArrayValidator(new Instantiator(), new AnnotationReader());
        $data = array('test_camel_case' => 'im a camel case chain !');

        $this->assertEquals($data, $sUT->isValid('KeepUpdate\Tests\Sample\CamelCase', $data));
    }
}
