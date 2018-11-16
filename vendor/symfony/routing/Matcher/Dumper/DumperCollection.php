<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Matcher\Dumper;

/**
 * Collection of routes.
 *
 * @author Arnaud Le Blanc <arnaud.lb@gmail.com>
 *
 * @internal
 */
class DumperCollection implements \IteratorAggregate
{
    /**
     * @var DumperCollection|null
     */
    private $parent;

    /**
<<<<<<< HEAD
     * @var (DumperCollection|DumperRoute)[]
=======
     * @var DumperCollection[]|DumperRoute[]
>>>>>>> git-aline/master/master
     */
    private $children = array();

    /**
     * @var array
     */
    private $attributes = array();

    /**
     * Returns the children routes and collections.
     *
<<<<<<< HEAD
     * @return (DumperCollection|DumperRoute)[] Array of DumperCollection|DumperRoute
=======
     * @return self[]|DumperRoute[]
>>>>>>> git-aline/master/master
     */
    public function all()
    {
        return $this->children;
    }

    /**
     * Adds a route or collection.
     *
     * @param DumperRoute|DumperCollection The route or collection
     */
    public function add($child)
    {
        if ($child instanceof self) {
            $child->setParent($this);
        }
        $this->children[] = $child;
    }

    /**
     * Sets children.
     *
     * @param array $children The children
     */
    public function setAll(array $children)
    {
        foreach ($children as $child) {
            if ($child instanceof self) {
                $child->setParent($this);
            }
        }
        $this->children = $children;
    }

    /**
     * Returns an iterator over the children.
     *
<<<<<<< HEAD
     * @return \Iterator The iterator
=======
     * @return \Iterator|DumperCollection[]|DumperRoute[] The iterator
>>>>>>> git-aline/master/master
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->children);
    }

    /**
     * Returns the root of the collection.
     *
<<<<<<< HEAD
     * @return DumperCollection The root collection
=======
     * @return self The root collection
>>>>>>> git-aline/master/master
     */
    public function getRoot()
    {
        return (null !== $this->parent) ? $this->parent->getRoot() : $this;
    }

    /**
     * Returns the parent collection.
     *
<<<<<<< HEAD
     * @return DumperCollection|null The parent collection or null if the collection has no parent
=======
     * @return self|null The parent collection or null if the collection has no parent
>>>>>>> git-aline/master/master
     */
    protected function getParent()
    {
        return $this->parent;
    }

    /**
     * Sets the parent collection.
<<<<<<< HEAD
     *
     * @param DumperCollection $parent The parent collection
     */
    protected function setParent(DumperCollection $parent)
=======
     */
    protected function setParent(self $parent)
>>>>>>> git-aline/master/master
    {
        $this->parent = $parent;
    }

    /**
     * Returns true if the attribute is defined.
     *
     * @param string $name The attribute name
     *
     * @return bool true if the attribute is defined, false otherwise
     */
    public function hasAttribute($name)
    {
        return array_key_exists($name, $this->attributes);
    }

    /**
     * Returns an attribute by name.
     *
     * @param string $name    The attribute name
     * @param mixed  $default Default value is the attribute doesn't exist
     *
     * @return mixed The attribute value
     */
    public function getAttribute($name, $default = null)
    {
        return $this->hasAttribute($name) ? $this->attributes[$name] : $default;
    }

    /**
     * Sets an attribute by name.
     *
     * @param string $name  The attribute name
     * @param mixed  $value The attribute value
     */
    public function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    /**
     * Sets multiple attributes.
     *
     * @param array $attributes The attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }
}
