<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\DependencyInjection;

/**
 * Represents a variable.
 *
 *     $var = new Variable('a');
 *
 * will be dumped as
 *
 *     $a
 *
 * by the PHP dumper.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class Variable
{
    private $name;

    /**
<<<<<<< HEAD
     * Constructor.
     *
=======
>>>>>>> git-aline/master/master
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

<<<<<<< HEAD
    /**
     * Converts the object to a string.
     *
     * @return string
     */
=======
>>>>>>> git-aline/master/master
    public function __toString()
    {
        return $this->name;
    }
}
