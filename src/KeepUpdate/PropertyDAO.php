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

class PropertyDAO
{
    /**
     * Retrieve the synchorinized property with return data by jsonSerialize
     *
     * @param JsonSerializable $classInstance
     * @param array $data
     * @return array
     */
    public function getSynchronizedProperty(\JsonSerializable $classInstance, array $data)
    {
        $keys = array_keys($classInstance->jsonSerialize());
        $sync = array();

        // Check if all key are there
        foreach ($keys as $key) {
            $camelCaseKey = $this->toCamelCase($key);

            if (array_key_exists($key, $data) === false) {
                throw new ValidationException(sprintf('Key "%s" does not exist in "%s"', $key, json_encode($data)));
            } elseif (property_exists($classInstance, $camelCaseKey) === true) {
                $sync[] = $camelCaseKey;
            }
        }

        return $sync;
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
