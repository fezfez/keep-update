<?php

namespace KeepUpdate\Tests\ArrayValidator\IsValid;

use KeepUpdate\ArrayValidatorFactory;

class PlainTextInstanceOfTest extends \PHPUnit_Framework_TestCase
{
    public function testFailWithIsInstanceOfClassDoesNotExist()
    {
        $sUT  = ArrayValidatorFactory::getInstance();
        $data = array('test' => 'im in !');

        $this->setExpectedException('KeepUpdate\ValidationException');

        $sUT->isValid('KeepUpdate\Tests\Sample\PlainTextInstanceOfDoesNotExist', $data);
    }

    public function testFailWithIsInstanceOfWrongClass()
    {
        $sUT  = ArrayValidatorFactory::getInstance();
        $data = array('test' => 'KeepUpdate\Tests\Sample\PlainTextInstanceOf');

        $this->setExpectedException('KeepUpdate\ValidationException');

        $this->assertEquals(
            $data,
            $sUT->isValid('KeepUpdate\Tests\Sample\PlainTextInstanceOf', $data)
        );
    }

    public function testValidWithIsInstanceOf()
    {
        $sUT  = ArrayValidatorFactory::getInstance();
        $data = array('test' => 'KeepUpdate\Tests\Sample\WithoutAnnotation');

        $this->assertEquals(
            $data,
            $sUT->isValid('KeepUpdate\Tests\Sample\PlainTextInstanceOf', $data)
        );
    }

    public function testValidWithIsInstanceOfNullable()
    {
        $sUT  = ArrayValidatorFactory::getInstance();
        $data = array('test' => null);

        $this->assertEquals(
            $data,
            $sUT->isValid('KeepUpdate\Tests\Sample\PlainTextInstanceOfNullable', $data)
        );
    }
}
