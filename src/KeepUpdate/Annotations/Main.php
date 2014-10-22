<?php

namespace KeepUpdate\Annotations;

/**
 * @Annotation
 *
 */
class Main
{
    /**
     * @var boolean
     */
    public $strictMode;

    public function exec($keys, $classInstance)
    {
        if ($this->strictMode === true) {
            foreach ($keys as $key) {
                if (method_exists($classInstance, 'set' . $textHelper->toCamelCase($key, true)) === false) {
                    throw new \Exception(sprintf('"%s" not sync with "%s"', $key, $textHelper->toCamelCase($key, true)));
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