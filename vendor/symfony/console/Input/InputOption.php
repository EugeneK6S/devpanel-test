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
use Symfony\Component\Console\Exception\LogicException;

>>>>>>> git-aline/master/master
/**
 * Represents a command line option.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class InputOption
{
    const VALUE_NONE = 1;
    const VALUE_REQUIRED = 2;
    const VALUE_OPTIONAL = 4;
    const VALUE_IS_ARRAY = 8;

    private $name;
    private $shortcut;
    private $mode;
    private $default;
    private $description;

    /**
<<<<<<< HEAD
     * Constructor.
     *
=======
>>>>>>> git-aline/master/master
     * @param string       $name        The option name
     * @param string|array $shortcut    The shortcuts, can be null, a string of shortcuts delimited by | or an array of shortcuts
     * @param int          $mode        The option mode: One of the VALUE_* constants
     * @param string       $description A description text
<<<<<<< HEAD
     * @param mixed        $default     The default value (must be null for self::VALUE_REQUIRED or self::VALUE_NONE)
     *
     * @throws \InvalidArgumentException If option mode is invalid or incompatible
=======
     * @param mixed        $default     The default value (must be null for self::VALUE_NONE)
     *
     * @throws InvalidArgumentException If option mode is invalid or incompatible
>>>>>>> git-aline/master/master
     */
    public function __construct($name, $shortcut = null, $mode = null, $description = '', $default = null)
    {
        if (0 === strpos($name, '--')) {
            $name = substr($name, 2);
        }

        if (empty($name)) {
<<<<<<< HEAD
            throw new \InvalidArgumentException('An option name cannot be empty.');
=======
            throw new InvalidArgumentException('An option name cannot be empty.');
>>>>>>> git-aline/master/master
        }

        if (empty($shortcut)) {
            $shortcut = null;
        }

        if (null !== $shortcut) {
<<<<<<< HEAD
            if (is_array($shortcut)) {
=======
            if (\is_array($shortcut)) {
>>>>>>> git-aline/master/master
                $shortcut = implode('|', $shortcut);
            }
            $shortcuts = preg_split('{(\|)-?}', ltrim($shortcut, '-'));
            $shortcuts = array_filter($shortcuts);
            $shortcut = implode('|', $shortcuts);

            if (empty($shortcut)) {
<<<<<<< HEAD
                throw new \InvalidArgumentException('An option shortcut cannot be empty.');
=======
                throw new InvalidArgumentException('An option shortcut cannot be empty.');
>>>>>>> git-aline/master/master
            }
        }

        if (null === $mode) {
            $mode = self::VALUE_NONE;
<<<<<<< HEAD
        } elseif (!is_int($mode) || $mode > 15 || $mode < 1) {
            throw new \InvalidArgumentException(sprintf('Option mode "%s" is not valid.', $mode));
=======
        } elseif (!\is_int($mode) || $mode > 15 || $mode < 1) {
            throw new InvalidArgumentException(sprintf('Option mode "%s" is not valid.', $mode));
>>>>>>> git-aline/master/master
        }

        $this->name = $name;
        $this->shortcut = $shortcut;
        $this->mode = $mode;
        $this->description = $description;

        if ($this->isArray() && !$this->acceptValue()) {
<<<<<<< HEAD
            throw new \InvalidArgumentException('Impossible to have an option mode VALUE_IS_ARRAY if the option does not accept a value.');
=======
            throw new InvalidArgumentException('Impossible to have an option mode VALUE_IS_ARRAY if the option does not accept a value.');
>>>>>>> git-aline/master/master
        }

        $this->setDefault($default);
    }

    /**
     * Returns the option shortcut.
     *
     * @return string The shortcut
     */
    public function getShortcut()
    {
        return $this->shortcut;
    }

    /**
     * Returns the option name.
     *
     * @return string The name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns true if the option accepts a value.
     *
     * @return bool true if value mode is not self::VALUE_NONE, false otherwise
     */
    public function acceptValue()
    {
        return $this->isValueRequired() || $this->isValueOptional();
    }

    /**
     * Returns true if the option requires a value.
     *
     * @return bool true if value mode is self::VALUE_REQUIRED, false otherwise
     */
    public function isValueRequired()
    {
        return self::VALUE_REQUIRED === (self::VALUE_REQUIRED & $this->mode);
    }

    /**
     * Returns true if the option takes an optional value.
     *
     * @return bool true if value mode is self::VALUE_OPTIONAL, false otherwise
     */
    public function isValueOptional()
    {
        return self::VALUE_OPTIONAL === (self::VALUE_OPTIONAL & $this->mode);
    }

    /**
     * Returns true if the option can take multiple values.
     *
     * @return bool true if mode is self::VALUE_IS_ARRAY, false otherwise
     */
    public function isArray()
    {
        return self::VALUE_IS_ARRAY === (self::VALUE_IS_ARRAY & $this->mode);
    }

    /**
     * Sets the default value.
     *
     * @param mixed $default The default value
     *
<<<<<<< HEAD
     * @throws \LogicException When incorrect default value is given
=======
     * @throws LogicException When incorrect default value is given
>>>>>>> git-aline/master/master
     */
    public function setDefault($default = null)
    {
        if (self::VALUE_NONE === (self::VALUE_NONE & $this->mode) && null !== $default) {
<<<<<<< HEAD
            throw new \LogicException('Cannot set a default value when using InputOption::VALUE_NONE mode.');
=======
            throw new LogicException('Cannot set a default value when using InputOption::VALUE_NONE mode.');
>>>>>>> git-aline/master/master
        }

        if ($this->isArray()) {
            if (null === $default) {
                $default = array();
<<<<<<< HEAD
            } elseif (!is_array($default)) {
                throw new \LogicException('A default value for an array option must be an array.');
=======
            } elseif (!\is_array($default)) {
                throw new LogicException('A default value for an array option must be an array.');
>>>>>>> git-aline/master/master
            }
        }

        $this->default = $this->acceptValue() ? $default : false;
    }

    /**
     * Returns the default value.
     *
     * @return mixed The default value
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * Returns the description text.
     *
     * @return string The description text
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Checks whether the given option equals this one.
     *
<<<<<<< HEAD
     * @param InputOption $option option to compare
     *
     * @return bool
     */
    public function equals(InputOption $option)
=======
     * @return bool
     */
    public function equals(self $option)
>>>>>>> git-aline/master/master
    {
        return $option->getName() === $this->getName()
            && $option->getShortcut() === $this->getShortcut()
            && $option->getDefault() === $this->getDefault()
            && $option->isArray() === $this->isArray()
            && $option->isValueRequired() === $this->isValueRequired()
            && $option->isValueOptional() === $this->isValueOptional()
        ;
    }
}
