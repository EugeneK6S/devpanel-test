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

/**
 * Represents an import node.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Twig_Node_Import extends Twig_Node
{
    public function __construct(Twig_Node_Expression $expr, Twig_Node_Expression $var, $lineno, $tag = null)
    {
        parent::__construct(array('expr' => $expr, 'var' => $var), array(), $lineno, $tag);
    }

    public function compile(Twig_Compiler $compiler)
    {
        $compiler
            ->addDebugInfo($this)
            ->write('')
            ->subcompile($this->getNode('var'))
            ->raw(' = ')
        ;

        if ($this->getNode('expr') instanceof Twig_Node_Expression_Name && '_self' === $this->getNode('expr')->getAttribute('name')) {
            $compiler->raw('$this');
        } else {
            $compiler
                ->raw('$this->loadTemplate(')
                ->subcompile($this->getNode('expr'))
                ->raw(', ')
<<<<<<< HEAD
                ->repr($compiler->getFilename())
                ->raw(', ')
                ->repr($this->getLine())
=======
                ->repr($this->getTemplateName())
                ->raw(', ')
                ->repr($this->getTemplateLine())
>>>>>>> git-aline/master/master
                ->raw(')')
            ;
        }

        $compiler->raw(";\n");
    }
}
<<<<<<< HEAD
=======

class_alias('Twig_Node_Import', 'Twig\Node\ImportNode', false);
>>>>>>> git-aline/master/master
