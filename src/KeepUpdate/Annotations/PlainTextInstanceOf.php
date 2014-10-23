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
use KeepUpdate\InvalidTypeException;

/**
 * @Annotation
 *
 */
class PlainTextInstanceOf
{
    /**
     * @var string
     */
    public $class;
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

        if ($this->class !== $value) {
            throw new InvalidTypeException(sprintf('Class "%s" must be "%s"', $this->class, $value));
        }
    }
}
