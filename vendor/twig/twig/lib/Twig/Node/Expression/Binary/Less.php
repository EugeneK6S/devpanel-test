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
class Twig_Node_Expression_Binary_Less extends Twig_Node_Expression_Binary
{
    public function operator(Twig_Compiler $compiler)
    {
        return $compiler->raw('<');
    }
}
<<<<<<< HEAD
=======

class_alias('Twig_Node_Expression_Binary_Less', 'Twig\Node\Expression\Binary\LessBinary', false);
>>>>>>> git-aline/master/master
