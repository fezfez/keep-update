<?php

namespace KeepUpdate\Tests\ArrayValidator\IsValid;

use KeepUpdate\ArrayValidatorFactory;

class ChainTest extends \PHPUnit_Framework_TestCase
{
    public function testClassFailWithChainIsNotAnArray()
    {
        $sUT = ArrayValidatorFactory::getInstance();

        $this->setExpectedException('KeepUpdate\ValidationException');

        $sUT->isValid('KeepUpdate\Tests\Sample\ChainDoesNotExist', array('test' => 'im not an array'));
    }

    public function testClassFailWithChainDoesNotExist()
    {
        $sUT = ArrayValidatorFactory::getInstance();

        $this->setExpectedException('KeepUpdate\ValidationException');

        $sUT->isValid('KeepUpdate\Tests\Sample\ChainDoesNotExist', array('test' => array('im in !')));
    }

    public function testValidWithSimpleChain()
    {
        $sUT    = ArrayValidatorFactory::getInstance();
        $result = array('test' => array('test' => 'chain !'));

        $this->assertEquals($result, $sUT->isValid('KeepUpdate\Tests\Sample\Chain', $result));
    }

    public function testValidWithMultipleChain()
    {
        $sUT    = ArrayValidatorFactory::getInstance();;
        $result = array('test' => array('test' => array('test' => 'chain !')));

        $this->assertEquals($result, $sUT->isValid('KeepUpdate\Tests\Sample\ChainMultiple', $result));
    }

    public function testValidWithNullableChain()
    {
        $sUT    = ArrayValidatorFactory::getInstance();
        $result = array('test' => array('test' => 'chain !'));

        $this->assertEquals($result, $sUT->isValid('KeepUpdate\Tests\Sample\ChainNullable', $result));

        $result = array('test' => null);

        $this->assertEquals($result, $sUT->isValid('KeepUpdate\Tests\Sample\ChainNullable', $result));
    }
}
