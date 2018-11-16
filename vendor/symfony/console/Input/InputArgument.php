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
 * Represents a command line argument.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class InputArgument
{
    const REQUIRED = 1;
    const OPTIONAL = 2;
    const IS_ARRAY = 4;

    private $name;
    private $mode;
    private $default;
    private $description;

    /**
<<<<<<< HEAD
     * Constructor.
     *
=======
>>>>>>> git-aline/master/master
     * @param string $name        The argument name
     * @param int    $mode        The argument mode: self::REQUIRED or self::OPTIONAL
     * @param string $description A description text
     * @param mixed  $default     The default value (for self::OPTIONAL mode only)
     *
<<<<<<< HEAD
     * @throws \InvalidArgumentException When argument mode is not valid
=======
     * @throws InvalidArgumentException When argument mode is not valid
>>>>>>> git-aline/master/master
     */
    public function __construct($name, $mode = null, $description = '', $default = null)
    {
        if (null === $mode) {
            $mode = self::OPTIONAL;
<<<<<<< HEAD
        } elseif (!is_int($mode) || $mode > 7 || $mode < 1) {
            throw new \InvalidArgumentException(sprintf('Argument mode "%s" is not valid.', $mode));
=======
        } elseif (!\is_int($mode) || $mode > 7 || $mode < 1) {
            throw new InvalidArgumentException(sprintf('Argument mode "%s" is not valid.', $mode));
>>>>>>> git-aline/master/master
        }

        $this->name = $name;
        $this->mode = $mode;
        $this->description = $description;

        $this->setDefault($default);
    }

    /**
     * Returns the argument name.
     *
     * @return string The argument name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns true if the argument is required.
     *
     * @return bool true if parameter mode is self::REQUIRED, false otherwise
     */
    public function isRequired()
    {
        return self::REQUIRED === (self::REQUIRED & $this->mode);
    }

    /**
     * Returns true if the argument can take multiple values.
     *
     * @return bool true if mode is self::IS_ARRAY, false otherwise
     */
    public function isArray()
    {
        return self::IS_ARRAY === (self::IS_ARRAY & $this->mode);
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
        if (self::REQUIRED === $this->mode && null !== $default) {
<<<<<<< HEAD
            throw new \LogicException('Cannot set a default value except for InputArgument::OPTIONAL mode.');
=======
            throw new LogicException('Cannot set a default value except for InputArgument::OPTIONAL mode.');
>>>>>>> git-aline/master/master
        }

        if ($this->isArray()) {
            if (null === $default) {
                $default = array();
<<<<<<< HEAD
            } elseif (!is_array($default)) {
                throw new \LogicException('A default value for an array argument must be an array.');
=======
            } elseif (!\is_array($default)) {
                throw new LogicException('A default value for an array argument must be an array.');
>>>>>>> git-aline/master/master
            }
        }

        $this->default = $default;
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
}
