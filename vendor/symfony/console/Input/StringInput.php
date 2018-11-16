<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Input;

<<<<<<< HEAD
=======
use Symfony\Component\Console\Exception\InvalidArgumentException;

>>>>>>> git-aline/master/master
/**
 * StringInput represents an input provided as a string.
 *
 * Usage:
 *
 *     $input = new StringInput('foo --bar="foobar"');
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class StringInput extends ArgvInput
{
    const REGEX_STRING = '([^\s]+?)(?:\s|(?<!\\\\)"|(?<!\\\\)\'|$)';
    const REGEX_QUOTED_STRING = '(?:"([^"\\\\]*(?:\\\\.[^"\\\\]*)*)"|\'([^\'\\\\]*(?:\\\\.[^\'\\\\]*)*)\')';

    /**
<<<<<<< HEAD
     * Constructor.
     *
     * @param string          $input      An array of parameters from the CLI (in the argv format)
     * @param InputDefinition $definition A InputDefinition instance
     *
     * @deprecated The second argument is deprecated as it does not work (will be removed in 3.0), use 'bind' method instead
     */
    public function __construct($input, InputDefinition $definition = null)
    {
        if ($definition) {
            @trigger_error('The $definition argument of the '.__METHOD__.' method is deprecated and will be removed in 3.0. Set this parameter with the bind() method instead.', E_USER_DEPRECATED);
        }

        parent::__construct(array(), null);

        $this->setTokens($this->tokenize($input));

        if (null !== $definition) {
            $this->bind($definition);
        }
=======
     * @param string $input A string representing the parameters from the CLI
     */
    public function __construct($input)
    {
        parent::__construct(array());

        $this->setTokens($this->tokenize($input));
>>>>>>> git-aline/master/master
    }

    /**
     * Tokenizes a string.
     *
     * @param string $input The input to tokenize
     *
     * @return array An array of tokens
     *
<<<<<<< HEAD
     * @throws \InvalidArgumentException When unable to parse input (should never happen)
=======
     * @throws InvalidArgumentException When unable to parse input (should never happen)
>>>>>>> git-aline/master/master
     */
    private function tokenize($input)
    {
        $tokens = array();
<<<<<<< HEAD
        $length = strlen($input);
=======
        $length = \strlen($input);
>>>>>>> git-aline/master/master
        $cursor = 0;
        while ($cursor < $length) {
            if (preg_match('/\s+/A', $input, $match, null, $cursor)) {
            } elseif (preg_match('/([^="\'\s]+?)(=?)('.self::REGEX_QUOTED_STRING.'+)/A', $input, $match, null, $cursor)) {
<<<<<<< HEAD
                $tokens[] = $match[1].$match[2].stripcslashes(str_replace(array('"\'', '\'"', '\'\'', '""'), '', substr($match[3], 1, strlen($match[3]) - 2)));
            } elseif (preg_match('/'.self::REGEX_QUOTED_STRING.'/A', $input, $match, null, $cursor)) {
                $tokens[] = stripcslashes(substr($match[0], 1, strlen($match[0]) - 2));
=======
                $tokens[] = $match[1].$match[2].stripcslashes(str_replace(array('"\'', '\'"', '\'\'', '""'), '', substr($match[3], 1, \strlen($match[3]) - 2)));
            } elseif (preg_match('/'.self::REGEX_QUOTED_STRING.'/A', $input, $match, null, $cursor)) {
                $tokens[] = stripcslashes(substr($match[0], 1, \strlen($match[0]) - 2));
>>>>>>> git-aline/master/master
            } elseif (preg_match('/'.self::REGEX_STRING.'/A', $input, $match, null, $cursor)) {
                $tokens[] = stripcslashes($match[1]);
            } else {
                // should never happen
<<<<<<< HEAD
                throw new \InvalidArgumentException(sprintf('Unable to parse input near "... %s ..."', substr($input, $cursor, 10)));
            }

            $cursor += strlen($match[0]);
=======
                throw new InvalidArgumentException(sprintf('Unable to parse input near "... %s ..."', substr($input, $cursor, 10)));
            }

            $cursor += \strlen($match[0]);
>>>>>>> git-aline/master/master
        }

        return $tokens;
    }
}
