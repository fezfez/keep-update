<?php

namespace KeepUpdate\Tests\ArrayValidator\IsValid;

use KeepUpdate\ArrayValidator;
use Doctrine\Instantiator\Instantiator;
use Doctrine\Common\Annotations\AnnotationReader;

class ChainTest extends \PHPUnit_Framework_TestCase
{
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

    public function testValidWithSimpleChain()
    {
        $sUT    = new ArrayValidator(new Instantiator(), new AnnotationReader());
        $result = array('test' => array('test' => 'chain !'));

        $this->assertEquals($result, $sUT->isValid('KeepUpdate\Tests\Sample\Chain', $result));
    }

    public function testValidWithMultipleChain()
    {
        $sUT    = new ArrayValidator(new Instantiator(), new AnnotationReader());;
        $result = array('test' => array('test' => array('test' => 'chain !')));

        $this->assertEquals($result, $sUT->isValid('KeepUpdate\Tests\Sample\ChainMultiple', $result));
    }
}
