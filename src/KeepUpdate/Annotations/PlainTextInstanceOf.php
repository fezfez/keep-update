<?php

namespace KeepUpdate\Annotations;

use KeepUpdate\ValidationException;

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
            throw new ValidationException(sprintf('Class "%s" does not exist', $value));
        }

        if ($this->class !== $value) {
            throw new ValidationException(sprintf('Class "%s" must be "%s"', $this->class, $value));
        }
    }
}
