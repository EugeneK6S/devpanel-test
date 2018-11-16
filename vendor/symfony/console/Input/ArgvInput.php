<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Input;

<<<<<<< HEAD
=======
use Symfony\Component\Console\Exception\RuntimeException;

>>>>>>> git-aline/master/master
/**
 * ArgvInput represents an input coming from the CLI arguments.
 *
 * Usage:
 *
 *     $input = new ArgvInput();
 *
 * By default, the `$_SERVER['argv']` array is used for the input values.
 *
 * This can be overridden by explicitly passing the input values in the constructor:
 *
 *     $input = new ArgvInput($_SERVER['argv']);
 *
 * If you pass it yourself, don't forget that the first element of the array
 * is the name of the running application.
 *
 * When passing an argument to the constructor, be sure that it respects
 * the same rules as the argv one. It's almost always better to use the
 * `StringInput` when you want to provide your own input.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @see http://www.gnu.org/software/libc/manual/html_node/Argument-Syntax.html
 * @see http://www.opengroup.org/onlinepubs/009695399/basedefs/xbd_chap12.html#tag_12_02
 */
class ArgvInput extends Input
{
    private $tokens;
    private $parsed;

    /**
<<<<<<< HEAD
     * Constructor.
     *
     * @param array           $argv       An array of parameters from the CLI (in the argv format)
     * @param InputDefinition $definition A InputDefinition instance
=======
     * @param array|null           $argv       An array of parameters from the CLI (in the argv format)
     * @param InputDefinition|null $definition A InputDefinition instance
>>>>>>> git-aline/master/master
     */
    public function __construct(array $argv = null, InputDefinition $definition = null)
    {
        if (null === $argv) {
            $argv = $_SERVER['argv'];
        }

        // strip the application name
        array_shift($argv);

        $this->tokens = $argv;

        parent::__construct($definition);
    }

    protected function setTokens(array $tokens)
    {
        $this->tokens = $tokens;
    }

    /**
<<<<<<< HEAD
     * Processes command line arguments.
=======
     * {@inheritdoc}
>>>>>>> git-aline/master/master
     */
    protected function parse()
    {
        $parseOptions = true;
        $this->parsed = $this->tokens;
        while (null !== $token = array_shift($this->parsed)) {
            if ($parseOptions && '' == $token) {
                $this->parseArgument($token);
            } elseif ($parseOptions && '--' == $token) {
                $parseOptions = false;
            } elseif ($parseOptions && 0 === strpos($token, '--')) {
                $this->parseLongOption($token);
            } elseif ($parseOptions && '-' === $token[0] && '-' !== $token) {
                $this->parseShortOption($token);
            } else {
                $this->parseArgument($token);
            }
        }
    }

