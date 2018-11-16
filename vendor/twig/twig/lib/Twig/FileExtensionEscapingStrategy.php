<?php

/*
 * This file is part of Twig.
 *
<<<<<<< HEAD
 * (c) 2015 Fabien Potencier
=======
 * (c) Fabien Potencier
>>>>>>> git-aline/master/master
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Default autoescaping strategy based on file names.
 *
 * This strategy sets the HTML as the default autoescaping strategy,
<<<<<<< HEAD
 * but changes it based on the filename.
=======
 * but changes it based on the template name.
>>>>>>> git-aline/master/master
 *
 * Note that there is no runtime performance impact as the
 * default autoescaping strategy is set at compilation time.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Twig_FileExtensionEscapingStrategy
{
    /**
     * Guesses the best autoescaping strategy based on the file name.
     *
<<<<<<< HEAD
     * @param string $filename The template file name
     *
     * @return string|false The escaping strategy name to use or false to disable
     */
    public static function guess($filename)
    {
        if (in_array(substr($filename, -1), array('/', '\\'))) {
            return 'html'; // return html for directories
        }

        if ('.twig' === substr($filename, -5)) {
            $filename = substr($filename, 0, -5);
        }

        $extension = pathinfo($filename, PATHINFO_EXTENSION);
=======
     * @param string $name The template name
     *
     * @return string|false The escaping strategy name to use or false to disable
     */
    public static function guess($name)
    {
        if (in_array(substr($name, -1), array('/', '\\'))) {
            return 'html'; // return html for directories
        }

        if ('.twig' === substr($name, -5)) {
            $name = substr($name, 0, -5);
        }

        $extension = pathinfo($name, PATHINFO_EXTENSION);
>>>>>>> git-aline/master/master

        switch ($extension) {
            case 'js':
                return 'js';

            case 'css':
                return 'css';

            case 'txt':
                return false;

            default:
                return 'html';
        }
    }
}
<<<<<<< HEAD
=======

class_alias('Twig_FileExtensionEscapingStrategy', 'Twig\FileExtensionEscapingStrategy', false);
>>>>>>> git-aline/master/master
