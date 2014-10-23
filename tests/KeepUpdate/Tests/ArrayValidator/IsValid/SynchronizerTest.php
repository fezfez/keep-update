<?php

namespace KeepUpdate\Tests\ArrayValidator\IsValid;

use KeepUpdate\ArrayValidator;
use Doctrine\Instantiator\Instantiator;
use Doctrine\Common\Annotations\AnnotationReader;

class SynchronizerTest extends \PHPUnit_Framework_TestCase
{
    public function testValid()
    {
        $sUT  = new ArrayValidator(new Instantiator(), new AnnotationReader());
        $data = array('test' => 'im a camel case chain !');

        $this->assertEquals($data, $sUT->isValid('KeepUpdate\Tests\Sample\Synchronizer', $data));
    }

    public function testValidWithCamelCase()
    {
        $sUT  = new ArrayValidator(new Instantiator(), new AnnotationReader());
        $data = array('test_camel_case' => 'im a camel case chain !');

        $this->assertEquals($data, $sUT->isValid('KeepUpdate\Tests\Sample\SynchronizerWithCamelCase', $data));
    }

    public function testFail()
    {
        $sUT  = new ArrayValidator(new Instantiator(), new AnnotationReader());
        $data = array('testmyself' => 'im a camel case chain !');

        $this->setExpectedException('KeepUpdate\ValidationException');

        $this->assertEquals($data, $sUT->isValid('KeepUpdate\Tests\Sample\SynchronizerFail', $data));
    }
}
