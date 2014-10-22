<?php

namespace KeepUpdate;

use Doctrine\Instantiator\Instantiator;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Doctrine\Common\Annotations\AnnotationReader;
use KeepUpdate\Annotations\InstanceOfa;
use KeepUpdate\Annotations\ClassImplements;
use KeepUpdate\Annotations\Main;
use KeepUpdate\Annotations\Chain;

class ArrayValidator
{
    /**
     * @var Instantiator
     */
    private $instantiator = null;
    /**
     * @var AnnotationReader
     */
    private $annotationReader = null;

    /**
     * @param Instantiator $instantiator
     * @param AnnotationReader $annotationReader
     */
    public function __construct(Instantiator $instantiator, AnnotationReader $annotationReader)
    {
        $this->instantiator     = $instantiator;
        $this->annotationReader = $annotationReader;
    }

    /**
     * @param string $class
     * @param array $data
     * @throws \Exception
     */
    public function isValid($class, array $data)
    {
        try {
            $classInstance    = $this->instantiator->instantiate($class);
        } catch (InvalidArgumentException $e) {
            throw new ValidationException($e->getMessage());
        }

        $keys             = array_keys($classInstance->jsonSerialize());
        $reflectionClass  = new \ReflectionClass($class);

        // Check if all key are there
        foreach ($keys as $key) {
            if ($this->isAttributeIsSet($data, $key) === false) {
                throw new ValidationException(sprintf('Key "%s" does not exist in "%s"', $key, json_encode($data)));
            }
        }

        // Wake up annotation
        new Main();
        new InstanceOfa();
        new ClassImplements();
        new Chain();


        foreach ($this->annotationReader->getClassAnnotations($reflectionClass) as $contraint) {
            if ($contraint instanceof Main) {
                $contraint->exec($keys, $classInstance);
            }
        }

        // Foreach the constraint and execute
        foreach ($this->retrieveConstraint($keys, $classInstance) as $contraintName => $childContraint) {
            foreach ($childContraint as $contraint) {
                if ($contraint instanceof Chain) {
                    if ($contraint->optional === true && $data[$contraintName] === null) {

                    } else {
                        if (is_array($data[$contraintName]) === false) {
                            throw new ValidationException(sprintf('"%s" must be and array in "%s"', $contraintName, json_encode($data)));
                        }
                        try {
                            $this->isValid($contraint->class, $data[$contraintName]);
                        } catch (\Exception $e) {
                            throw new ValidationException(sprintf('%s in "%s" from "%s"', $e->getMessage(), $contraintName, json_encode($data)));
                        }
                    }
                } else {
                    $contraint->exec($data[$contraintName]);
                }
            }

        }

        return $data;
    }

    /**
     * @param array $keys
     * @param object $classInstance
     * @return array
     */
    private function retrieveConstraint(array $keys, $classInstance)
    {
        // Retrieve the synchorinized property with return data by jsonSerialize
        $sync = array();
        foreach ($keys as $key) {
            if (property_exists($classInstance, $this->toCamelCase($key)) === true) {
                $sync[] = $key;
            }
        }

        $contraints = array();

        // Foreach the sync and retrieve the anotation
        foreach ($sync as $property) {
            $propertyReflection = new \ReflectionProperty($classInstance, $property);
            $annotation         = $this->annotationReader->getPropertyAnnotations($propertyReflection);

            if (!empty($annotation)) {
                $contraints[$property] = $annotation;
            }
        }

        return $contraints;
    }

    /**
     * @param array $data
     * @param string $attribute
     * @return boolean
     */
    private function isAttributeIsSet(array $data, $attribute)
    {
        return (false === array_key_exists($attribute, $data) || null === $data[$attribute]) ? false : true;
    }

    /**
     * @param string $value
     * @return string
     */
    private function toCamelCase($value)
    {
        $value = preg_replace_callback(
            '/_(\w)/',
            function (array $matches) {
                return ucfirst($matches[1]);
            },
            $value
        );

        return $value;
    }
}
