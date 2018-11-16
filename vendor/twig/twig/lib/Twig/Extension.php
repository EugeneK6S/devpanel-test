<?php

/*
 * This file is part of Twig.
 *
<<<<<<< HEAD
 * (c) 2009 Fabien Potencier
=======
 * (c) Fabien Potencier
>>>>>>> git-aline/master/master
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
<<<<<<< HEAD
abstract class Twig_Extension implements Twig_ExtensionInterface
{
    /**
     * {@inheritdoc}
     *
=======

abstract class Twig_Extension implements Twig_ExtensionInterface
{
    /**
>>>>>>> git-aline/master/master
     * @deprecated since 1.23 (to be removed in 2.0), implement Twig_Extension_InitRuntimeInterface instead
     */
    public function initRuntime(Twig_Environment $environment)
    {
    }

<<<<<<< HEAD
    /**
     * {@inheritdoc}
     */
=======
>>>>>>> git-aline/master/master
    public function getTokenParsers()
    {
        return array();
    }

<<<<<<< HEAD
    /**
     * {@inheritdoc}
     */
=======
>>>>>>> git-aline/master/master
    public function getNodeVisitors()
    {
        return array();
    }

<<<<<<< HEAD
    /**
     * {@inheritdoc}
     */
=======
>>>>>>> git-aline/master/master
    public function getFilters()
    {
        return array();
    }

<<<<<<< HEAD
    /**
     * {@inheritdoc}
     */
=======
>>>>>>> git-aline/master/master
    public function getTests()
    {
        return array();
    }

<<<<<<< HEAD
    /**
     * {@inheritdoc}
     */
=======
>>>>>>> git-aline/master/master
    public function getFunctions()
    {
        return array();
    }

<<<<<<< HEAD
    /**
     * {@inheritdoc}
     */
=======
>>>>>>> git-aline/master/master
    public function getOperators()
    {
        return array();
    }

    /**
<<<<<<< HEAD
     * {@inheritdoc}
     *
=======
>>>>>>> git-aline/master/master
     * @deprecated since 1.23 (to be removed in 2.0), implement Twig_Extension_GlobalsInterface instead
     */
    public function getGlobals()
    {
        return array();
    }
<<<<<<< HEAD
}
=======

    /**
     * @deprecated since 1.26 (to be removed in 2.0), not used anymore internally
     */
    public function getName()
    {
        return get_class($this);
    }
}

class_alias('Twig_Extension', 'Twig\Extension\AbstractExtension', false);
class_exists('Twig_Environment');
>>>>>>> git-aline/master/master
