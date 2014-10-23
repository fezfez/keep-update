<?php

namespace KeepUpdate\Tests\ArrayValidator\IsValid;

use KeepUpdate\ArrayValidatorFactory;

class PlainTextClassImplementsTest extends \PHPUnit_Framework_TestCase
{
    public function testFailWithIsInstanceOfClassDoesNotExist()
    {
        $sUT  = ArrayValidatorFactory::getInstance();
        $data = array('test' => 'im in !');

        $this->setExpectedException('KeepUpdate\ValidationException');

        $sUT->isValid('KeepUpdate\Tests\Sample\PlainTextClassImplementsDoesNotExist', $data);
    }

    public function testFailWithIsInstanceOfWrongClass()
    {
        $sUT  = ArrayValidatorFactory::getInstance();
        $data = array('test' => 'KeepUpdate\Tests\Sample\PlainTextInstanceOf');

        $this->setExpectedException('KeepUpdate\ValidationException');

        $this->assertEquals(
            $data,
            $sUT->isValid('KeepUpdate\Tests\Sample\PlainTextClassImplements', $data)
        );
    }

    public function testValidWithClassImplements()
    {
        $sUT  = ArrayValidatorFactory::getInstance();
        $data = array('test' => 'KeepUpdate\Tests\Sample\DummieImplementation');

        $this->assertEquals(
            $data,
            $sUT->isValid('KeepUpdate\Tests\Sample\PlainTextClassImplements', $data)
        );
    }

    public function testValidWithIsInstanceOfNullable()
    {
        $sUT  = ArrayValidatorFactory::getInstance();
        $data = array('test' => null);

        $this->assertEquals(
            $data,
            $sUT->isValid('KeepUpdate\Tests\Sample\PlainTextClassImplementsNullable', $data)
        );
    }
}
