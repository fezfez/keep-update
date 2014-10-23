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
use Doctrine\Common\Annotations\AnnotationReader;

class ArrayValidatorFactory
{
    /**
     * @return \KeepUpdate\ArrayValidator
     */
    public static function getInstance()
    {
        return new ArrayValidator(
            new Instantiator(),
            new AnnotationDAO(new AnnotationReader()),
            new PropertyDAO()
        );
    }
}
