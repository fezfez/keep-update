<?php
/**
 * This file is part of the KeepUpdate package.
 *
 * (c) Stéphane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KeepUpdate;

use Doctrine\Common\Annotations\AnnotationReader;
use KeepUpdate\Annotations;

class AnnotationDAO
{
    /**
     * @var AnnotationReader
     */
    private $annotationReader = null;

    /**
     * @param AnnotationReader $annotationReader
     */
    public function __construct(AnnotationReader $annotationReader)
    {
        $this->annotationReader = $annotationReader;

        // Wake up annotation
        new Annotations\Synchronizer();
        new Annotations\PlainTextInstanceOf();
        new Annotations\PlainTextClassImplements();
        new Annotations\Chain();
    }

    /**
     * @param string|object $class
     * @return array
     */
    public function getClassAnnotations($class)
    {
        $reflectionClass = new \ReflectionClass($class);
        $classAnotation  = array();

        foreach ($this->annotationReader->getClassAnnotations($reflectionClass) as $contraint) {
            if ($contraint instanceof Annotations\Synchronizer) {
                $classAnotation[] = $contraint;
            }
        }

        return $classAnotation;
    }

    /**
     * @param array $properties
     * @param object $class
     * @return array
     */
    public function getPropertyAnnotations(array $properties, $class)
    {
        $contraints = array();

        // Foreach the sync and retrieve the anotation
        foreach ($properties as $property) {
            $propertyReflection = new \ReflectionProperty($class, $property);
            $annotation         = $this->annotationReader->getPropertyAnnotations($propertyReflection);

            if (empty($annotation) === false) {
                $contraints[$property] = $annotation;
            }
        }

        return $contraints;
    }
}
