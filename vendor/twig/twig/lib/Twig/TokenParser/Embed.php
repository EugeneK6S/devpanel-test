<?php

/*
 * This file is part of Twig.
 *
<<<<<<< HEAD
 * (c) 2012 Fabien Potencier
=======
 * (c) Fabien Potencier
>>>>>>> git-aline/master/master
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Embeds a template.
<<<<<<< HEAD
=======
 *
 * @final
>>>>>>> git-aline/master/master
 */
class Twig_TokenParser_Embed extends Twig_TokenParser_Include
{
    public function parse(Twig_Token $token)
    {
        $stream = $this->parser->getStream();

        $parent = $this->parser->getExpressionParser()->parseExpression();

        list($variables, $only, $ignoreMissing) = $this->parseArguments();

<<<<<<< HEAD
=======
        $parentToken = $fakeParentToken = new Twig_Token(Twig_Token::STRING_TYPE, '__parent__', $token->getLine());
        if ($parent instanceof Twig_Node_Expression_Constant) {
            $parentToken = new Twig_Token(Twig_Token::STRING_TYPE, $parent->getAttribute('value'), $token->getLine());
        } elseif ($parent instanceof Twig_Node_Expression_Name) {
            $parentToken = new Twig_Token(Twig_Token::NAME_TYPE, $parent->getAttribute('name'), $token->getLine());
        }

>>>>>>> git-aline/master/master
        // inject a fake parent to make the parent() function work
        $stream->injectTokens(array(
            new Twig_Token(Twig_Token::BLOCK_START_TYPE, '', $token->getLine()),
            new Twig_Token(Twig_Token::NAME_TYPE, 'extends', $token->getLine()),
<<<<<<< HEAD
            new Twig_Token(Twig_Token::STRING_TYPE, '__parent__', $token->getLine()),
=======
            $parentToken,
>>>>>>> git-aline/master/master
            new Twig_Token(Twig_Token::BLOCK_END_TYPE, '', $token->getLine()),
        ));

        $module = $this->parser->parse($stream, array($this, 'decideBlockEnd'), true);

        // override the parent with the correct one
<<<<<<< HEAD
        $module->setNode('parent', $parent);
=======
        if ($fakeParentToken === $parentToken) {
            $module->setNode('parent', $parent);
        }
>>>>>>> git-aline/master/master

        $this->parser->embedTemplate($module);

        $stream->expect(Twig_Token::BLOCK_END_TYPE);

<<<<<<< HEAD
        return new Twig_Node_Embed($module->getAttribute('filename'), $module->getAttribute('index'), $variables, $only, $ignoreMissing, $token->getLine(), $this->getTag());
=======
        return new Twig_Node_Embed($module->getTemplateName(), $module->getAttribute('index'), $variables, $only, $ignoreMissing, $token->getLine(), $this->getTag());
>>>>>>> git-aline/master/master
    }

    public function decideBlockEnd(Twig_Token $token)
    {
        return $token->test('endembed');
    }

    public function getTag()
    {
        return 'embed';
    }
}
<<<<<<< HEAD
=======

class_alias('Twig_TokenParser_Embed', 'Twig\TokenParser\EmbedTokenParser', false);
>>>>>>> git-aline/master/master
