<?php

namespace KeepUpdate\Tests\ArrayValidator;

use KeepUpdate\ArrayValidator;
use Doctrine\Instantiator\Instantiator;
use Doctrine\Common\Annotations\AnnotationReader;

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

    	$sUT->isValid('KeepUpdate\Tests\Sample\SimpleInstanceOfa', array());
    }

    public function testClassFailWithoutAnnotationSyncButEmpty()
    {
    	$sUT = new ArrayValidator(new Instantiator(), new AnnotationReader());

    	$this->setExpectedException('KeepUpdate\ValidationException');

    	$sUT->isValid('KeepUpdate\Tests\Sample\SimpleInstanceOfa', array('test'));
    }

    public function testClassValidWithoutAnnotationAndSync()
    {
    	$sUT  = new ArrayValidator(new Instantiator(), new AnnotationReader());
    	$data = array('test' => 'im in !');

    	$this->assertEquals(
    		$data,
    		$sUT->isValid('KeepUpdate\Tests\Sample\SimpleInstanceOfa', $data)
    	);
    }

    public function testClassFailWithChainIsNotAnArray()
    {
    	$sUT = new ArrayValidator(new Instantiator(), new AnnotationReader());

    	$this->setExpectedException('KeepUpdate\ValidationException');

    	$sUT->isValid('KeepUpdate\Tests\Sample\ChainDoesNotExist', array('test' => 'im not an array'));
    }

    public function testClassFailWithChainDoesNotExist()
    {
    	$sUT = new ArrayValidator(new Instantiator(), new AnnotationReader());

    	$this->setExpectedException('KeepUpdate\ValidationException');

    	$sUT->isValid('KeepUpdate\Tests\Sample\ChainDoesNotExist', array('test' => array('im in !')));
    }
}
