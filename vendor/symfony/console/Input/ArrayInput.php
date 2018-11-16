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
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Exception\InvalidOptionException;

>>>>>>> git-aline/master/master
/**
 * ArrayInput represents an input provided as an array.
 *
 * Usage:
 *
 *     $input = new ArrayInput(array('name' => 'foo', '--bar' => 'foobar'));
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class ArrayInput extends Input
{
    private $parameters;

<<<<<<< HEAD
    /**
     * Constructor.
     *
     * @param array           $parameters An array of parameters
     * @param InputDefinition $definition A InputDefinition instance
     */
=======
>>>>>>> git-aline/master/master
    public function __construct(array $parameters, InputDefinition $definition = null)
    {
        $this->parameters = $parameters;

        parent::__construct($definition);
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
        foreach ($this->parameters as $key => $value) {
            if ($key && '-' === $key[0]) {
                continue;
            }

            return $value;
        }
    }

    /**
<<<<<<< HEAD
     * Returns true if the raw parameters (not parsed) contain a value.
     *
     * This method is to be used to introspect the input parameters
     * before they have been validated. It must be used carefully.
     *
     * @param string|array $values The values to look for in the raw parameters (can be an array)
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

        foreach ($this->parameters as $k => $v) {
<<<<<<< HEAD
            if (!is_int($k)) {
                $v = $k;
            }

            if (in_array($v, $values)) {
=======
            if (!\is_int($k)) {
                $v = $k;
            }

            if ($onlyParams && '--' === $v) {
                return false;
            }

            if (\in_array($v, $values)) {
>>>>>>> git-aline/master/master
                return true;
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

        foreach ($this->parameters as $k => $v) {
<<<<<<< HEAD
            if (is_int($k)) {
                if (in_array($v, $values)) {
                    return true;
                }
            } elseif (in_array($k, $values)) {
=======
            if ($onlyParams && ('--' === $k || (\is_int($k) && '--' === $v))) {
                return $default;
            }

            if (\is_int($k)) {
                if (\in_array($v, $values)) {
                    return true;
                }
            } elseif (\in_array($k, $values)) {
>>>>>>> git-aline/master/master
                return $v;
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
        $params = array();
        foreach ($this->parameters as $param => $val) {
            if ($param && '-' === $param[0]) {
<<<<<<< HEAD
                $params[] = $param.('' != $val ? '='.$this->escapeToken($val) : '');
            } else {
                $params[] = $this->escapeToken($val);
=======
                if (\is_array($val)) {
                    foreach ($val as $v) {
                        $params[] = $param.('' != $v ? '='.$this->escapeToken($v) : '');
                    }
                } else {
                    $params[] = $param.('' != $val ? '='.$this->escapeToken($val) : '');
                }
            } else {
                $params[] = \is_array($val) ? implode(' ', array_map(array($this, 'escapeToken'), $val)) : $this->escapeToken($val);
>>>>>>> git-aline/master/master
            }
        }

        return implode(' ', $params);
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
        foreach ($this->parameters as $key => $value) {
<<<<<<< HEAD
=======
            if ('--' === $key) {
                return;
            }
>>>>>>> git-aline/master/master
            if (0 === strpos($key, '--')) {
                $this->addLongOption(substr($key, 2), $value);
            } elseif ('-' === $key[0]) {
                $this->addShortOption(substr($key, 1), $value);
            } else {
                $this->addArgument($key, $value);
            }
        }
    }

    /**
     * Adds a short option value.
     *
     * @param string $shortcut The short option key
     * @param mixed  $value    The value for the option
     *
<<<<<<< HEAD
     * @throws \InvalidArgumentException When option given doesn't exist
=======
     * @throws InvalidOptionException When option given doesn't exist
>>>>>>> git-aline/master/master
     */
    private function addShortOption($shortcut, $value)
    {
        if (!$this->definition->hasShortcut($shortcut)) {
<<<<<<< HEAD
            throw new \InvalidArgumentException(sprintf('The "-%s" option does not exist.', $shortcut));
=======
            throw new InvalidOptionException(sprintf('The "-%s" option does not exist.', $shortcut));
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
     * @throws \InvalidArgumentException When option given doesn't exist
     * @throws \InvalidArgumentException When a required value is missing
=======
     * @throws InvalidOptionException When option given doesn't exist
     * @throws InvalidOptionException When a required value is missing
>>>>>>> git-aline/master/master
     */
    private function addLongOption($name, $value)
    {
        if (!$this->definition->hasOption($name)) {
<<<<<<< HEAD
            throw new \InvalidArgumentException(sprintf('The "--%s" option does not exist.', $name));
=======
            throw new InvalidOptionException(sprintf('The "--%s" option does not exist.', $name));
>>>>>>> git-aline/master/master
        }

        $option = $this->definition->getOption($name);

        if (null === $value) {
            if ($option->isValueRequired()) {
<<<<<<< HEAD
                throw new \InvalidArgumentException(sprintf('The "--%s" option requires a value.', $name));
            }

            $value = $option->isValueOptional() ? $option->getDefault() : true;
=======
                throw new InvalidOptionException(sprintf('The "--%s" option requires a value.', $name));
            }

            if (!$option->isValueOptional()) {
                $value = true;
            }
>>>>>>> git-aline/master/master
        }

        $this->options[$name] = $value;
    }

    /**
     * Adds an argument value.
     *
     * @param string $name  The argument name
     * @param mixed  $value The value for the argument
     *
<<<<<<< HEAD
     * @throws \InvalidArgumentException When argument given doesn't exist
=======
     * @throws InvalidArgumentException When argument given doesn't exist
>>>>>>> git-aline/master/master
     */
    private function addArgument($name, $value)
    {
        if (!$this->definition->hasArgument($name)) {
<<<<<<< HEAD
            throw new \InvalidArgumentException(sprintf('The "%s" argument does not exist.', $name));
=======
            throw new InvalidArgumentException(sprintf('The "%s" argument does not exist.', $name));
>>>>>>> git-aline/master/master
        }

        $this->arguments[$name] = $value;
    }
}
