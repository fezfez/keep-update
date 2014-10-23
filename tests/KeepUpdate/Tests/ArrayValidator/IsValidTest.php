<?php

namespace KeepUpdate\Tests\ArrayValidator;

use KeepUpdate\ArrayValidatorFactory;
use KeepUpdate\Tests\Sample\WithoutAnnotation;
use KeepUpdate\Tests\Sample\WithoutJsonSerializableAndAnnotation;

class IsValidTest extends \PHPUnit_Framework_TestCase
{
    public function testClassDoesNotExist()
    {
        $sUT = ArrayValidatorFactory::getInstance();

        $this->setExpectedException('KeepUpdate\ValidationException');

        $sUT->isValid('doesNotExist', array());
    }

    public function testClassFailWithoutAnnotationButNoSync()
    {
        $sUT = ArrayValidatorFactory::getInstance();

        $this->setExpectedException('KeepUpdate\ValidationException');

        $sUT->isValid('KeepUpdate\Tests\Sample\WithoutAnnotation', array());
    }

    public function testClassFailWithoutAnnotationSyncButEmpty()
    {
        $sUT = ArrayValidatorFactory::getInstance();

        $this->setExpectedException('KeepUpdate\ValidationException');

        $sUT->isValid('KeepUpdate\Tests\Sample\WithoutAnnotation', array('test'));
    }

    public function testClassValidWithoutAnnotationAndSync()
    {
        $sUT  = ArrayValidatorFactory::getInstance();
        $data = array('test' => 'im in !');

        $this->assertEquals(
            $data,
            $sUT->isValid('KeepUpdate\Tests\Sample\WithoutAnnotation', $data)
        );
    }

    public function testClassValidWithoutAnnotationAndSyncWithRealInstance()
    {
        $sUT  = ArrayValidatorFactory::getInstance();
        $data = array('test' => 'im in !');

        $this->assertEquals(
            $data,
            $sUT->isValid(new WithoutAnnotation(), $data)
        );
    }

    public function testClassValidWithoutAnnotationAndSyncAndJsonSerializableWithRealInstance()
    {
        $sUT  = ArrayValidatorFactory::getInstance();
        $data = array('test' => 'im in !');

        $this->setExpectedException('KeepUpdate\ValidationException');

        $sUT->isValid(new WithoutJsonSerializableAndAnnotation(), $data);
    }
}
