<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Debug;

/**
 * Registers all the debug tools.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Debug
{
    private static $enabled = false;

    /**
     * Enables the debug tools.
     *
<<<<<<< HEAD
     * This method registers an error handler and an exception handler.
     *
     * If the Symfony ClassLoader component is available, a special
     * class loader is also registered.
=======
     * This method registers an error handler, an exception handler and a special class loader.
>>>>>>> git-aline/master/master
     *
     * @param int  $errorReportingLevel The level of error reporting you want
     * @param bool $displayErrors       Whether to display errors (for development) or just log them (for production)
     */
<<<<<<< HEAD
    public static function enable($errorReportingLevel = null, $displayErrors = true)
=======
    public static function enable($errorReportingLevel = E_ALL, $displayErrors = true)
>>>>>>> git-aline/master/master
    {
        if (static::$enabled) {
            return;
        }

        static::$enabled = true;

        if (null !== $errorReportingLevel) {
            error_reporting($errorReportingLevel);
        } else {
<<<<<<< HEAD
            error_reporting(-1);
        }

        if ('cli' !== php_sapi_name()) {
=======
            error_reporting(E_ALL);
        }

        if (!\in_array(\PHP_SAPI, array('cli', 'phpdbg'), true)) {
>>>>>>> git-aline/master/master
            ini_set('display_errors', 0);
            ExceptionHandler::register();
        } elseif ($displayErrors && (!ini_get('log_errors') || ini_get('error_log'))) {
            // CLI - display errors only if they're not already logged to STDERR
            ini_set('display_errors', 1);
        }
<<<<<<< HEAD
        $handler = ErrorHandler::register();
        if (!$displayErrors) {
            $handler->throwAt(0, true);
=======
        if ($displayErrors) {
            ErrorHandler::register(new ErrorHandler(new BufferingLogger()));
        } else {
            ErrorHandler::register()->throwAt(0, true);
>>>>>>> git-aline/master/master
        }

        DebugClassLoader::enable();
    }
}
