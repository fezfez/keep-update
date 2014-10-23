<?php
/**
 * This file is part of the KeepUpdate package.
 *
 * (c) Stéphane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KeepUpdate\Annotations;

use KeepUpdate\SynchronisationException;

/**
 * @Annotation
 *
 */
class Synchronizer
{
    /**
     * @var boolean
     */
    public $strict = false;

    /**
     * @param \JsonSerializable $classInstance
     * @param array $data
     * @throws SynchronisationException
     */
    public function exec(\JsonSerializable $classInstance, $data)
    {
        if ($this->strict === false) {
            return;
        }

        $classKeys = array_keys($classInstance->jsonSerialize());

        foreach ($classKeys as $key) {
            $camelCaseKey = $this->toCamelCase($key);

            if (property_exists($classInstance, $camelCaseKey) === false) {
                throw new SynchronisationException(
                    sprintf(
                        'jsonSerialize return a property "%s" that does not exist on "%s"',
                        $key,
                        get_class($classInstance)
                    )
                );
            }
        }

        if (($diff = array_diff(array_keys($data), $classKeys)) !== array()) {
            throw new SynchronisationException(
                sprintf('Some keys does not exist in given data "%s"', implode(',', $diff))
            );
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
