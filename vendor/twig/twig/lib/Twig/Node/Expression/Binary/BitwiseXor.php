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
class Twig_Node_Expression_Binary_BitwiseXor extends Twig_Node_Expression_Binary
{
    public function operator(Twig_Compiler $compiler)
    {
        return $compiler->raw('^');
    }
}
<<<<<<< HEAD
=======

class_alias('Twig_Node_Expression_Binary_BitwiseXor', 'Twig\Node\Expression\Binary\BitwiseXorBinary', false);
>>>>>>> git-aline/master/master
