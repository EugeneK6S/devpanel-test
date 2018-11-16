<?php

/*
 * This file is part of Twig.
 *
<<<<<<< HEAD
 * (c) 2009 Fabien Potencier
 * (c) 2009 Armin Ronacher
=======
 * (c) Fabien Potencier
 * (c) Armin Ronacher
>>>>>>> git-aline/master/master
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class Twig_Node_Expression_Constant extends Twig_Node_Expression
{
    public function __construct($value, $lineno)
    {
        parent::__construct(array(), array('value' => $value), $lineno);
    }

    public function compile(Twig_Compiler $compiler)
    {
        $compiler->repr($this->getAttribute('value'));
    }
}
<<<<<<< HEAD
=======

class_alias('Twig_Node_Expression_Constant', 'Twig\Node\Expression\ConstantExpression', false);
>>>>>>> git-aline/master/master
