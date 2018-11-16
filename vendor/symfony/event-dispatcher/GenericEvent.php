<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\EventDispatcher;

/**
 * Event encapsulation class.
 *
 * Encapsulates events thus decoupling the observer from the subject they encapsulate.
 *
 * @author Drak <drak@zikula.org>
 */
class GenericEvent extends Event implements \ArrayAccess, \IteratorAggregate
{
<<<<<<< HEAD
    /**
     * Event subject.
     *
     * @var mixed usually object or callable
     */
    protected $subject;

    /**
     * Array of arguments.
     *
     * @var array
     */
=======
    protected $subject;
>>>>>>> git-aline/master/master
    protected $arguments;

    /**
     * Encapsulate an event with $subject and $args.
     *
<<<<<<< HEAD
     * @param mixed $subject   The subject of the event, usually an object.
     * @param array $arguments Arguments to store in the event.
=======
     * @param mixed $subject   The subject of the event, usually an object or a callable
     * @param array $arguments Arguments to store in the event
>>>>>>> git-aline/master/master
     */
    public function __construct($subject = null, array $arguments = array())
    {
        $this->subject = $subject;
        $this->arguments = $arguments;
    }

    /**
     * Getter for subject property.
     *
<<<<<<< HEAD
     * @return mixed $subject The observer subject.
=======
     * @return mixed $subject The observer subject
>>>>>>> git-aline/master/master
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Get argument by key.
     *
<<<<<<< HEAD
     * @param string $key Key.
     *
     * @throws \InvalidArgumentException If key is not found.
     *
     * @return mixed Contents of array key.
=======
     * @param string $key Key
     *
     * @return mixed Contents of array key
     *
     * @throws \InvalidArgumentException if key is not found
>>>>>>> git-aline/master/master
     */
    public function getArgument($key)
    {
        if ($this->hasArgument($key)) {
            return $this->arguments[$key];
        }

        throw new \InvalidArgumentException(sprintf('Argument "%s" not found.', $key));
    }

    /**
     * Add argument to event.
     *
<<<<<<< HEAD
     * @param string $key   Argument name.
     * @param mixed  $value Value.
     *
     * @return GenericEvent
=======
     * @param string $key   Argument name
     * @param mixed  $value Value
     *
     * @return $this
>>>>>>> git-aline/master/master
     */
    public function setArgument($key, $value)
    {
        $this->arguments[$key] = $value;

        return $this;
    }

    /**
     * Getter for all arguments.
     *
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * Set args property.
     *
<<<<<<< HEAD
     * @param array $args Arguments.
     *
     * @return GenericEvent
=======
     * @param array $args Arguments
     *
     * @return $this
>>>>>>> git-aline/master/master
     */
    public function setArguments(array $args = array())
    {
        $this->arguments = $args;

        return $this;
    }

    /**
     * Has argument.
     *
<<<<<<< HEAD
     * @param string $key Key of arguments array.
=======
     * @param string $key Key of arguments array
>>>>>>> git-aline/master/master
     *
     * @return bool
     */
    public function hasArgument($key)
    {
        return array_key_exists($key, $this->arguments);
    }

    /**
     * ArrayAccess for argument getter.
     *
<<<<<<< HEAD
     * @param string $key Array key.
     *
     * @throws \InvalidArgumentException If key does not exist in $this->args.
     *
     * @return mixed
=======
     * @param string $key Array key
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException if key does not exist in $this->args
>>>>>>> git-aline/master/master
     */
    public function offsetGet($key)
    {
        return $this->getArgument($key);
    }

    /**
     * ArrayAccess for argument setter.
     *
<<<<<<< HEAD
     * @param string $key   Array key to set.
     * @param mixed  $value Value.
=======
     * @param string $key   Array key to set
     * @param mixed  $value Value
>>>>>>> git-aline/master/master
     */
    public function offsetSet($key, $value)
    {
        $this->setArgument($key, $value);
    }

    /**
     * ArrayAccess for unset argument.
     *
<<<<<<< HEAD
     * @param string $key Array key.
=======
     * @param string $key Array key
>>>>>>> git-aline/master/master
     */
    public function offsetUnset($key)
    {
        if ($this->hasArgument($key)) {
            unset($this->arguments[$key]);
        }
    }

    /**
     * ArrayAccess has argument.
     *
<<<<<<< HEAD
     * @param string $key Array key.
=======
     * @param string $key Array key
>>>>>>> git-aline/master/master
     *
     * @return bool
     */
    public function offsetExists($key)
    {
        return $this->hasArgument($key);
    }

    /**
     * IteratorAggregate for iterating over the object like an array.
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->arguments);
    }
}
