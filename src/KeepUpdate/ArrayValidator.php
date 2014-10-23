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

use Doctrine\Instantiator\Instantiator;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use KeepUpdate\Annotations;

class ArrayValidator
{
    /**
     * @var Instantiator
     */
    private $instantiator = null;
    /**
     * @var AnnotationDAO
     */
    private $annotationDAO = null;
    /**
     * @var PropertyDAO
     */
    private $propertyDAO = null;

    /**
     * @param Instantiator $instantiator
     * @param AnnotationDAO $annotationDAO
     * @param PropertyDAO $propertyDAO
     */
    public function __construct(Instantiator $instantiator, AnnotationDAO $annotationDAO, PropertyDAO $propertyDAO)
    {
        $this->instantiator  = $instantiator;
        $this->annotationDAO = $annotationDAO;
        $this->propertyDAO   = $propertyDAO;
    }

    /**
     * @param string|object $class
     * @param array $data
     * @throws \Exception
     */
    public function isValid($class, array $data)
    {
        $classInstance = $this->retrieveClass($class);
        $properties    = $this->propertyDAO->getSynchronizedProperty($classInstance, $data);

        foreach ($this->annotationDAO->getClassAnnotations($classInstance) as $contraint) {
            if ($contraint instanceof Annotations\Synchronizer) {
                $contraint->exec($classInstance, $data);
            }
        }

        $propertiesAnnoration = $this->annotationDAO->getPropertyAnnotations($properties, $classInstance);
        // Foreach the constraint and execute
        foreach ($propertiesAnnoration as $contraintName => $childContraint) {
            foreach ($childContraint as $contraint) {
                $this->execAnnotation($contraint, $contraintName, $data);
            }
        }

        return $data;
    }

    /**
     * @param string|object $class
     * @throws ValidationException
     * @return \JsonSerializable
     */
    private function retrieveClass($class)
    {
        if (is_object($class) === true) {
            $classInstance = $class;
        } else {
            try {
                $classInstance = $this->instantiator->instantiate($class);
            } catch (InvalidArgumentException $e) {
                throw new ClassDoesNotExistException($e->getMessage());
            }
        }

        if (in_array('JsonSerializable', class_implements($classInstance)) === false) {
            throw new InvalidTypeException(
                sprintf('Class "%s" must implements "JsonSerializable"', get_class($classInstance))
            );
        }

        return $classInstance;
    }

    /**
     * @param class $contraint
     * @param string $contraintName
     * @param array $data
     * @throws ValidationException
     */
    private function execAnnotation($contraint, $contraintName, array $data)
    {
        if ($contraint instanceof Annotations\Chain) {
            if ($contraint->nullable === true && $data[$contraintName] === null) {
                return;
            } elseif (is_array($data[$contraintName]) === false) {
                throw new InvalidTypeException(
                    sprintf('"%s" must be and array in "%s"', $contraintName, json_encode($data))
                );
            }
            try {
                $this->isValid($contraint->class, $data[$contraintName]);
            } catch (\Exception $e) {
                throw new ValidationException(
                    sprintf('%s in "%s" from "%s"', $e->getMessage(), $contraintName, json_encode($data))
                );
            }
        } else {
            $contraint->exec($data[$contraintName]);
        }
    }
}
