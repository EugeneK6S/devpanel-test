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
class Twig_Node_Expression_Binary_Power extends Twig_Node_Expression_Binary
{
    public function compile(Twig_Compiler $compiler)
    {
<<<<<<< HEAD
=======
        if (PHP_VERSION_ID >= 50600) {
            return parent::compile($compiler);
        }

>>>>>>> git-aline/master/master
        $compiler
            ->raw('pow(')
            ->subcompile($this->getNode('left'))
            ->raw(', ')
            ->subcompile($this->getNode('right'))
            ->raw(')')
        ;
    }

    public function operator(Twig_Compiler $compiler)
    {
        return $compiler->raw('**');
    }
}
<<<<<<< HEAD
=======

class_alias('Twig_Node_Expression_Binary_Power', 'Twig\Node\Expression\Binary\PowerBinary', false);
>>>>>>> git-aline/master/master
