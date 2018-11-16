<?php

/*
 * This file is part of Twig.
 *
<<<<<<< HEAD
 * (c) 2011 Fabien Potencier
=======
 * (c) Fabien Potencier
>>>>>>> git-aline/master/master
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Flushes the output to the client.
 *
 * @see flush()
<<<<<<< HEAD
=======
 *
 * @final
>>>>>>> git-aline/master/master
 */
class Twig_TokenParser_Flush extends Twig_TokenParser
{
    public function parse(Twig_Token $token)
    {
        $this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);

        return new Twig_Node_Flush($token->getLine(), $this->getTag());
    }

    public function getTag()
    {
        return 'flush';
    }
}
<<<<<<< HEAD
=======

class_alias('Twig_TokenParser_Flush', 'Twig\TokenParser\FlushTokenParser', false);
>>>>>>> git-aline/master/master
