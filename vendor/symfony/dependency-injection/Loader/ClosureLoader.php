<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\DependencyInjection\Loader;

<<<<<<< HEAD
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\Loader\Loader;
=======
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
>>>>>>> git-aline/master/master

/**
 * ClosureLoader loads service definitions from a PHP closure.
 *
 * The Closure has access to the container as its first argument.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class ClosureLoader extends Loader
{
    private $container;

<<<<<<< HEAD
    /**
     * Constructor.
     *
     * @param ContainerBuilder $container A ContainerBuilder instance
     */
=======
>>>>>>> git-aline/master/master
    public function __construct(ContainerBuilder $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function load($resource, $type = null)
    {
<<<<<<< HEAD
        call_user_func($resource, $this->container);
=======
        \call_user_func($resource, $this->container);
>>>>>>> git-aline/master/master
    }

    /**
     * {@inheritdoc}
     */
    public function supports($resource, $type = null)
    {
        return $resource instanceof \Closure;
    }
}
