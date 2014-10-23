<?php

namespace KeepUpdate\Tests\ArrayValidator\IsValid;

use KeepUpdate\ArrayValidator;
use Doctrine\Instantiator\Instantiator;
use Doctrine\Common\Annotations\AnnotationReader;

class PlainTextClassImplementsTest extends \PHPUnit_Framework_TestCase
{
    public function testFailWithIsInstanceOfClassDoesNotExist()
    {
        $sUT  = new ArrayValidator(new Instantiator(), new AnnotationReader());
        $data = array('test' => 'im in !');

        $this->setExpectedException('KeepUpdate\ValidationException');

        $sUT->isValid('KeepUpdate\Tests\Sample\PlainTextClassImplementsDoesNotExist', $data);
    }

    public function testFailWithIsInstanceOfWrongClass()
    {
        $sUT  = new ArrayValidator(new Instantiator(), new AnnotationReader());
        $data = array('test' => 'KeepUpdate\Tests\Sample\PlainTextInstanceOf');

        $this->setExpectedException('KeepUpdate\ValidationException');

        $this->assertEquals(
            $data,
            $sUT->isValid('KeepUpdate\Tests\Sample\PlainTextClassImplements', $data)
        );
    }

    public function testValidWithClassImplements()
    {
        $sUT  = new ArrayValidator(new Instantiator(), new AnnotationReader());
        $data = array('test' => 'KeepUpdate\Tests\Sample\DummieImplementation');

        $this->assertEquals(
            $data,
            $sUT->isValid('KeepUpdate\Tests\Sample\PlainTextClassImplements', $data)
        );
    }

    public function testValidWithIsInstanceOfNullable()
    {
        $sUT  = new ArrayValidator(new Instantiator(), new AnnotationReader());
        $data = array('test' => null);

        $this->assertEquals(
            $data,
            $sUT->isValid('KeepUpdate\Tests\Sample\PlainTextClassImplementsNullable', $data)
        );
    }
}
