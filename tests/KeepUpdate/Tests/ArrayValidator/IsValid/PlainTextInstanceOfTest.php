<?php

namespace KeepUpdate\Tests\ArrayValidator\IsValid;

use KeepUpdate\ArrayValidator;
use Doctrine\Instantiator\Instantiator;
use Doctrine\Common\Annotations\AnnotationReader;

class PlainTextInstanceOfTest extends \PHPUnit_Framework_TestCase
{
    public function testFailWithIsInstanceOfClassDoesNotExist()
    {
        $sUT  = new ArrayValidator(new Instantiator(), new AnnotationReader());
        $data = array('test' => 'im in !');

        $this->setExpectedException('KeepUpdate\ValidationException');

        $sUT->isValid('KeepUpdate\Tests\Sample\PlainTextInstanceOfDoesNotExist', $data);
    }

    public function testFailWithIsInstanceOfWrongClass()
    {
        $sUT  = new ArrayValidator(new Instantiator(), new AnnotationReader());
        $data = array('test' => 'KeepUpdate\Tests\Sample\PlainTextInstanceOf');

        $this->setExpectedException('KeepUpdate\ValidationException');

        $this->assertEquals(
            $data,
            $sUT->isValid('KeepUpdate\Tests\Sample\PlainTextInstanceOf', $data)
        );
    }

    public function testValidWithIsInstanceOf()
    {
        $sUT  = new ArrayValidator(new Instantiator(), new AnnotationReader());
        $data = array('test' => 'KeepUpdate\Tests\Sample\WithoutAnnotation');

        $this->assertEquals(
            $data,
            $sUT->isValid('KeepUpdate\Tests\Sample\PlainTextInstanceOf', $data)
        );
    }

    public function testValidWithIsInstanceOfNullable()
    {
        $sUT  = new ArrayValidator(new Instantiator(), new AnnotationReader());
        $data = array('test' => null);

        $this->assertEquals(
            $data,
            $sUT->isValid('KeepUpdate\Tests\Sample\PlainTextInstanceOfNullable', $data)
        );
    }
}
