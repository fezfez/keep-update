<?php

namespace KeepUpdate\Tests\ArrayValidator\IsValid;

use KeepUpdate\ArrayValidatorFactory;

class SynchronizerTest extends \PHPUnit_Framework_TestCase
{
    public function testValid()
    {
        $sUT  = ArrayValidatorFactory::getInstance();
        $data = array('test' => 'im a camel case chain !');

        $this->assertEquals($data, $sUT->isValid('KeepUpdate\Tests\Sample\Synchronizer', $data));
    }

    public function testInvalidWithUnkownKey()
    {
        $sUT  = ArrayValidatorFactory::getInstance();
        $data = array('test' => 'im a camel case chain !', 'unknowkey' => 'hi ! How are you ?');

        $this->setExpectedException('KeepUpdate\SynchronisationException');

        $this->assertEquals($data, $sUT->isValid('KeepUpdate\Tests\Sample\Synchronizer', $data));
    }

    public function testValidWithCamelCase()
    {
        $sUT  = ArrayValidatorFactory::getInstance();
        $data = array('test_camel_case' => 'im a camel case chain !');

        $this->assertEquals($data, $sUT->isValid('KeepUpdate\Tests\Sample\SynchronizerWithCamelCase', $data));
    }

    public function testWithStrictEqualsFalse()
    {
        $sUT  = ArrayValidatorFactory::getInstance();
        $data = array('testmyself' => 'im a camel case chain !', 'unknowkey' => 'hi ! How are you ?');

        $this->assertEquals($data, $sUT->isValid('KeepUpdate\Tests\Sample\SynchronizerNotStrict', $data));
    }

    public function testFail()
    {
        $sUT  = ArrayValidatorFactory::getInstance();
        $data = array('testmyself' => "im not sync :'(");

        $this->setExpectedException('KeepUpdate\SynchronisationException');

        $sUT->isValid('KeepUpdate\Tests\Sample\SynchronizerFail', $data);
    }
}
