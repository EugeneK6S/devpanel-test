<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Session;

<<<<<<< HEAD
use Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface;
=======
>>>>>>> git-aline/master/master
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBagInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
<<<<<<< HEAD

/**
 * Session.
 *
=======
use Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface;

/**
>>>>>>> git-aline/master/master
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Drak <drak@zikula.org>
 */
class Session implements SessionInterface, \IteratorAggregate, \Countable
{
<<<<<<< HEAD
    /**
     * Storage driver.
     *
     * @var SessionStorageInterface
     */
    protected $storage;

    /**
     * @var string
     */
    private $flashName;

    /**
     * @var string
     */
    private $attributeName;

    /**
     * Constructor.
     *
     * @param SessionStorageInterface $storage    A SessionStorageInterface instance.
=======
    protected $storage;

    private $flashName;
    private $attributeName;
    private $data = array();
    private $usageIndex = 0;

    /**
     * @param SessionStorageInterface $storage    A SessionStorageInterface instance
>>>>>>> git-aline/master/master
     * @param AttributeBagInterface   $attributes An AttributeBagInterface instance, (defaults null for default AttributeBag)
     * @param FlashBagInterface       $flashes    A FlashBagInterface instance (defaults null for default FlashBag)
     */
    public function __construct(SessionStorageInterface $storage = null, AttributeBagInterface $attributes = null, FlashBagInterface $flashes = null)
    {
        $this->storage = $storage ?: new NativeSessionStorage();

        $attributes = $attributes ?: new AttributeBag();
        $this->attributeName = $attributes->getName();
        $this->registerBag($attributes);

        $flashes = $flashes ?: new FlashBag();
        $this->flashName = $flashes->getName();
        $this->registerBag($flashes);
    }

    /**
     * {@inheritdoc}
     */
    public function start()
    {
        return $this->storage->start();
    }

    /**
     * {@inheritdoc}
     */
    public function has($name)
    {
<<<<<<< HEAD
        return $this->storage->getBag($this->attributeName)->has($name);
=======
        return $this->getAttributeBag()->has($name);
>>>>>>> git-aline/master/master
    }

    /**
     * {@inheritdoc}
     */
    public function get($name, $default = null)
    {
<<<<<<< HEAD
        return $this->storage->getBag($this->attributeName)->get($name, $default);
=======
        return $this->getAttributeBag()->get($name, $default);
>>>>>>> git-aline/master/master
    }

    /**
     * {@inheritdoc}
     */
    public function set($name, $value)
    {
<<<<<<< HEAD
        $this->storage->getBag($this->attributeName)->set($name, $value);
=======
        $this->getAttributeBag()->set($name, $value);
>>>>>>> git-aline/master/master
    }

    /**
     * {@inheritdoc}
     */
    public function all()
    {
<<<<<<< HEAD
        return $this->storage->getBag($this->attributeName)->all();
=======
        return $this->getAttributeBag()->all();
>>>>>>> git-aline/master/master
    }

    /**
     * {@inheritdoc}
     */
    public function replace(array $attributes)
    {
<<<<<<< HEAD
        $this->storage->getBag($this->attributeName)->replace($attributes);
=======
        $this->getAttributeBag()->replace($attributes);
>>>>>>> git-aline/master/master
    }

    /**
     * {@inheritdoc}
     */
    public function remove($name)
    {
<<<<<<< HEAD
        return $this->storage->getBag($this->attributeName)->remove($name);
=======
        return $this->getAttributeBag()->remove($name);
>>>>>>> git-aline/master/master
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
<<<<<<< HEAD
        $this->storage->getBag($this->attributeName)->clear();
=======
        $this->getAttributeBag()->clear();
>>>>>>> git-aline/master/master
    }

    /**
     * {@inheritdoc}
     */
    public function isStarted()
    {
        return $this->storage->isStarted();
    }

    /**
     * Returns an iterator for attributes.
     *
     * @return \ArrayIterator An \ArrayIterator instance
     */
    public function getIterator()
    {
<<<<<<< HEAD
        return new \ArrayIterator($this->storage->getBag($this->attributeName)->all());
=======
        return new \ArrayIterator($this->getAttributeBag()->all());
>>>>>>> git-aline/master/master
    }

    /**
     * Returns the number of attributes.
     *
     * @return int The number of attributes
     */
    public function count()
    {
<<<<<<< HEAD
        return count($this->storage->getBag($this->attributeName)->all());
=======
        return \count($this->getAttributeBag()->all());
    }

    /**
     * @return int
     *
     * @internal
     */
    public function getUsageIndex()
    {
        return $this->usageIndex;
    }

    /**
     * @return bool
     *
     * @internal
     */
    public function isEmpty()
    {
        if ($this->isStarted()) {
            ++$this->usageIndex;
        }
        foreach ($this->data as &$data) {
            if (!empty($data)) {
                return false;
            }
        }

        return true;
>>>>>>> git-aline/master/master
    }

    /**
     * {@inheritdoc}
     */
    public function invalidate($lifetime = null)
    {
        $this->storage->clear();

        return $this->migrate(true, $lifetime);
    }

    /**
     * {@inheritdoc}
     */
    public function migrate($destroy = false, $lifetime = null)
    {
        return $this->storage->regenerate($destroy, $lifetime);
    }

    /**
     * {@inheritdoc}
     */
    public function save()
    {
        $this->storage->save();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->storage->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function setId($id)
    {
        $this->storage->setId($id);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->storage->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->storage->setName($name);
    }

    /**
     * {@inheritdoc}
     */
    public function getMetadataBag()
    {
<<<<<<< HEAD
=======
        ++$this->usageIndex;

>>>>>>> git-aline/master/master
        return $this->storage->getMetadataBag();
    }

    /**
     * {@inheritdoc}
     */
    public function registerBag(SessionBagInterface $bag)
    {
<<<<<<< HEAD
        $this->storage->registerBag($bag);
=======
        $this->storage->registerBag(new SessionBagProxy($bag, $this->data, $this->usageIndex));
>>>>>>> git-aline/master/master
    }

    /**
     * {@inheritdoc}
     */
    public function getBag($name)
    {
<<<<<<< HEAD
        return $this->storage->getBag($name);
=======
        return $this->storage->getBag($name)->getBag();
>>>>>>> git-aline/master/master
    }

    /**
     * Gets the flashbag interface.
     *
     * @return FlashBagInterface
     */
    public function getFlashBag()
    {
        return $this->getBag($this->flashName);
    }
<<<<<<< HEAD
=======

    /**
     * Gets the attributebag interface.
     *
     * Note that this method was added to help with IDE autocompletion.
     *
     * @return AttributeBagInterface
     */
    private function getAttributeBag()
    {
        return $this->getBag($this->attributeName);
    }
>>>>>>> git-aline/master/master
}
