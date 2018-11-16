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
<<<<<<< HEAD
=======

/**
 * @final
 */
>>>>>>> git-aline/master/master
class Twig_Extension_StringLoader extends Twig_Extension
{
    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('template_from_string', 'twig_template_from_string', array('needs_environment' => true)),
        );
    }

    public function getName()
    {
        return 'string_loader';
    }
}

/**
 * Loads a template from a string.
 *
 * <pre>
 * {{ include(template_from_string("Hello {{ name }}")) }}
 * </pre>
 *
 * @param Twig_Environment $env      A Twig_Environment instance
 * @param string           $template A template as a string or object implementing __toString()
 *
<<<<<<< HEAD
 * @return Twig_Template A Twig_Template instance
=======
 * @return Twig_Template
>>>>>>> git-aline/master/master
 */
function twig_template_from_string(Twig_Environment $env, $template)
{
    return $env->createTemplate((string) $template);
}
<<<<<<< HEAD
=======

class_alias('Twig_Extension_StringLoader', 'Twig\Extension\StringLoaderExtension', false);
>>>>>>> git-aline/master/master
