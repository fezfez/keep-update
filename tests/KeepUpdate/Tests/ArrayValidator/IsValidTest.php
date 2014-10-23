<?php

namespace KeepUpdate\Tests\ArrayValidator;

use KeepUpdate\ArrayValidator;
use Doctrine\Instantiator\Instantiator;
use Doctrine\Common\Annotations\AnnotationReader;
use KeepUpdate\Tests\Sample\WithoutAnnotation;
use KeepUpdate\Tests\Sample\WithoutJsonSerializableAndAnnotation;

class IsValidTest extends \PHPUnit_Framework_TestCase
{
    public function testClassDoesNotExist()
    {
        $sUT = new ArrayValidator(new Instantiator(), new AnnotationReader());

        $this->setExpectedException('KeepUpdate\ValidationException');

        $sUT->isValid('doesNotExist', array());
    }

    public function testClassFailWithoutAnnotationButNoSync()
    {
        $sUT = new ArrayValidator(new Instantiator(), new AnnotationReader());

        $this->setExpectedException('KeepUpdate\ValidationException');

        $sUT->isValid('KeepUpdate\Tests\Sample\WithoutAnnotation', array());
    }

    public function testClassFailWithoutAnnotationSyncButEmpty()
    {
        $sUT = new ArrayValidator(new Instantiator(), new AnnotationReader());

        $this->setExpectedException('KeepUpdate\ValidationException');

        $sUT->isValid('KeepUpdate\Tests\Sample\WithoutAnnotation', array('test'));
    }

    public function testClassValidWithoutAnnotationAndSync()
    {
        $sUT  = new ArrayValidator(new Instantiator(), new AnnotationReader());
        $data = array('test' => 'im in !');

        $this->assertEquals(
            $data,
            $sUT->isValid('KeepUpdate\Tests\Sample\WithoutAnnotation', $data)
        );
    }

    public function testClassValidWithoutAnnotationAndSyncWithRealInstance()
    {
        $sUT  = new ArrayValidator(new Instantiator(), new AnnotationReader());
        $data = array('test' => 'im in !');

        $this->assertEquals(
            $data,
            $sUT->isValid(new WithoutAnnotation(), $data)
        );
    }

    public function testClassValidWithoutAnnotationAndSyncAndJsonSerializableWithRealInstance()
    {
        $sUT  = new ArrayValidator(new Instantiator(), new AnnotationReader());
        $data = array('test' => 'im in !');

        $this->setExpectedException('KeepUpdate\ValidationException');

        $sUT->isValid(new WithoutJsonSerializableAndAnnotation(), $data);
    }
}