    /**
     * Parses a short option.
     *
<<<<<<< HEAD
     * @param string $token The current token.
=======
     * @param string $token The current token
>>>>>>> git-aline/master/master
     */
    private function parseShortOption($token)
    {
        $name = substr($token, 1);

<<<<<<< HEAD
        if (strlen($name) > 1) {
=======
        if (\strlen($name) > 1) {
>>>>>>> git-aline/master/master
            if ($this->definition->hasShortcut($name[0]) && $this->definition->getOptionForShortcut($name[0])->acceptValue()) {
                // an option with a value (with no space)
                $this->addShortOption($name[0], substr($name, 1));
            } else {
                $this->parseShortOptionSet($name);
            }
        } else {
            $this->addShortOption($name, null);
        }
    }

    /**
     * Parses a short option set.
     *
     * @param string $name The current token
     *
<<<<<<< HEAD
     * @throws \RuntimeException When option given doesn't exist
     */
    private function parseShortOptionSet($name)
    {
        $len = strlen($name);
        for ($i = 0; $i < $len; ++$i) {
            if (!$this->definition->hasShortcut($name[$i])) {
                throw new \RuntimeException(sprintf('The "-%s" option does not exist.', $name[$i]));
=======
     * @throws RuntimeException When option given doesn't exist
     */
    private function parseShortOptionSet($name)
    {
        $len = \strlen($name);
        for ($i = 0; $i < $len; ++$i) {
            if (!$this->definition->hasShortcut($name[$i])) {
                throw new RuntimeException(sprintf('The "-%s" option does not exist.', $name[$i]));
>>>>>>> git-aline/master/master
            }

            $option = $this->definition->getOptionForShortcut($name[$i]);
            if ($option->acceptValue()) {
                $this->addLongOption($option->getName(), $i === $len - 1 ? null : substr($name, $i + 1));

                break;
            } else {
                $this->addLongOption($option->getName(), null);
            }
        }
    }

    /**
     * Parses a long option.
     *
     * @param string $token The current token
     */
    private function parseLongOption($token)
    {
        $name = substr($token, 2);

        if (false !== $pos = strpos($name, '=')) {
<<<<<<< HEAD
            $this->addLongOption(substr($name, 0, $pos), substr($name, $pos + 1));
=======
            if (0 === \strlen($value = substr($name, $pos + 1))) {
                // if no value after "=" then substr() returns "" since php7 only, false before
                // see http://php.net/manual/fr/migration70.incompatible.php#119151
                if (\PHP_VERSION_ID < 70000 && false === $value) {
                    $value = '';
                }
                array_unshift($this->parsed, $value);
            }
            $this->addLongOption(substr($name, 0, $pos), $value);
>>>>>>> git-aline/master/master
        } else {
            $this->addLongOption($name, null);
        }
    }

    /**
     * Parses an argument.
     *
     * @param string $token The current token
     *
<<<<<<< HEAD
     * @throws \RuntimeException When too many arguments are given
     */
    private function parseArgument($token)
    {
        $c = count($this->arguments);
=======
     * @throws RuntimeException When too many arguments are given
     */
    private function parseArgument($token)
    {
        $c = \count($this->arguments);
>>>>>>> git-aline/master/master

        // if input is expecting another argument, add it
        if ($this->definition->hasArgument($c)) {
            $arg = $this->definition->getArgument($c);
            $this->arguments[$arg->getName()] = $arg->isArray() ? array($token) : $token;

        // if last argument isArray(), append token to last argument
        } elseif ($this->definition->hasArgument($c - 1) && $this->definition->getArgument($c - 1)->isArray()) {
            $arg = $this->definition->getArgument($c - 1);
            $this->arguments[$arg->getName()][] = $token;

        // unexpected argument
        } else {
<<<<<<< HEAD
            throw new \RuntimeException('Too many arguments.');
=======
            $all = $this->definition->getArguments();
            if (\count($all)) {
                throw new RuntimeException(sprintf('Too many arguments, expected arguments "%s".', implode('" "', array_keys($all))));
            }

            throw new RuntimeException(sprintf('No arguments expected, got "%s".', $token));
>>>>>>> git-aline/master/master
        }
    }

    /**
     * Adds a short option value.
     *
     * @param string $shortcut The short option key
     * @param mixed  $value    The value for the option
     *
<<<<<<< HEAD
     * @throws \RuntimeException When option given doesn't exist
=======
     * @throws RuntimeException When option given doesn't exist
>>>>>>> git-aline/master/master
     */
    private function addShortOption($shortcut, $value)
    {
        if (!$this->definition->hasShortcut($shortcut)) {
<<<<<<< HEAD
            throw new \RuntimeException(sprintf('The "-%s" option does not exist.', $shortcut));
=======
            throw new RuntimeException(sprintf('The "-%s" option does not exist.', $shortcut));
>>>>>>> git-aline/master/master
        }

        $this->addLongOption($this->definition->getOptionForShortcut($shortcut)->getName(), $value);
    }

    /**
     * Adds a long option value.
     *
     * @param string $name  The long option key
     * @param mixed  $value The value for the option
     *
<<<<<<< HEAD
     * @throws \RuntimeException When option given doesn't exist
=======
     * @throws RuntimeException When option given doesn't exist
>>>>>>> git-aline/master/master
     */
    private function addLongOption($name, $value)
    {
        if (!$this->definition->hasOption($name)) {
<<<<<<< HEAD
            throw new \RuntimeException(sprintf('The "--%s" option does not exist.', $name));
=======
            throw new RuntimeException(sprintf('The "--%s" option does not exist.', $name));
>>>>>>> git-aline/master/master
        }

        $option = $this->definition->getOption($name);

<<<<<<< HEAD
        // Convert empty values to null
        if (!isset($value[0])) {
            $value = null;
        }

        if (null !== $value && !$option->acceptValue()) {
            throw new \RuntimeException(sprintf('The "--%s" option does not accept a value.', $name));
        }

        if (null === $value && $option->acceptValue() && count($this->parsed)) {
            // if option accepts an optional or mandatory argument
            // let's see if there is one provided
            $next = array_shift($this->parsed);
            if (isset($next[0]) && '-' !== $next[0]) {
                $value = $next;
            } elseif (empty($next)) {
                $value = '';
=======
        if (null !== $value && !$option->acceptValue()) {
            throw new RuntimeException(sprintf('The "--%s" option does not accept a value.', $name));
        }

        if (\in_array($value, array('', null), true) && $option->acceptValue() && \count($this->parsed)) {
            // if option accepts an optional or mandatory argument
            // let's see if there is one provided
            $next = array_shift($this->parsed);
            if ((isset($next[0]) && '-' !== $next[0]) || \in_array($next, array('', null), true)) {
                $value = $next;
>>>>>>> git-aline/master/master
            } else {
                array_unshift($this->parsed, $next);
            }
        }

        if (null === $value) {
            if ($option->isValueRequired()) {
<<<<<<< HEAD
                throw new \RuntimeException(sprintf('The "--%s" option requires a value.', $name));
            }

            if (!$option->isArray()) {
                $value = $option->isValueOptional() ? $option->getDefault() : true;
=======
                throw new RuntimeException(sprintf('The "--%s" option requires a value.', $name));
            }

            if (!$option->isArray() && !$option->isValueOptional()) {
                $value = true;
>>>>>>> git-aline/master/master
            }
        }

        if ($option->isArray()) {
            $this->options[$name][] = $value;
        } else {
            $this->options[$name] = $value;
        }
    }

    /**
<<<<<<< HEAD
     * Returns the first argument from the raw parameters (not parsed).
     *
     * @return string The value of the first argument or null otherwise
=======
     * {@inheritdoc}
>>>>>>> git-aline/master/master
     */
    public function getFirstArgument()
    {
        foreach ($this->tokens as $token) {
            if ($token && '-' === $token[0]) {
                continue;
            }

            return $token;
        }
    }

    /**
<<<<<<< HEAD
     * Returns true if the raw parameters (not parsed) contain a value.
     *
     * This method is to be used to introspect the input parameters
     * before they have been validated. It must be used carefully.
     *
     * @param string|array $values The value(s) to look for in the raw parameters (can be an array)
     *
     * @return bool true if the value is contained in the raw parameters
     */
    public function hasParameterOption($values)
=======
     * {@inheritdoc}
     */
    public function hasParameterOption($values, $onlyParams = false)
>>>>>>> git-aline/master/master
    {
        $values = (array) $values;

        foreach ($this->tokens as $token) {
<<<<<<< HEAD
            foreach ($values as $value) {
                if ($token === $value || 0 === strpos($token, $value.'=')) {
=======
            if ($onlyParams && '--' === $token) {
                return false;
            }
            foreach ($values as $value) {
                // Options with values:
                //   For long options, test for '--option=' at beginning
                //   For short options, test for '-o' at beginning
                $leading = 0 === strpos($value, '--') ? $value.'=' : $value;
                if ($token === $value || '' !== $leading && 0 === strpos($token, $leading)) {
>>>>>>> git-aline/master/master
                    return true;
                }
            }
        }

        return false;
    }

    /**
<<<<<<< HEAD
     * Returns the value of a raw option (not parsed).
     *
     * This method is to be used to introspect the input parameters
     * before they have been validated. It must be used carefully.
     *
     * @param string|array $values  The value(s) to look for in the raw parameters (can be an array)
     * @param mixed        $default The default value to return if no result is found
     *
     * @return mixed The option value
     */
    public function getParameterOption($values, $default = false)
=======
     * {@inheritdoc}
     */
    public function getParameterOption($values, $default = false, $onlyParams = false)
>>>>>>> git-aline/master/master
    {
        $values = (array) $values;
        $tokens = $this->tokens;

<<<<<<< HEAD
        while (0 < count($tokens)) {
            $token = array_shift($tokens);

            foreach ($values as $value) {
                if ($token === $value || 0 === strpos($token, $value.'=')) {
                    if (false !== $pos = strpos($token, '=')) {
                        return substr($token, $pos + 1);
                    }

                    return array_shift($tokens);
                }
=======
        while (0 < \count($tokens)) {
            $token = array_shift($tokens);
            if ($onlyParams && '--' === $token) {
                return $default;
            }

            foreach ($values as $value) {
                if ($token === $value) {
                    return array_shift($tokens);
                }
                // Options with values:
                //   For long options, test for '--option=' at beginning
                //   For short options, test for '-o' at beginning
                $leading = 0 === strpos($value, '--') ? $value.'=' : $value;
                if ('' !== $leading && 0 === strpos($token, $leading)) {
                    return substr($token, \strlen($leading));
                }
>>>>>>> git-aline/master/master
            }
        }

        return $default;
    }

    /**
     * Returns a stringified representation of the args passed to the command.
     *
     * @return string
     */
    public function __toString()
    {
<<<<<<< HEAD
        $self = $this;
        $tokens = array_map(function ($token) use ($self) {
            if (preg_match('{^(-[^=]+=)(.+)}', $token, $match)) {
                return $match[1].$self->escapeToken($match[2]);
            }

            if ($token && $token[0] !== '-') {
                return $self->escapeToken($token);
=======
        $tokens = array_map(function ($token) {
            if (preg_match('{^(-[^=]+=)(.+)}', $token, $match)) {
                return $match[1].$this->escapeToken($match[2]);
            }

            if ($token && '-' !== $token[0]) {
                return $this->escapeToken($token);
>>>>>>> git-aline/master/master
            }

            return $token;
        }, $this->tokens);

        return implode(' ', $tokens);
    }
}
