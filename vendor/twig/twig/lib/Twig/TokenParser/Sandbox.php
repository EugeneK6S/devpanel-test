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

/**
 * Marks a section of a template as untrusted code that must be evaluated in the sandbox mode.
 *
 * <pre>
 * {% sandbox %}
 *     {% include 'user.html' %}
 * {% endsandbox %}
 * </pre>
 *
<<<<<<< HEAD
 * @see http://www.twig-project.org/doc/api.html#sandbox-extension for details
=======
 * @see https://twig.symfony.com/doc/api.html#sandbox-extension for details
 *
 * @final
>>>>>>> git-aline/master/master
 */
class Twig_TokenParser_Sandbox extends Twig_TokenParser
{
    public function parse(Twig_Token $token)
    {
<<<<<<< HEAD
        $this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);
        $body = $this->parser->subparse(array($this, 'decideBlockEnd'), true);
        $this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);
=======
        $stream = $this->parser->getStream();
        $stream->expect(Twig_Token::BLOCK_END_TYPE);
        $body = $this->parser->subparse(array($this, 'decideBlockEnd'), true);
        $stream->expect(Twig_Token::BLOCK_END_TYPE);
>>>>>>> git-aline/master/master

        // in a sandbox tag, only include tags are allowed
        if (!$body instanceof Twig_Node_Include) {
            foreach ($body as $node) {
                if ($node instanceof Twig_Node_Text && ctype_space($node->getAttribute('data'))) {
                    continue;
                }

                if (!$node instanceof Twig_Node_Include) {
<<<<<<< HEAD
                    throw new Twig_Error_Syntax('Only "include" tags are allowed within a "sandbox" section.', $node->getLine(), $this->parser->getFilename());
=======
                    throw new Twig_Error_Syntax('Only "include" tags are allowed within a "sandbox" section.', $node->getTemplateLine(), $stream->getSourceContext());
>>>>>>> git-aline/master/master
                }
            }
        }

        return new Twig_Node_Sandbox($body, $token->getLine(), $this->getTag());
    }

    public function decideBlockEnd(Twig_Token $token)
    {
        return $token->test('endsandbox');
    }

    public function getTag()
    {
        return 'sandbox';
    }
}
<<<<<<< HEAD
=======

class_alias('Twig_TokenParser_Sandbox', 'Twig\TokenParser\SandboxTokenParser', false);
>>>>>>> git-aline/master/master
