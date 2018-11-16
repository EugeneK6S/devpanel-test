<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Yaml;

use Symfony\Component\Yaml\Exception\ParseException;
<<<<<<< HEAD
=======
use Symfony\Component\Yaml\Tag\TaggedValue;
>>>>>>> git-aline/master/master

/**
 * Parser parses YAML strings to convert them to PHP arrays.
 *
 * @author Fabien Potencier <fabien@symfony.com>
<<<<<<< HEAD
 */
class Parser
{
    const BLOCK_SCALAR_HEADER_PATTERN = '(?P<separator>\||>)(?P<modifiers>\+|\-|\d+|\+\d+|\-\d+|\d+\+|\d+\-)?(?P<comments> +#.*)?';
    // BC - wrongly named
    const FOLDED_SCALAR_PATTERN = self::BLOCK_SCALAR_HEADER_PATTERN;

    private $offset = 0;
=======
 *
 * @final since version 3.4
 */
class Parser
{
    const TAG_PATTERN = '(?P<tag>![\w!.\/:-]+)';
    const BLOCK_SCALAR_HEADER_PATTERN = '(?P<separator>\||>)(?P<modifiers>\+|\-|\d+|\+\d+|\-\d+|\d+\+|\d+\-)?(?P<comments> +#.*)?';

    private $filename;
    private $offset = 0;
    private $totalNumberOfLines;
>>>>>>> git-aline/master/master
    private $lines = array();
    private $currentLineNb = -1;
    private $currentLine = '';
    private $refs = array();
<<<<<<< HEAD

