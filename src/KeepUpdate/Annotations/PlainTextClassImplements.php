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

use KeepUpdate\ClassDoesNotExistException;
use KeepUpdate\WrongImplementationException;

/**
 * @Annotation
 *
 */
class PlainTextClassImplements
{
    /**
     * @var string
     */
    public $interface;
    /**
     * @var boolean
     */
    public $nullable;

    public function exec($value)
    {
        if ($this->nullable === true && $value === null) {
            return;
        }

        if (false === class_exists($value, true)) {
            throw new ClassDoesNotExistException(sprintf('Class "%s" does not exist', $value));
        }

        if (in_array($this->interface, class_implements($value)) === false) {
            throw new WrongImplementationException(sprintf('Class "%s" must implement "%s"', $this->interface, $value));
        }
    }
}
