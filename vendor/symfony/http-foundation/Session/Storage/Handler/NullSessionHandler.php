<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Session\Storage\Handler;

/**
<<<<<<< HEAD
 * NullSessionHandler.
 *
=======
>>>>>>> git-aline/master/master
 * Can be used in unit testing or in a situations where persisted sessions are not desired.
 *
 * @author Drak <drak@zikula.org>
 */
<<<<<<< HEAD
class NullSessionHandler implements \SessionHandlerInterface
=======
class NullSessionHandler extends AbstractSessionHandler
>>>>>>> git-aline/master/master
{
    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function open($savePath, $sessionName)
=======
    public function close()
>>>>>>> git-aline/master/master
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function close()
=======
    public function validateId($sessionId)
>>>>>>> git-aline/master/master
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function read($sessionId)
=======
    protected function doRead($sessionId)
>>>>>>> git-aline/master/master
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function write($sessionId, $data)
=======
    public function updateTimestamp($sessionId, $data)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function doWrite($sessionId, $data)
>>>>>>> git-aline/master/master
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function destroy($sessionId)
=======
    protected function doDestroy($sessionId)
>>>>>>> git-aline/master/master
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function gc($maxlifetime)
    {
        return true;
    }
}
