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
 * Represents a callable template function.
 *
 * Use Twig_SimpleFunction instead.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @deprecated since 1.12 (to be removed in 2.0)
 */
interface Twig_FunctionCallableInterface
{
    public function getCallable();
}
