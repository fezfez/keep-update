<?php

namespace KeepUpdate\Annotations;

use KeepUpdate\ValidationException;

/**
 * @Annotation
 *
 */
class Synchronizer
{
    /**
     * @var boolean
     */
    public $strict;

    public function exec($keys, $classInstance)
    {
        if ($this->strict === true) {
            foreach ($keys as $key) {
                $camelCaseKey = $this->toCamelCase($key);
                $methodName   = 'set' . ucfirst($camelCaseKey);

                /*if (method_exists($classInstance, $methodName) === false) {
                    throw new \Exception(sprintf('"%s" not sync with method "%s"', $key, $methodName));
                }*/
                if (property_exists($classInstance, $camelCaseKey) === false) {
                    throw new ValidationException(
                        sprintf(
                            'jsonSerialize return a property "%s" that does not exist on "%s"',
                            $key,
                            get_class($classInstance)
                        )
                    );
                }
            }
        }
    }

    /**
     * @param string $value
     * @return string
     */
    private function toCamelCase($value)
    {
        return preg_replace_callback(
            '/_(\w)/',
            function (array $matches) {
               return ucfirst($matches[1]);
            },
            $value
        );
    }
}