<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Process;

/**
 * An executable finder specifically designed for the PHP executable.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class PhpExecutableFinder
{
    private $executableFinder;

    public function __construct()
    {
        $this->executableFinder = new ExecutableFinder();
    }

    /**
     * Finds The PHP executable.
     *
     * @param bool $includeArgs Whether or not include command arguments
     *
     * @return string|false The PHP executable path or false if it cannot be found
     */
    public function find($includeArgs = true)
    {
<<<<<<< HEAD
        // HHVM support
        if (defined('HHVM_VERSION')) {
            return (getenv('PHP_BINARY') ?: PHP_BINARY).($includeArgs ? ' '.implode(' ', $this->findArguments()) : '');
        }

        // PHP_BINARY return the current sapi executable
        if (defined('PHP_BINARY') && PHP_BINARY && in_array(PHP_SAPI, array('cli', 'cli-server')) && is_file(PHP_BINARY)) {
            return PHP_BINARY;
        }

        if ($php = getenv('PHP_PATH')) {
            if (!is_executable($php)) {
=======
        $args = $this->findArguments();
        $args = $includeArgs && $args ? ' '.implode(' ', $args) : '';

        // HHVM support
        if (\defined('HHVM_VERSION')) {
            return (getenv('PHP_BINARY') ?: PHP_BINARY).$args;
        }

        // PHP_BINARY return the current sapi executable
        if (PHP_BINARY && \in_array(\PHP_SAPI, array('cli', 'cli-server', 'phpdbg'), true)) {
            return PHP_BINARY.$args;
        }

        if ($php = getenv('PHP_PATH')) {
            if (!@is_executable($php)) {
>>>>>>> git-aline/master/master
                return false;
            }

            return $php;
        }

        if ($php = getenv('PHP_PEAR_PHP_BIN')) {
<<<<<<< HEAD
            if (is_executable($php)) {
=======
            if (@is_executable($php)) {
>>>>>>> git-aline/master/master
                return $php;
            }
        }

<<<<<<< HEAD
        $dirs = array(PHP_BINDIR);
        if ('\\' === DIRECTORY_SEPARATOR) {
=======
        if (@is_executable($php = PHP_BINDIR.('\\' === \DIRECTORY_SEPARATOR ? '\\php.exe' : '/php'))) {
            return $php;
        }

        $dirs = array(PHP_BINDIR);
        if ('\\' === \DIRECTORY_SEPARATOR) {
>>>>>>> git-aline/master/master
            $dirs[] = 'C:\xampp\php\\';
        }

        return $this->executableFinder->find('php', false, $dirs);
    }

    /**
     * Finds the PHP executable arguments.
     *
     * @return array The PHP executable arguments
     */
    public function findArguments()
    {
        $arguments = array();

<<<<<<< HEAD
        // HHVM support
        if (defined('HHVM_VERSION')) {
            $arguments[] = '--php';
=======
        if (\defined('HHVM_VERSION')) {
            $arguments[] = '--php';
        } elseif ('phpdbg' === \PHP_SAPI) {
            $arguments[] = '-qrr';
>>>>>>> git-aline/master/master
        }

        return $arguments;
    }
}
