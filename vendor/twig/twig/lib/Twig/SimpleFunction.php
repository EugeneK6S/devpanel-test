<?php

/*
 * This file is part of Twig.
 *
<<<<<<< HEAD
 * (c) 2010-2012 Fabien Potencier
=======
 * (c) Fabien Potencier
>>>>>>> git-aline/master/master
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Represents a template function.
 *
<<<<<<< HEAD
=======
 * @final
 *
>>>>>>> git-aline/master/master
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Twig_SimpleFunction
{
    protected $name;
    protected $callable;
    protected $options;
    protected $arguments = array();

    public function __construct($name, $callable, array $options = array())
    {
        $this->name = $name;
        $this->callable = $callable;
        $this->options = array_merge(array(
            'needs_environment' => false,
            'needs_context' => false,
            'is_variadic' => false,
            'is_safe' => null,
            'is_safe_callback' => null,
            'node_class' => 'Twig_Node_Expression_Function',
            'deprecated' => false,
            'alternative' => null,
        ), $options);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCallable()
    {
        return $this->callable;
    }

    public function getNodeClass()
    {
        return $this->options['node_class'];
    }

    public function setArguments($arguments)
    {
        $this->arguments = $arguments;
    }

    public function getArguments()
    {
        return $this->arguments;
    }

    public function needsEnvironment()
    {
        return $this->options['needs_environment'];
    }

    public function needsContext()
    {
        return $this->options['needs_context'];
    }

    public function getSafe(Twig_Node $functionArgs)
    {
        if (null !== $this->options['is_safe']) {
            return $this->options['is_safe'];
        }

        if (null !== $this->options['is_safe_callback']) {
            return call_user_func($this->options['is_safe_callback'], $functionArgs);
        }

        return array();
    }

    public function isVariadic()
    {
        return $this->options['is_variadic'];
    }

    public function isDeprecated()
    {
<<<<<<< HEAD
=======
        return (bool) $this->options['deprecated'];
    }

    public function getDeprecatedVersion()
    {
>>>>>>> git-aline/master/master
        return $this->options['deprecated'];
    }

    public function getAlternative()
    {
        return $this->options['alternative'];
    }
}
<<<<<<< HEAD
=======

class_alias('Twig_SimpleFunction', 'Twig\TwigFunction', false);
>>>>>>> git-aline/master/master
