<?php

namespace KeepUpdate\Annotations;

use KeepUpdate\ValidationException;

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
            throw new ValidationException(sprintf('Class "%s" does not exist', $value));
        }

        if (in_array($this->interface, class_implements($value)) === false) {
            throw new ValidationException(sprintf('Class "%s" must implement "%s"', $this->interface, $value));
        }
    }
}
