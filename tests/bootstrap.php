<?php
/*
 * This file bootstraps the test environment.
 */
namespace KeepUpdate\Tests;

error_reporting(-1);
ini_set('memory_limit', '512M');

$vendorDir = __DIR__ . '/../vendor';

if (false === is_file($vendorDir . '/autoload.php')) {
    throw new \Exception("You must set up the project dependencies, run the following commands:
                    wget http://getcomposer.org/composer.phar
                    php composer.phar install
                    ");
} else {
    include($vendorDir . '/autoload.php');
}

// register silently failing autoloader
spl_autoload_register(function($class) {
    if (0 === strpos($class, 'KeepUpdate\Tests\\')) {
        $path = __DIR__ . '/' . strtr($class, '\\', '/') . '.php';
        if (is_file($path) === true && is_readable($path) === true) {
            require_once $path;

            return true;
        }
    }
});
