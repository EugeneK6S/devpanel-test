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
<<<<<<< HEAD
=======

/**
 * @final
 */
>>>>>>> git-aline/master/master
class Twig_Extension_Escaper extends Twig_Extension
{
    protected $defaultStrategy;

    /**
<<<<<<< HEAD
     * Constructor.
     *
=======
>>>>>>> git-aline/master/master
     * @param string|false|callable $defaultStrategy An escaping strategy
     *
     * @see setDefaultStrategy()
     */
    public function __construct($defaultStrategy = 'html')
    {
        $this->setDefaultStrategy($defaultStrategy);
    }

    public function getTokenParsers()
    {
        return array(new Twig_TokenParser_AutoEscape());
    }

    public function getNodeVisitors()
    {
        return array(new Twig_NodeVisitor_Escaper());
    }

    public function getFilters()
    {
        return array(
            new Twig_SimpleFilter('raw', 'twig_raw_filter', array('is_safe' => array('all'))),
        );
    }

    /**
     * Sets the default strategy to use when not defined by the user.
     *
     * The strategy can be a valid PHP callback that takes the template
<<<<<<< HEAD
     * "filename" as an argument and returns the strategy to use.
=======
     * name as an argument and returns the strategy to use.
>>>>>>> git-aline/master/master
     *
     * @param string|false|callable $defaultStrategy An escaping strategy
     */
    public function setDefaultStrategy($defaultStrategy)
    {
        // for BC
        if (true === $defaultStrategy) {
<<<<<<< HEAD
            @trigger_error('Using "true" as the default strategy is deprecated. Use "html" instead.', E_USER_DEPRECATED);
=======
            @trigger_error('Using "true" as the default strategy is deprecated since version 1.21. Use "html" instead.', E_USER_DEPRECATED);
>>>>>>> git-aline/master/master

            $defaultStrategy = 'html';
        }

        if ('filename' === $defaultStrategy) {
<<<<<<< HEAD
=======
            @trigger_error('Using "filename" as the default strategy is deprecated since version 1.27. Use "name" instead.', E_USER_DEPRECATED);

            $defaultStrategy = 'name';
        }

        if ('name' === $defaultStrategy) {
>>>>>>> git-aline/master/master
            $defaultStrategy = array('Twig_FileExtensionEscapingStrategy', 'guess');
        }

        $this->defaultStrategy = $defaultStrategy;
    }

    /**
     * Gets the default strategy to use when not defined by the user.
     *
<<<<<<< HEAD
     * @param string $filename The template "filename"
     *
     * @return string|false The default strategy to use for the template
     */
    public function getDefaultStrategy($filename)
=======
     * @param string $name The template name
     *
     * @return string|false The default strategy to use for the template
     */
    public function getDefaultStrategy($name)
>>>>>>> git-aline/master/master
    {
        // disable string callables to avoid calling a function named html or js,
        // or any other upcoming escaping strategy
        if (!is_string($this->defaultStrategy) && false !== $this->defaultStrategy) {
<<<<<<< HEAD
            return call_user_func($this->defaultStrategy, $filename);
=======
            return call_user_func($this->defaultStrategy, $name);
>>>>>>> git-aline/master/master
        }

        return $this->defaultStrategy;
    }

    public function getName()
    {
        return 'escaper';
    }
}

/**
 * Marks a variable as being safe.
 *
 * @param string $string A PHP variable
 *
 * @return string
 */
function twig_raw_filter($string)
{
    return $string;
}
<<<<<<< HEAD
=======

class_alias('Twig_Extension_Escaper', 'Twig\Extension\EscaperExtension', false);
>>>>>>> git-aline/master/master
