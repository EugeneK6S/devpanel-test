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
 * Base class for all token parsers.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
abstract class Twig_TokenParser implements Twig_TokenParserInterface
{
    /**
     * @var Twig_Parser
     */
    protected $parser;

    /**
     * Sets the parser associated with this token parser.
<<<<<<< HEAD
     *
     * @param Twig_Parser $parser A Twig_Parser instance
=======
>>>>>>> git-aline/master/master
     */
    public function setParser(Twig_Parser $parser)
    {
        $this->parser = $parser;
    }
}
<<<<<<< HEAD
=======

class_alias('Twig_TokenParser', 'Twig\TokenParser\AbstractTokenParser', false);
>>>>>>> git-aline/master/master
