<?php

namespace KeepUpdate\Tests\ArrayValidator\IsValid;

use KeepUpdate\ArrayValidatorFactory;

class CamelCaseTest extends \PHPUnit_Framework_TestCase
{
    public function testClassFailWithChainIsNotAnArray()
    {
        $sUT  = ArrayValidatorFactory::getInstance();
        $data = array('test_camel_case' => 'im a camel case chain !');

        $this->assertEquals($data, $sUT->isValid('KeepUpdate\Tests\Sample\CamelCase', $data));
    }
}
