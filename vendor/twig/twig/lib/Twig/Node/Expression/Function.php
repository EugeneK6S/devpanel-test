<?php

/*
 * This file is part of Twig.
 *
<<<<<<< HEAD
 * (c) 2010 Fabien Potencier
=======
 * (c) Fabien Potencier
>>>>>>> git-aline/master/master
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class Twig_Node_Expression_Function extends Twig_Node_Expression_Call
{
    public function __construct($name, Twig_NodeInterface $arguments, $lineno)
    {
<<<<<<< HEAD
        parent::__construct(array('arguments' => $arguments), array('name' => $name), $lineno);
=======
        parent::__construct(array('arguments' => $arguments), array('name' => $name, 'is_defined_test' => false), $lineno);
>>>>>>> git-aline/master/master
    }

    public function compile(Twig_Compiler $compiler)
    {
        $name = $this->getAttribute('name');
        $function = $compiler->getEnvironment()->getFunction($name);

        $this->setAttribute('name', $name);
        $this->setAttribute('type', 'function');
        $this->setAttribute('thing', $function);
        $this->setAttribute('needs_environment', $function->needsEnvironment());
        $this->setAttribute('needs_context', $function->needsContext());
        $this->setAttribute('arguments', $function->getArguments());
        if ($function instanceof Twig_FunctionCallableInterface || $function instanceof Twig_SimpleFunction) {
<<<<<<< HEAD
            $this->setAttribute('callable', $function->getCallable());
=======
            $callable = $function->getCallable();
            if ('constant' === $name && $this->getAttribute('is_defined_test')) {
                $callable = 'twig_constant_is_defined';
            }

            $this->setAttribute('callable', $callable);
>>>>>>> git-aline/master/master
        }
        if ($function instanceof Twig_SimpleFunction) {
            $this->setAttribute('is_variadic', $function->isVariadic());
        }

        $this->compileCallable($compiler);
    }
}
<<<<<<< HEAD
=======

class_alias('Twig_Node_Expression_Function', 'Twig\Node\Expression\FunctionExpression', false);
>>>>>>> git-aline/master/master
