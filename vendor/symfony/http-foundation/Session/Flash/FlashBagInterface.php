<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Session\Flash;

use Symfony\Component\HttpFoundation\Session\SessionBagInterface;

/**
 * FlashBagInterface.
 *
 * @author Drak <drak@zikula.org>
 */
interface FlashBagInterface extends SessionBagInterface
{
    /**
     * Adds a flash message for type.
     *
     * @param string $type
<<<<<<< HEAD
     * @param string $message
=======
     * @param mixed  $message
>>>>>>> git-aline/master/master
     */
    public function add($type, $message);

    /**
     * Registers a message for a given type.
     *
     * @param string       $type
     * @param string|array $message
     */
    public function set($type, $message);

    /**
     * Gets flash messages for a given type.
     *
<<<<<<< HEAD
     * @param string $type    Message category type.
     * @param array  $default Default value if $type does not exist.
=======
     * @param string $type    Message category type
     * @param array  $default Default value if $type does not exist
>>>>>>> git-aline/master/master
     *
     * @return array
     */
    public function peek($type, array $default = array());

    /**
     * Gets all flash messages.
     *
     * @return array
     */
    public function peekAll();

    /**
     * Gets and clears flash from the stack.
     *
     * @param string $type
<<<<<<< HEAD
     * @param array  $default Default value if $type does not exist.
=======
     * @param array  $default Default value if $type does not exist
>>>>>>> git-aline/master/master
     *
     * @return array
     */
    public function get($type, array $default = array());

    /**
     * Gets and clears flashes from the stack.
     *
     * @return array
     */
    public function all();

    /**
     * Sets all flash messages.
     */
    public function setAll(array $messages);

    /**
     * Has flash messages for a given type?
     *
     * @param string $type
     *
     * @return bool
     */
    public function has($type);

    /**
     * Returns a list of all defined types.
     *
     * @return array
     */
    public function keys();
}