    /**
     * Constructor.
     *
     * @param int $offset The offset of YAML document (used for line numbers in error messages)
     */
    public function __construct($offset = 0)
    {
        $this->offset = $offset;
=======
    private $skippedLineNumbers = array();
    private $locallySkippedLineNumbers = array();

    public function __construct()
    {
        if (\func_num_args() > 0) {
            @trigger_error(sprintf('The constructor arguments $offset, $totalNumberOfLines, $skippedLineNumbers of %s are deprecated and will be removed in 4.0', self::class), E_USER_DEPRECATED);

            $this->offset = func_get_arg(0);
            if (\func_num_args() > 1) {
                $this->totalNumberOfLines = func_get_arg(1);
            }
            if (\func_num_args() > 2) {
                $this->skippedLineNumbers = func_get_arg(2);
            }
        }
    }

    /**
     * Parses a YAML file into a PHP value.
     *
     * @param string $filename The path to the YAML file to be parsed
     * @param int    $flags    A bit field of PARSE_* constants to customize the YAML parser behavior
     *
     * @return mixed The YAML converted to a PHP value
     *
     * @throws ParseException If the file could not be read or the YAML is not valid
     */
    public function parseFile($filename, $flags = 0)
    {
        if (!is_file($filename)) {
            throw new ParseException(sprintf('File "%s" does not exist.', $filename));
        }

        if (!is_readable($filename)) {
            throw new ParseException(sprintf('File "%s" cannot be read.', $filename));
        }

        $this->filename = $filename;

        try {
            return $this->parse(file_get_contents($filename), $flags);
        } finally {
            $this->filename = null;
        }
>>>>>>> git-aline/master/master
    }

    /**
     * Parses a YAML string to a PHP value.
     *
<<<<<<< HEAD
     * @param string $value                  A YAML string
     * @param bool   $exceptionOnInvalidType true if an exception must be thrown on invalid types (a PHP resource or object), false otherwise
     * @param bool   $objectSupport          true if object support is enabled, false otherwise
     * @param bool   $objectForMap           true if maps should return a stdClass instead of array()
=======
     * @param string $value A YAML string
     * @param int    $flags A bit field of PARSE_* constants to customize the YAML parser behavior
>>>>>>> git-aline/master/master
     *
     * @return mixed A PHP value
     *
     * @throws ParseException If the YAML is not valid
     */
<<<<<<< HEAD
    public function parse($value, $exceptionOnInvalidType = false, $objectSupport = false, $objectForMap = false)
    {
        if (!preg_match('//u', $value)) {
            throw new ParseException('The YAML value does not appear to be valid UTF-8.');
        }
=======
    public function parse($value, $flags = 0)
    {
        if (\is_bool($flags)) {
            @trigger_error('Passing a boolean flag to toggle exception handling is deprecated since Symfony 3.1 and will be removed in 4.0. Use the Yaml::PARSE_EXCEPTION_ON_INVALID_TYPE flag instead.', E_USER_DEPRECATED);

            if ($flags) {
                $flags = Yaml::PARSE_EXCEPTION_ON_INVALID_TYPE;
            } else {
                $flags = 0;
            }
        }

        if (\func_num_args() >= 3) {
            @trigger_error('Passing a boolean flag to toggle object support is deprecated since Symfony 3.1 and will be removed in 4.0. Use the Yaml::PARSE_OBJECT flag instead.', E_USER_DEPRECATED);

            if (func_get_arg(2)) {
                $flags |= Yaml::PARSE_OBJECT;
            }
        }

        if (\func_num_args() >= 4) {
            @trigger_error('Passing a boolean flag to toggle object for map support is deprecated since Symfony 3.1 and will be removed in 4.0. Use the Yaml::PARSE_OBJECT_FOR_MAP flag instead.', E_USER_DEPRECATED);

            if (func_get_arg(3)) {
                $flags |= Yaml::PARSE_OBJECT_FOR_MAP;
            }
        }

        if (Yaml::PARSE_KEYS_AS_STRINGS & $flags) {
            @trigger_error('Using the Yaml::PARSE_KEYS_AS_STRINGS flag is deprecated since Symfony 3.4 as it will be removed in 4.0. Quote your keys when they are evaluable instead.', E_USER_DEPRECATED);
        }

        if (false === preg_match('//u', $value)) {
            throw new ParseException('The YAML value does not appear to be valid UTF-8.', -1, null, $this->filename);
        }

        $this->refs = array();

        $mbEncoding = null;
        $e = null;
        $data = null;

        if (2 /* MB_OVERLOAD_STRING */ & (int) ini_get('mbstring.func_overload')) {
            $mbEncoding = mb_internal_encoding();
            mb_internal_encoding('UTF-8');
        }

        try {
            $data = $this->doParse($value, $flags);
        } catch (\Exception $e) {
        } catch (\Throwable $e) {
        }

        if (null !== $mbEncoding) {
            mb_internal_encoding($mbEncoding);
        }

        $this->lines = array();
        $this->currentLine = '';
        $this->refs = array();
        $this->skippedLineNumbers = array();
        $this->locallySkippedLineNumbers = array();

        if (null !== $e) {
            throw $e;
        }

        return $data;
    }

    private function doParse($value, $flags)
    {
>>>>>>> git-aline/master/master
        $this->currentLineNb = -1;
        $this->currentLine = '';
        $value = $this->cleanup($value);
        $this->lines = explode("\n", $value);
<<<<<<< HEAD

        if (function_exists('mb_internal_encoding') && ((int) ini_get('mbstring.func_overload')) & 2) {
            $mbEncoding = mb_internal_encoding();
            mb_internal_encoding('UTF-8');
=======
        $this->locallySkippedLineNumbers = array();

        if (null === $this->totalNumberOfLines) {
            $this->totalNumberOfLines = \count($this->lines);
        }

        if (!$this->moveToNextLine()) {
            return null;
>>>>>>> git-aline/master/master
        }

        $data = array();
        $context = null;
        $allowOverwrite = false;
<<<<<<< HEAD
        while ($this->moveToNextLine()) {
=======

        while ($this->isCurrentLineEmpty()) {
            if (!$this->moveToNextLine()) {
                return null;
            }
        }

        // Resolves the tag and returns if end of the document
        if (null !== ($tag = $this->getLineTag($this->currentLine, $flags, false)) && !$this->moveToNextLine()) {
            return new TaggedValue($tag, '');
        }

        do {
>>>>>>> git-aline/master/master
            if ($this->isCurrentLineEmpty()) {
                continue;
            }

            // tab?
            if ("\t" === $this->currentLine[0]) {
<<<<<<< HEAD
                throw new ParseException('A YAML file cannot contain tabs as indentation.', $this->getRealCurrentLineNb() + 1, $this->currentLine);
            }

            $isRef = $mergeNode = false;
            if (preg_match('#^\-((?P<leadspaces>\s+)(?P<value>.+?))?\s*$#u', $this->currentLine, $values)) {
                if ($context && 'mapping' == $context) {
                    throw new ParseException('You cannot define a sequence item when in a mapping');
                }
                $context = 'sequence';

                if (isset($values['value']) && preg_match('#^&(?P<ref>[^ ]+) *(?P<value>.*)#u', $values['value'], $matches)) {
=======
                throw new ParseException('A YAML file cannot contain tabs as indentation.', $this->getRealCurrentLineNb() + 1, $this->currentLine, $this->filename);
            }

            Inline::initialize($flags, $this->getRealCurrentLineNb(), $this->filename);

            $isRef = $mergeNode = false;
            if (self::preg_match('#^\-((?P<leadspaces>\s+)(?P<value>.+))?$#u', rtrim($this->currentLine), $values)) {
                if ($context && 'mapping' == $context) {
                    throw new ParseException('You cannot define a sequence item when in a mapping', $this->getRealCurrentLineNb() + 1, $this->currentLine, $this->filename);
                }
                $context = 'sequence';

                if (isset($values['value']) && self::preg_match('#^&(?P<ref>[^ ]+) *(?P<value>.*)#u', $values['value'], $matches)) {
>>>>>>> git-aline/master/master
                    $isRef = $matches['ref'];
                    $values['value'] = $matches['value'];
                }

<<<<<<< HEAD
                // array
                if (!isset($values['value']) || '' == trim($values['value'], ' ') || 0 === strpos(ltrim($values['value'], ' '), '#')) {
                    $c = $this->getRealCurrentLineNb() + 1;
                    $parser = new self($c);
                    $parser->refs = &$this->refs;
                    $data[] = $parser->parse($this->getNextEmbedBlock(null, true), $exceptionOnInvalidType, $objectSupport, $objectForMap);
                } else {
                    if (isset($values['leadspaces'])
                        && preg_match('#^(?P<key>'.Inline::REGEX_QUOTED_STRING.'|[^ \'"\{\[].*?) *\:(\s+(?P<value>.+?))?\s*$#u', $values['value'], $matches)
                    ) {
                        // this is a compact notation element, add to next block and parse
                        $c = $this->getRealCurrentLineNb();
                        $parser = new self($c);
                        $parser->refs = &$this->refs;

                        $block = $values['value'];
                        if ($this->isNextLineIndented()) {
                            $block .= "\n".$this->getNextEmbedBlock($this->getCurrentLineIndentation() + strlen($values['leadspaces']) + 1);
                        }

                        $data[] = $parser->parse($block, $exceptionOnInvalidType, $objectSupport, $objectForMap);
                    } else {
                        $data[] = $this->parseValue($values['value'], $exceptionOnInvalidType, $objectSupport, $objectForMap);
=======
                if (isset($values['value'][1]) && '?' === $values['value'][0] && ' ' === $values['value'][1]) {
                    @trigger_error($this->getDeprecationMessage('Starting an unquoted string with a question mark followed by a space is deprecated since Symfony 3.3 and will throw \Symfony\Component\Yaml\Exception\ParseException in 4.0.'), E_USER_DEPRECATED);
                }

                // array
                if (!isset($values['value']) || '' == trim($values['value'], ' ') || 0 === strpos(ltrim($values['value'], ' '), '#')) {
                    $data[] = $this->parseBlock($this->getRealCurrentLineNb() + 1, $this->getNextEmbedBlock(null, true), $flags);
                } elseif (null !== $subTag = $this->getLineTag(ltrim($values['value'], ' '), $flags)) {
                    $data[] = new TaggedValue(
                        $subTag,
                        $this->parseBlock($this->getRealCurrentLineNb() + 1, $this->getNextEmbedBlock(null, true), $flags)
                    );
                } else {
                    if (isset($values['leadspaces'])
                        && self::preg_match('#^(?P<key>'.Inline::REGEX_QUOTED_STRING.'|[^ \'"\{\[].*?) *\:(\s+(?P<value>.+?))?\s*$#u', $this->trimTag($values['value']), $matches)
                    ) {
                        // this is a compact notation element, add to next block and parse
                        $block = $values['value'];
                        if ($this->isNextLineIndented()) {
                            $block .= "\n".$this->getNextEmbedBlock($this->getCurrentLineIndentation() + \strlen($values['leadspaces']) + 1);
                        }

                        $data[] = $this->parseBlock($this->getRealCurrentLineNb(), $block, $flags);
                    } else {
                        $data[] = $this->parseValue($values['value'], $flags, $context);
>>>>>>> git-aline/master/master
                    }
                }
                if ($isRef) {
                    $this->refs[$isRef] = end($data);
                }
<<<<<<< HEAD
            } elseif (preg_match('#^(?P<key>'.Inline::REGEX_QUOTED_STRING.'|[^ \'"\[\{].*?) *\:(\s+(?P<value>.+?))?\s*$#u', $this->currentLine, $values) && (false === strpos($values['key'], ' #') || in_array($values['key'][0], array('"', "'")))) {
                if ($context && 'sequence' == $context) {
                    throw new ParseException('You cannot define a mapping item when in a sequence');
                }
                $context = 'mapping';

                // force correct settings
                Inline::parse(null, $exceptionOnInvalidType, $objectSupport, $objectForMap, $this->refs);
                try {
                    $key = Inline::parseScalar($values['key']);
=======
            } elseif (
                self::preg_match('#^(?P<key>(?:![^\s]++\s++)?(?:'.Inline::REGEX_QUOTED_STRING.'|(?:!?!php/const:)?[^ \'"\[\{!].*?)) *\:(\s++(?P<value>.+))?$#u', rtrim($this->currentLine), $values)
                && (false === strpos($values['key'], ' #') || \in_array($values['key'][0], array('"', "'")))
            ) {
                if ($context && 'sequence' == $context) {
                    throw new ParseException('You cannot define a mapping item when in a sequence', $this->currentLineNb + 1, $this->currentLine, $this->filename);
                }
                $context = 'mapping';

                try {
                    $i = 0;
                    $evaluateKey = !(Yaml::PARSE_KEYS_AS_STRINGS & $flags);

                    // constants in key will be evaluated anyway
                    if (isset($values['key'][0]) && '!' === $values['key'][0] && Yaml::PARSE_CONSTANT & $flags) {
                        $evaluateKey = true;
                    }

                    $key = Inline::parseScalar($values['key'], 0, null, $i, $evaluateKey);
>>>>>>> git-aline/master/master
                } catch (ParseException $e) {
                    $e->setParsedLine($this->getRealCurrentLineNb() + 1);
                    $e->setSnippet($this->currentLine);

                    throw $e;
                }

<<<<<<< HEAD
                // Convert float keys to strings, to avoid being converted to integers by PHP
                if (is_float($key)) {
                    $key = (string) $key;
                }

                if ('<<' === $key) {
                    $mergeNode = true;
                    $allowOverwrite = true;
                    if (isset($values['value']) && 0 === strpos($values['value'], '*')) {
                        $refName = substr($values['value'], 1);
                        if (!array_key_exists($refName, $this->refs)) {
                            throw new ParseException(sprintf('Reference "%s" does not exist.', $refName), $this->getRealCurrentLineNb() + 1, $this->currentLine);
=======
                if (!\is_string($key) && !\is_int($key)) {
                    $keyType = is_numeric($key) ? 'numeric key' : 'non-string key';
                    @trigger_error($this->getDeprecationMessage(sprintf('Implicit casting of %s to string is deprecated since Symfony 3.3 and will throw \Symfony\Component\Yaml\Exception\ParseException in 4.0. Quote your evaluable mapping keys instead.', $keyType)), E_USER_DEPRECATED);
                }

                // Convert float keys to strings, to avoid being converted to integers by PHP
                if (\is_float($key)) {
                    $key = (string) $key;
                }

                if ('<<' === $key && (!isset($values['value']) || !self::preg_match('#^&(?P<ref>[^ ]+)#u', $values['value'], $refMatches))) {
                    $mergeNode = true;
                    $allowOverwrite = true;
                    if (isset($values['value'][0]) && '*' === $values['value'][0]) {
                        $refName = substr(rtrim($values['value']), 1);
                        if (!array_key_exists($refName, $this->refs)) {
                            throw new ParseException(sprintf('Reference "%s" does not exist.', $refName), $this->getRealCurrentLineNb() + 1, $this->currentLine, $this->filename);
>>>>>>> git-aline/master/master
                        }

                        $refValue = $this->refs[$refName];

<<<<<<< HEAD
                        if (!is_array($refValue)) {
                            throw new ParseException('YAML merge keys used with a scalar value instead of an array.', $this->getRealCurrentLineNb() + 1, $this->currentLine);
                        }

                        foreach ($refValue as $key => $value) {
                            if (!isset($data[$key])) {
                                $data[$key] = $value;
                            }
                        }
                    } else {
                        if (isset($values['value']) && $values['value'] !== '') {
=======
                        if (Yaml::PARSE_OBJECT_FOR_MAP & $flags && $refValue instanceof \stdClass) {
                            $refValue = (array) $refValue;
                        }

                        if (!\is_array($refValue)) {
                            throw new ParseException('YAML merge keys used with a scalar value instead of an array.', $this->getRealCurrentLineNb() + 1, $this->currentLine, $this->filename);
                        }

                        $data += $refValue; // array union
                    } else {
                        if (isset($values['value']) && '' !== $values['value']) {
>>>>>>> git-aline/master/master
                            $value = $values['value'];
                        } else {
                            $value = $this->getNextEmbedBlock();
                        }
<<<<<<< HEAD
                        $c = $this->getRealCurrentLineNb() + 1;
                        $parser = new self($c);
                        $parser->refs = &$this->refs;
                        $parsed = $parser->parse($value, $exceptionOnInvalidType, $objectSupport, $objectForMap);

                        if (!is_array($parsed)) {
                            throw new ParseException('YAML merge keys used with a scalar value instead of an array.', $this->getRealCurrentLineNb() + 1, $this->currentLine);
=======
                        $parsed = $this->parseBlock($this->getRealCurrentLineNb() + 1, $value, $flags);

                        if (Yaml::PARSE_OBJECT_FOR_MAP & $flags && $parsed instanceof \stdClass) {
                            $parsed = (array) $parsed;
                        }

                        if (!\is_array($parsed)) {
                            throw new ParseException('YAML merge keys used with a scalar value instead of an array.', $this->getRealCurrentLineNb() + 1, $this->currentLine, $this->filename);
>>>>>>> git-aline/master/master
                        }

                        if (isset($parsed[0])) {
                            // If the value associated with the merge key is a sequence, then this sequence is expected to contain mapping nodes
                            // and each of these nodes is merged in turn according to its order in the sequence. Keys in mapping nodes earlier
                            // in the sequence override keys specified in later mapping nodes.
                            foreach ($parsed as $parsedItem) {
<<<<<<< HEAD
                                if (!is_array($parsedItem)) {
                                    throw new ParseException('Merge items must be arrays.', $this->getRealCurrentLineNb() + 1, $parsedItem);
                                }

                                foreach ($parsedItem as $key => $value) {
                                    if (!isset($data[$key])) {
                                        $data[$key] = $value;
                                    }
                                }
=======
                                if (Yaml::PARSE_OBJECT_FOR_MAP & $flags && $parsedItem instanceof \stdClass) {
                                    $parsedItem = (array) $parsedItem;
                                }

                                if (!\is_array($parsedItem)) {
                                    throw new ParseException('Merge items must be arrays.', $this->getRealCurrentLineNb() + 1, $parsedItem, $this->filename);
                                }

                                $data += $parsedItem; // array union
>>>>>>> git-aline/master/master
                            }
                        } else {
                            // If the value associated with the key is a single mapping node, each of its key/value pairs is inserted into the
                            // current mapping, unless the key already exists in it.
<<<<<<< HEAD
                            foreach ($parsed as $key => $value) {
                                if (!isset($data[$key])) {
                                    $data[$key] = $value;
                                }
                            }
                        }
                    }
                } elseif (isset($values['value']) && preg_match('#^&(?P<ref>[^ ]+) *(?P<value>.*)#u', $values['value'], $matches)) {
=======
                            $data += $parsed; // array union
                        }
                    }
                } elseif ('<<' !== $key && isset($values['value']) && self::preg_match('#^&(?P<ref>[^ ]++) *+(?P<value>.*)#u', $values['value'], $matches)) {
>>>>>>> git-aline/master/master
                    $isRef = $matches['ref'];
                    $values['value'] = $matches['value'];
                }

<<<<<<< HEAD
                if ($mergeNode) {
                    // Merge keys
                } elseif (!isset($values['value']) || '' == trim($values['value'], ' ') || 0 === strpos(ltrim($values['value'], ' '), '#')) {
=======
                $subTag = null;
                if ($mergeNode) {
                    // Merge keys
                } elseif (!isset($values['value']) || '' === $values['value'] || 0 === strpos($values['value'], '#') || (null !== $subTag = $this->getLineTag($values['value'], $flags)) || '<<' === $key) {
>>>>>>> git-aline/master/master
                    // hash
                    // if next line is less indented or equal, then it means that the current value is null
                    if (!$this->isNextLineIndented() && !$this->isNextLineUnIndentedCollection()) {
                        // Spec: Keys MUST be unique; first one wins.
                        // But overwriting is allowed when a merge node is used in current block.
                        if ($allowOverwrite || !isset($data[$key])) {
<<<<<<< HEAD
                            $data[$key] = null;
                        }
                    } else {
                        $c = $this->getRealCurrentLineNb() + 1;
                        $parser = new self($c);
                        $parser->refs = &$this->refs;
                        $value = $parser->parse($this->getNextEmbedBlock(), $exceptionOnInvalidType, $objectSupport, $objectForMap);
                        // Spec: Keys MUST be unique; first one wins.
                        // But overwriting is allowed when a merge node is used in current block.
                        if ($allowOverwrite || !isset($data[$key])) {
                            $data[$key] = $value;
                        }
                    }
                } else {
                    $value = $this->parseValue($values['value'], $exceptionOnInvalidType, $objectSupport, $objectForMap);
=======
                            if (null !== $subTag) {
                                $data[$key] = new TaggedValue($subTag, '');
                            } else {
                                $data[$key] = null;
                            }
                        } else {
                            @trigger_error($this->getDeprecationMessage(sprintf('Duplicate key "%s" detected whilst parsing YAML. Silent handling of duplicate mapping keys in YAML is deprecated since Symfony 3.2 and will throw \Symfony\Component\Yaml\Exception\ParseException in 4.0.', $key)), E_USER_DEPRECATED);
                        }
                    } else {
                        $value = $this->parseBlock($this->getRealCurrentLineNb() + 1, $this->getNextEmbedBlock(), $flags);
                        if ('<<' === $key) {
                            $this->refs[$refMatches['ref']] = $value;

                            if (Yaml::PARSE_OBJECT_FOR_MAP & $flags && $value instanceof \stdClass) {
                                $value = (array) $value;
                            }

                            $data += $value;
                        } elseif ($allowOverwrite || !isset($data[$key])) {
                            // Spec: Keys MUST be unique; first one wins.
                            // But overwriting is allowed when a merge node is used in current block.
                            if (null !== $subTag) {
                                $data[$key] = new TaggedValue($subTag, $value);
                            } else {
                                $data[$key] = $value;
                            }
                        } else {
                            @trigger_error($this->getDeprecationMessage(sprintf('Duplicate key "%s" detected whilst parsing YAML. Silent handling of duplicate mapping keys in YAML is deprecated since Symfony 3.2 and will throw \Symfony\Component\Yaml\Exception\ParseException in 4.0.', $key)), E_USER_DEPRECATED);
                        }
                    }
                } else {
                    $value = $this->parseValue(rtrim($values['value']), $flags, $context);
>>>>>>> git-aline/master/master
                    // Spec: Keys MUST be unique; first one wins.
                    // But overwriting is allowed when a merge node is used in current block.
                    if ($allowOverwrite || !isset($data[$key])) {
                        $data[$key] = $value;
<<<<<<< HEAD
=======
                    } else {
                        @trigger_error($this->getDeprecationMessage(sprintf('Duplicate key "%s" detected whilst parsing YAML. Silent handling of duplicate mapping keys in YAML is deprecated since Symfony 3.2 and will throw \Symfony\Component\Yaml\Exception\ParseException in 4.0.', $key)), E_USER_DEPRECATED);
>>>>>>> git-aline/master/master
                    }
                }
                if ($isRef) {
                    $this->refs[$isRef] = $data[$key];
                }
            } else {
                // multiple documents are not supported
                if ('---' === $this->currentLine) {
<<<<<<< HEAD
                    throw new ParseException('Multiple documents are not supported.');
                }

                // 1-liner optionally followed by newline(s)
                if (is_string($value) && $this->lines[0] === trim($value)) {
                    try {
                        $value = Inline::parse($this->lines[0], $exceptionOnInvalidType, $objectSupport, $objectForMap, $this->refs);
=======
                    throw new ParseException('Multiple documents are not supported.', $this->currentLineNb + 1, $this->currentLine, $this->filename);
                }

                if ($deprecatedUsage = (isset($this->currentLine[1]) && '?' === $this->currentLine[0] && ' ' === $this->currentLine[1])) {
                    @trigger_error($this->getDeprecationMessage('Starting an unquoted string with a question mark followed by a space is deprecated since Symfony 3.3 and will throw \Symfony\Component\Yaml\Exception\ParseException in 4.0.'), E_USER_DEPRECATED);
                }

                // 1-liner optionally followed by newline(s)
                if (\is_string($value) && $this->lines[0] === trim($value)) {
                    try {
                        $value = Inline::parse($this->lines[0], $flags, $this->refs);
>>>>>>> git-aline/master/master
                    } catch (ParseException $e) {
                        $e->setParsedLine($this->getRealCurrentLineNb() + 1);
                        $e->setSnippet($this->currentLine);

                        throw $e;
                    }

<<<<<<< HEAD
                    if (is_array($value)) {
                        $first = reset($value);
                        if (is_string($first) && 0 === strpos($first, '*')) {
                            $data = array();
                            foreach ($value as $alias) {
                                $data[] = $this->refs[substr($alias, 1)];
                            }
                            $value = $data;
                        }
                    }

                    if (isset($mbEncoding)) {
                        mb_internal_encoding($mbEncoding);
                    }

                    return $value;
                }

                switch (preg_last_error()) {
                    case PREG_INTERNAL_ERROR:
                        $error = 'Internal PCRE error.';
                        break;
                    case PREG_BACKTRACK_LIMIT_ERROR:
                        $error = 'pcre.backtrack_limit reached.';
                        break;
                    case PREG_RECURSION_LIMIT_ERROR:
                        $error = 'pcre.recursion_limit reached.';
                        break;
                    case PREG_BAD_UTF8_ERROR:
                        $error = 'Malformed UTF-8 data.';
                        break;
                    case PREG_BAD_UTF8_OFFSET_ERROR:
                        $error = 'Offset doesn\'t correspond to the begin of a valid UTF-8 code point.';
                        break;
                    default:
                        $error = 'Unable to parse.';
                }

                throw new ParseException($error, $this->getRealCurrentLineNb() + 1, $this->currentLine);
            }
        }

        if (isset($mbEncoding)) {
            mb_internal_encoding($mbEncoding);
=======
                    return $value;
                }

                // try to parse the value as a multi-line string as a last resort
                if (0 === $this->currentLineNb) {
                    $previousLineWasNewline = false;
                    $previousLineWasTerminatedWithBackslash = false;
                    $value = '';

                    foreach ($this->lines as $line) {
                        // If the indentation is not consistent at offset 0, it is to be considered as a ParseError
                        if (0 === $this->offset && !$deprecatedUsage && isset($line[0]) && ' ' === $line[0]) {
                            throw new ParseException('Unable to parse.', $this->getRealCurrentLineNb() + 1, $this->currentLine, $this->filename);
                        }
                        if ('' === trim($line)) {
                            $value .= "\n";
                        } elseif (!$previousLineWasNewline && !$previousLineWasTerminatedWithBackslash) {
                            $value .= ' ';
                        }

                        if ('' !== trim($line) && '\\' === substr($line, -1)) {
                            $value .= ltrim(substr($line, 0, -1));
                        } elseif ('' !== trim($line)) {
                            $value .= trim($line);
                        }

                        if ('' === trim($line)) {
                            $previousLineWasNewline = true;
                            $previousLineWasTerminatedWithBackslash = false;
                        } elseif ('\\' === substr($line, -1)) {
                            $previousLineWasNewline = false;
                            $previousLineWasTerminatedWithBackslash = true;
                        } else {
                            $previousLineWasNewline = false;
                            $previousLineWasTerminatedWithBackslash = false;
                        }
                    }

                    try {
                        return Inline::parse(trim($value));
                    } catch (ParseException $e) {
                        // fall-through to the ParseException thrown below
                    }
                }

                throw new ParseException('Unable to parse.', $this->getRealCurrentLineNb() + 1, $this->currentLine, $this->filename);
            }
        } while ($this->moveToNextLine());

        if (null !== $tag) {
            $data = new TaggedValue($tag, $data);
        }

        if (Yaml::PARSE_OBJECT_FOR_MAP & $flags && !\is_object($data) && 'mapping' === $context) {
            $object = new \stdClass();

            foreach ($data as $key => $value) {
                $object->$key = $value;
            }

            $data = $object;
>>>>>>> git-aline/master/master
        }

        return empty($data) ? null : $data;
    }

<<<<<<< HEAD
    /**
     * Returns the current line number (takes the offset into account).
     *
     * @return int The current line number
     */
    private function getRealCurrentLineNb()
    {
        return $this->currentLineNb + $this->offset;
=======
    private function parseBlock($offset, $yaml, $flags)
    {
        $skippedLineNumbers = $this->skippedLineNumbers;

        foreach ($this->locallySkippedLineNumbers as $lineNumber) {
            if ($lineNumber < $offset) {
                continue;
            }

            $skippedLineNumbers[] = $lineNumber;
        }

        $parser = new self();
        $parser->offset = $offset;
        $parser->totalNumberOfLines = $this->totalNumberOfLines;
        $parser->skippedLineNumbers = $skippedLineNumbers;
        $parser->refs = &$this->refs;

        return $parser->doParse($yaml, $flags);
    }

    /**
     * Returns the current line number (takes the offset into account).
     *
     * @internal
     *
     * @return int The current line number
     */
    public function getRealCurrentLineNb()
    {
        $realCurrentLineNumber = $this->currentLineNb + $this->offset;

        foreach ($this->skippedLineNumbers as $skippedLineNumber) {
            if ($skippedLineNumber > $realCurrentLineNumber) {
                break;
            }

            ++$realCurrentLineNumber;
        }

        return $realCurrentLineNumber;
>>>>>>> git-aline/master/master
    }

    /**
     * Returns the current line indentation.
     *
     * @return int The current line indentation
     */
    private function getCurrentLineIndentation()
    {
<<<<<<< HEAD
        return strlen($this->currentLine) - strlen(ltrim($this->currentLine, ' '));
=======
        return \strlen($this->currentLine) - \strlen(ltrim($this->currentLine, ' '));
>>>>>>> git-aline/master/master
    }

    /**
     * Returns the next embed block of YAML.
     *
     * @param int  $indentation The indent level at which the block is to be read, or null for default
     * @param bool $inSequence  True if the enclosing data structure is a sequence
     *
     * @return string A YAML string
     *
     * @throws ParseException When indentation problem are detected
     */
    private function getNextEmbedBlock($indentation = null, $inSequence = false)
    {
        $oldLineIndentation = $this->getCurrentLineIndentation();

        if (!$this->moveToNextLine()) {
            return;
        }

        if (null === $indentation) {
<<<<<<< HEAD
            $newIndent = $this->getCurrentLineIndentation();

            $unindentedEmbedBlock = $this->isStringUnIndentedCollectionItem($this->currentLine);

            if (!$this->isCurrentLineEmpty() && 0 === $newIndent && !$unindentedEmbedBlock) {
                throw new ParseException('Indentation problem.', $this->getRealCurrentLineNb() + 1, $this->currentLine);
=======
            $newIndent = null;
            $movements = 0;

            do {
                $EOF = false;

                // empty and comment-like lines do not influence the indentation depth
                if ($this->isCurrentLineEmpty() || $this->isCurrentLineComment()) {
                    $EOF = !$this->moveToNextLine();

                    if (!$EOF) {
                        ++$movements;
                    }
                } else {
                    $newIndent = $this->getCurrentLineIndentation();
                }
            } while (!$EOF && null === $newIndent);

            for ($i = 0; $i < $movements; ++$i) {
                $this->moveToPreviousLine();
            }

            $unindentedEmbedBlock = $this->isStringUnIndentedCollectionItem();

            if (!$this->isCurrentLineEmpty() && 0 === $newIndent && !$unindentedEmbedBlock) {
                throw new ParseException('Indentation problem.', $this->getRealCurrentLineNb() + 1, $this->currentLine, $this->filename);
>>>>>>> git-aline/master/master
            }
        } else {
            $newIndent = $indentation;
        }

        $data = array();
        if ($this->getCurrentLineIndentation() >= $newIndent) {
            $data[] = substr($this->currentLine, $newIndent);
<<<<<<< HEAD
=======
        } elseif ($this->isCurrentLineEmpty() || $this->isCurrentLineComment()) {
            $data[] = $this->currentLine;
>>>>>>> git-aline/master/master
        } else {
            $this->moveToPreviousLine();

            return;
        }

        if ($inSequence && $oldLineIndentation === $newIndent && isset($data[0][0]) && '-' === $data[0][0]) {
            // the previous line contained a dash but no item content, this line is a sequence item with the same indentation
            // and therefore no nested list or mapping
            $this->moveToPreviousLine();

            return;
        }

<<<<<<< HEAD
        $isItUnindentedCollection = $this->isStringUnIndentedCollectionItem($this->currentLine);

        // Comments must not be removed inside a block scalar
        $removeCommentsPattern = '~'.self::BLOCK_SCALAR_HEADER_PATTERN.'$~';
        $removeComments = !preg_match($removeCommentsPattern, $this->currentLine);
=======
        $isItUnindentedCollection = $this->isStringUnIndentedCollectionItem();
>>>>>>> git-aline/master/master

        while ($this->moveToNextLine()) {
            $indent = $this->getCurrentLineIndentation();

<<<<<<< HEAD
            if ($indent === $newIndent) {
                $removeComments = !preg_match($removeCommentsPattern, $this->currentLine);
            }

            if ($isItUnindentedCollection && !$this->isStringUnIndentedCollectionItem($this->currentLine) && $newIndent === $indent) {
=======
            if ($isItUnindentedCollection && !$this->isCurrentLineEmpty() && !$this->isStringUnIndentedCollectionItem() && $newIndent === $indent) {
>>>>>>> git-aline/master/master
                $this->moveToPreviousLine();
                break;
            }

            if ($this->isCurrentLineBlank()) {
                $data[] = substr($this->currentLine, $newIndent);
                continue;
            }

<<<<<<< HEAD
            if ($removeComments && $this->isCurrentLineComment()) {
                continue;
            }

            if ($indent >= $newIndent) {
                $data[] = substr($this->currentLine, $newIndent);
=======
            if ($indent >= $newIndent) {
                $data[] = substr($this->currentLine, $newIndent);
            } elseif ($this->isCurrentLineComment()) {
                $data[] = $this->currentLine;
>>>>>>> git-aline/master/master
            } elseif (0 == $indent) {
                $this->moveToPreviousLine();

                break;
            } else {
<<<<<<< HEAD
                throw new ParseException('Indentation problem.', $this->getRealCurrentLineNb() + 1, $this->currentLine);
=======
                throw new ParseException('Indentation problem.', $this->getRealCurrentLineNb() + 1, $this->currentLine, $this->filename);
>>>>>>> git-aline/master/master
            }
        }

        return implode("\n", $data);
    }

    /**
     * Moves the parser to the next line.
     *
     * @return bool
     */
    private function moveToNextLine()
    {
<<<<<<< HEAD
        if ($this->currentLineNb >= count($this->lines) - 1) {
=======
        if ($this->currentLineNb >= \count($this->lines) - 1) {
>>>>>>> git-aline/master/master
            return false;
        }

        $this->currentLine = $this->lines[++$this->currentLineNb];

        return true;
    }

    /**
     * Moves the parser to the previous line.
<<<<<<< HEAD
     */
    private function moveToPreviousLine()
    {
        $this->currentLine = $this->lines[--$this->currentLineNb];
=======
     *
     * @return bool
     */
    private function moveToPreviousLine()
    {
        if ($this->currentLineNb < 1) {
            return false;
        }

        $this->currentLine = $this->lines[--$this->currentLineNb];

        return true;
>>>>>>> git-aline/master/master
    }

    /**
     * Parses a YAML value.
     *
<<<<<<< HEAD
     * @param string $value                  A YAML value
     * @param bool   $exceptionOnInvalidType True if an exception must be thrown on invalid types false otherwise
     * @param bool   $objectSupport          True if object support is enabled, false otherwise
     * @param bool   $objectForMap           true if maps should return a stdClass instead of array()
=======
     * @param string $value   A YAML value
     * @param int    $flags   A bit field of PARSE_* constants to customize the YAML parser behavior
     * @param string $context The parser context (either sequence or mapping)
>>>>>>> git-aline/master/master
     *
     * @return mixed A PHP value
     *
     * @throws ParseException When reference does not exist
     */
<<<<<<< HEAD
    private function parseValue($value, $exceptionOnInvalidType, $objectSupport, $objectForMap)
=======
    private function parseValue($value, $flags, $context)
>>>>>>> git-aline/master/master
    {
        if (0 === strpos($value, '*')) {
            if (false !== $pos = strpos($value, '#')) {
                $value = substr($value, 1, $pos - 2);
            } else {
                $value = substr($value, 1);
            }

            if (!array_key_exists($value, $this->refs)) {
<<<<<<< HEAD
                throw new ParseException(sprintf('Reference "%s" does not exist.', $value), $this->currentLine);
=======
                throw new ParseException(sprintf('Reference "%s" does not exist.', $value), $this->currentLineNb + 1, $this->currentLine, $this->filename);
>>>>>>> git-aline/master/master
            }

            return $this->refs[$value];
        }

<<<<<<< HEAD
        if (preg_match('/^'.self::BLOCK_SCALAR_HEADER_PATTERN.'$/', $value, $matches)) {
            $modifiers = isset($matches['modifiers']) ? $matches['modifiers'] : '';

            return $this->parseBlockScalar($matches['separator'], preg_replace('#\d+#', '', $modifiers), (int) abs($modifiers));
        }

        try {
            return Inline::parse($value, $exceptionOnInvalidType, $objectSupport, $objectForMap, $this->refs);
=======
        if (self::preg_match('/^(?:'.self::TAG_PATTERN.' +)?'.self::BLOCK_SCALAR_HEADER_PATTERN.'$/', $value, $matches)) {
            $modifiers = isset($matches['modifiers']) ? $matches['modifiers'] : '';

            $data = $this->parseBlockScalar($matches['separator'], preg_replace('#\d+#', '', $modifiers), (int) abs($modifiers));

            if ('' !== $matches['tag']) {
                if ('!!binary' === $matches['tag']) {
                    return Inline::evaluateBinaryScalar($data);
                } elseif ('tagged' === $matches['tag']) {
                    return new TaggedValue(substr($matches['tag'], 1), $data);
                } elseif ('!' !== $matches['tag']) {
                    @trigger_error($this->getDeprecationMessage(sprintf('Using the custom tag "%s" for the value "%s" is deprecated since Symfony 3.3. It will be replaced by an instance of %s in 4.0.', $matches['tag'], $data, TaggedValue::class)), E_USER_DEPRECATED);
                }
            }

            return $data;
        }

        try {
            $quotation = '' !== $value && ('"' === $value[0] || "'" === $value[0]) ? $value[0] : null;

            // do not take following lines into account when the current line is a quoted single line value
            if (null !== $quotation && self::preg_match('/^'.$quotation.'.*'.$quotation.'(\s*#.*)?$/', $value)) {
                return Inline::parse($value, $flags, $this->refs);
            }

            $lines = array();

            while ($this->moveToNextLine()) {
                // unquoted strings end before the first unindented line
                if (null === $quotation && 0 === $this->getCurrentLineIndentation()) {
                    $this->moveToPreviousLine();

                    break;
                }

                $lines[] = trim($this->currentLine);

                // quoted string values end with a line that is terminated with the quotation character
                if ('' !== $this->currentLine && substr($this->currentLine, -1) === $quotation) {
                    break;
                }
            }

            for ($i = 0, $linesCount = \count($lines), $previousLineBlank = false; $i < $linesCount; ++$i) {
                if ('' === $lines[$i]) {
                    $value .= "\n";
                    $previousLineBlank = true;
                } elseif ($previousLineBlank) {
                    $value .= $lines[$i];
                    $previousLineBlank = false;
                } else {
                    $value .= ' '.$lines[$i];
                    $previousLineBlank = false;
                }
            }

            Inline::$parsedLineNumber = $this->getRealCurrentLineNb();

            $parsedValue = Inline::parse($value, $flags, $this->refs);

            if ('mapping' === $context && \is_string($parsedValue) && '"' !== $value[0] && "'" !== $value[0] && '[' !== $value[0] && '{' !== $value[0] && '!' !== $value[0] && false !== strpos($parsedValue, ': ')) {
                throw new ParseException('A colon cannot be used in an unquoted mapping value.', $this->getRealCurrentLineNb() + 1, $value, $this->filename);
            }

            return $parsedValue;
>>>>>>> git-aline/master/master
        } catch (ParseException $e) {
            $e->setParsedLine($this->getRealCurrentLineNb() + 1);
            $e->setSnippet($this->currentLine);

            throw $e;
        }
    }

    /**
     * Parses a block scalar.
     *
     * @param string $style       The style indicator that was used to begin this block scalar (| or >)
     * @param string $chomping    The chomping indicator that was used to begin this block scalar (+ or -)
     * @param int    $indentation The indentation indicator that was used to begin this block scalar
     *
     * @return string The text value
     */
    private function parseBlockScalar($style, $chomping = '', $indentation = 0)
    {
        $notEOF = $this->moveToNextLine();
        if (!$notEOF) {
            return '';
        }

        $isCurrentLineBlank = $this->isCurrentLineBlank();
<<<<<<< HEAD
        $text = '';
=======
        $blockLines = array();
>>>>>>> git-aline/master/master

        // leading blank lines are consumed before determining indentation
        while ($notEOF && $isCurrentLineBlank) {
            // newline only if not EOF
            if ($notEOF = $this->moveToNextLine()) {
<<<<<<< HEAD
                $text .= "\n";
=======
                $blockLines[] = '';
>>>>>>> git-aline/master/master
                $isCurrentLineBlank = $this->isCurrentLineBlank();
            }
        }

        // determine indentation if not specified
        if (0 === $indentation) {
<<<<<<< HEAD
            if (preg_match('/^ +/', $this->currentLine, $matches)) {
                $indentation = strlen($matches[0]);
=======
            if (self::preg_match('/^ +/', $this->currentLine, $matches)) {
                $indentation = \strlen($matches[0]);
>>>>>>> git-aline/master/master
            }
        }

        if ($indentation > 0) {
            $pattern = sprintf('/^ {%d}(.*)$/', $indentation);

            while (
                $notEOF && (
                    $isCurrentLineBlank ||
<<<<<<< HEAD
                    preg_match($pattern, $this->currentLine, $matches)
                )
            ) {
                if ($isCurrentLineBlank) {
                    $text .= substr($this->currentLine, $indentation);
                } else {
                    $text .= $matches[1];
=======
                    self::preg_match($pattern, $this->currentLine, $matches)
                )
            ) {
                if ($isCurrentLineBlank && \strlen($this->currentLine) > $indentation) {
                    $blockLines[] = substr($this->currentLine, $indentation);
                } elseif ($isCurrentLineBlank) {
                    $blockLines[] = '';
                } else {
                    $blockLines[] = $matches[1];
>>>>>>> git-aline/master/master
                }

                // newline only if not EOF
                if ($notEOF = $this->moveToNextLine()) {
<<<<<<< HEAD
                    $text .= "\n";
=======
>>>>>>> git-aline/master/master
                    $isCurrentLineBlank = $this->isCurrentLineBlank();
                }
            }
        } elseif ($notEOF) {
<<<<<<< HEAD
            $text .= "\n";
        }

        if ($notEOF) {
            $this->moveToPreviousLine();
=======
            $blockLines[] = '';
        }

        if ($notEOF) {
            $blockLines[] = '';
            $this->moveToPreviousLine();
        } elseif (!$notEOF && !$this->isCurrentLineLastLineInDocument()) {
            $blockLines[] = '';
>>>>>>> git-aline/master/master
        }

        // folded style
        if ('>' === $style) {
<<<<<<< HEAD
            // folded lines
            // replace all non-leading/non-trailing single newlines with spaces
            preg_match('/(\n*)$/', $text, $matches);
            $text = preg_replace('/(?<!\n|^)\n(?!\n)/', ' ', rtrim($text, "\n"));
            $text .= $matches[1];

            // empty separation lines
            // remove one newline from each group of non-leading/non-trailing newlines
            $text = preg_replace('/[^\n]\n+\K\n(?=[^\n])/', '', $text);
=======
            $text = '';
            $previousLineIndented = false;
            $previousLineBlank = false;

            for ($i = 0, $blockLinesCount = \count($blockLines); $i < $blockLinesCount; ++$i) {
                if ('' === $blockLines[$i]) {
                    $text .= "\n";
                    $previousLineIndented = false;
                    $previousLineBlank = true;
                } elseif (' ' === $blockLines[$i][0]) {
                    $text .= "\n".$blockLines[$i];
                    $previousLineIndented = true;
                    $previousLineBlank = false;
                } elseif ($previousLineIndented) {
                    $text .= "\n".$blockLines[$i];
                    $previousLineIndented = false;
                    $previousLineBlank = false;
                } elseif ($previousLineBlank || 0 === $i) {
                    $text .= $blockLines[$i];
                    $previousLineIndented = false;
                    $previousLineBlank = false;
                } else {
                    $text .= ' '.$blockLines[$i];
                    $previousLineIndented = false;
                    $previousLineBlank = false;
                }
            }
        } else {
            $text = implode("\n", $blockLines);
>>>>>>> git-aline/master/master
        }

        // deal with trailing newlines
        if ('' === $chomping) {
            $text = preg_replace('/\n+$/', "\n", $text);
        } elseif ('-' === $chomping) {
            $text = preg_replace('/\n+$/', '', $text);
        }

        return $text;
    }

    /**
     * Returns true if the next line is indented.
     *
     * @return bool Returns true if the next line is indented, false otherwise
     */
    private function isNextLineIndented()
    {
        $currentIndentation = $this->getCurrentLineIndentation();
<<<<<<< HEAD
        $EOF = !$this->moveToNextLine();

        while (!$EOF && $this->isCurrentLineEmpty()) {
            $EOF = !$this->moveToNextLine();
        }
=======
        $movements = 0;

        do {
            $EOF = !$this->moveToNextLine();

            if (!$EOF) {
                ++$movements;
            }
        } while (!$EOF && ($this->isCurrentLineEmpty() || $this->isCurrentLineComment()));
>>>>>>> git-aline/master/master

        if ($EOF) {
            return false;
        }

<<<<<<< HEAD
        $ret = false;
        if ($this->getCurrentLineIndentation() > $currentIndentation) {
            $ret = true;
        }

        $this->moveToPreviousLine();
=======
        $ret = $this->getCurrentLineIndentation() > $currentIndentation;

        for ($i = 0; $i < $movements; ++$i) {
            $this->moveToPreviousLine();
        }
>>>>>>> git-aline/master/master

        return $ret;
    }

    /**
     * Returns true if the current line is blank or if it is a comment line.
     *
     * @return bool Returns true if the current line is empty or if it is a comment line, false otherwise
     */
    private function isCurrentLineEmpty()
    {
        return $this->isCurrentLineBlank() || $this->isCurrentLineComment();
    }

    /**
     * Returns true if the current line is blank.
     *
     * @return bool Returns true if the current line is blank, false otherwise
     */
    private function isCurrentLineBlank()
    {
        return '' == trim($this->currentLine, ' ');
    }

    /**
     * Returns true if the current line is a comment line.
     *
     * @return bool Returns true if the current line is a comment line, false otherwise
     */
    private function isCurrentLineComment()
    {
        //checking explicitly the first char of the trim is faster than loops or strpos
        $ltrimmedLine = ltrim($this->currentLine, ' ');

<<<<<<< HEAD
        return $ltrimmedLine[0] === '#';
=======
        return '' !== $ltrimmedLine && '#' === $ltrimmedLine[0];
    }

    private function isCurrentLineLastLineInDocument()
    {
        return ($this->offset + $this->currentLineNb) >= ($this->totalNumberOfLines - 1);
>>>>>>> git-aline/master/master
    }

    /**
     * Cleanups a YAML string to be parsed.
     *
     * @param string $value The input YAML string
     *
     * @return string A cleaned up YAML string
     */
    private function cleanup($value)
    {
        $value = str_replace(array("\r\n", "\r"), "\n", $value);

        // strip YAML header
        $count = 0;
        $value = preg_replace('#^\%YAML[: ][\d\.]+.*\n#u', '', $value, -1, $count);
        $this->offset += $count;

        // remove leading comments
        $trimmedValue = preg_replace('#^(\#.*?\n)+#s', '', $value, -1, $count);
<<<<<<< HEAD
        if ($count == 1) {
=======
        if (1 === $count) {
>>>>>>> git-aline/master/master
            // items have been removed, update the offset
            $this->offset += substr_count($value, "\n") - substr_count($trimmedValue, "\n");
            $value = $trimmedValue;
        }

        // remove start of the document marker (---)
        $trimmedValue = preg_replace('#^\-\-\-.*?\n#s', '', $value, -1, $count);
<<<<<<< HEAD
        if ($count == 1) {
=======
        if (1 === $count) {
>>>>>>> git-aline/master/master
            // items have been removed, update the offset
            $this->offset += substr_count($value, "\n") - substr_count($trimmedValue, "\n");
            $value = $trimmedValue;

            // remove end of the document marker (...)
            $value = preg_replace('#\.\.\.\s*$#', '', $value);
        }

        return $value;
    }

    /**
     * Returns true if the next line starts unindented collection.
     *
     * @return bool Returns true if the next line starts unindented collection, false otherwise
     */
    private function isNextLineUnIndentedCollection()
    {
        $currentIndentation = $this->getCurrentLineIndentation();
<<<<<<< HEAD
        $notEOF = $this->moveToNextLine();

        while ($notEOF && $this->isCurrentLineEmpty()) {
            $notEOF = $this->moveToNextLine();
        }

        if (false === $notEOF) {
            return false;
        }

        $ret = false;
        if (
            $this->getCurrentLineIndentation() == $currentIndentation
            &&
            $this->isStringUnIndentedCollectionItem($this->currentLine)
        ) {
            $ret = true;
        }

        $this->moveToPreviousLine();
=======
        $movements = 0;

        do {
            $EOF = !$this->moveToNextLine();

            if (!$EOF) {
                ++$movements;
            }
        } while (!$EOF && ($this->isCurrentLineEmpty() || $this->isCurrentLineComment()));

        if ($EOF) {
            return false;
        }

        $ret = $this->getCurrentLineIndentation() === $currentIndentation && $this->isStringUnIndentedCollectionItem();

        for ($i = 0; $i < $movements; ++$i) {
            $this->moveToPreviousLine();
        }
>>>>>>> git-aline/master/master

        return $ret;
    }

    /**
     * Returns true if the string is un-indented collection item.
     *
     * @return bool Returns true if the string is un-indented collection item, false otherwise
     */
    private function isStringUnIndentedCollectionItem()
    {
<<<<<<< HEAD
        return (0 === strpos($this->currentLine, '- '));
=======
        return '-' === rtrim($this->currentLine) || 0 === strpos($this->currentLine, '- ');
    }

    /**
     * A local wrapper for `preg_match` which will throw a ParseException if there
     * is an internal error in the PCRE engine.
     *
     * This avoids us needing to check for "false" every time PCRE is used
     * in the YAML engine
     *
     * @throws ParseException on a PCRE internal error
     *
     * @see preg_last_error()
     *
     * @internal
     */
    public static function preg_match($pattern, $subject, &$matches = null, $flags = 0, $offset = 0)
    {
        if (false === $ret = preg_match($pattern, $subject, $matches, $flags, $offset)) {
            switch (preg_last_error()) {
                case PREG_INTERNAL_ERROR:
                    $error = 'Internal PCRE error.';
                    break;
                case PREG_BACKTRACK_LIMIT_ERROR:
                    $error = 'pcre.backtrack_limit reached.';
                    break;
                case PREG_RECURSION_LIMIT_ERROR:
                    $error = 'pcre.recursion_limit reached.';
                    break;
                case PREG_BAD_UTF8_ERROR:
                    $error = 'Malformed UTF-8 data.';
                    break;
                case PREG_BAD_UTF8_OFFSET_ERROR:
                    $error = 'Offset doesn\'t correspond to the begin of a valid UTF-8 code point.';
                    break;
                default:
                    $error = 'Error.';
            }

            throw new ParseException($error);
        }

        return $ret;
    }

    /**
     * Trim the tag on top of the value.
     *
     * Prevent values such as `!foo {quz: bar}` to be considered as
     * a mapping block.
     */
    private function trimTag($value)
    {
        if ('!' === $value[0]) {
            return ltrim(substr($value, 1, strcspn($value, " \r\n", 1)), ' ');
        }

        return $value;
    }

    private function getLineTag($value, $flags, $nextLineCheck = true)
    {
        if ('' === $value || '!' !== $value[0] || 1 !== self::preg_match('/^'.self::TAG_PATTERN.' *( +#.*)?$/', $value, $matches)) {
            return;
        }

        if ($nextLineCheck && !$this->isNextLineIndented()) {
            return;
        }

        $tag = substr($matches['tag'], 1);

        // Built-in tags
        if ($tag && '!' === $tag[0]) {
            throw new ParseException(sprintf('The built-in tag "!%s" is not implemented.', $tag), $this->getRealCurrentLineNb() + 1, $value, $this->filename);
        }

        if (Yaml::PARSE_CUSTOM_TAGS & $flags) {
            return $tag;
        }

        throw new ParseException(sprintf('Tags support is not enabled. You must use the flag `Yaml::PARSE_CUSTOM_TAGS` to use "%s".', $matches['tag']), $this->getRealCurrentLineNb() + 1, $value, $this->filename);
    }

    private function getDeprecationMessage($message)
    {
        $message = rtrim($message, '.');

        if (null !== $this->filename) {
            $message .= ' in '.$this->filename;
        }

        $message .= ' on line '.($this->getRealCurrentLineNb() + 1);

        return $message.'.';
>>>>>>> git-aline/master/master
    }
}
