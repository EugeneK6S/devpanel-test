<?php

/*
 * This file is part of Twig.
 *
<<<<<<< HEAD
 * (c) 2009 Fabien Potencier
=======
 * (c) Fabien Potencier
>>>>>>> git-aline/master/master
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

<<<<<<< HEAD
@trigger_error('The Twig_Autoloader class is deprecated and will be removed in 2.0. Use Composer instead.', E_USER_DEPRECATED);
=======
@trigger_error('The Twig_Autoloader class is deprecated since version 1.21 and will be removed in 2.0. Use Composer instead.', E_USER_DEPRECATED);
>>>>>>> git-aline/master/master

/**
 * Autoloads Twig classes.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
<<<<<<< HEAD
 * @deprecated Use Composer instead. Will be removed in Twig 2.0.
=======
 * @deprecated since 1.21 and will be removed in 2.0. Use Composer instead. 2.0.
>>>>>>> git-aline/master/master
 */
class Twig_Autoloader
{
    /**
     * Registers Twig_Autoloader as an SPL autoloader.
     *
<<<<<<< HEAD
     * @param bool $prepend Whether to prepend the autoloader or not.
     */
    public static function register($prepend = false)
    {
        @trigger_error('Using Twig_Autoloader is deprecated. Use Composer instead.', E_USER_DEPRECATED);
=======
     * @param bool $prepend whether to prepend the autoloader or not
     */
    public static function register($prepend = false)
    {
        @trigger_error('Using Twig_Autoloader is deprecated since version 1.21. Use Composer instead.', E_USER_DEPRECATED);
>>>>>>> git-aline/master/master

        if (PHP_VERSION_ID < 50300) {
            spl_autoload_register(array(__CLASS__, 'autoload'));
        } else {
            spl_autoload_register(array(__CLASS__, 'autoload'), true, $prepend);
        }
    }

    /**
     * Handles autoloading of classes.
     *
<<<<<<< HEAD
     * @param string $class A class name.
=======
     * @param string $class a class name
>>>>>>> git-aline/master/master
     */
    public static function autoload($class)
    {
        if (0 !== strpos($class, 'Twig')) {
            return;
        }

        if (is_file($file = dirname(__FILE__).'/../'.str_replace(array('_', "\0"), array('/', ''), $class).'.php')) {
            require $file;
        }
    }
}
