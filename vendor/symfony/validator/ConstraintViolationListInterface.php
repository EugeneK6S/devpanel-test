<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Validator;

/**
 * A list of constraint violations.
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
interface ConstraintViolationListInterface extends \Traversable, \Countable, \ArrayAccess
{
    /**
     * Adds a constraint violation to this list.
<<<<<<< HEAD
     *
     * @param ConstraintViolationInterface $violation The violation to add.
=======
>>>>>>> git-aline/master/master
     */
    public function add(ConstraintViolationInterface $violation);

    /**
     * Merges an existing violation list into this list.
<<<<<<< HEAD
     *
     * @param ConstraintViolationListInterface $otherList The list to merge.
=======
>>>>>>> git-aline/master/master
     */
    public function addAll(ConstraintViolationListInterface $otherList);

    /**
     * Returns the violation at a given offset.
     *
<<<<<<< HEAD
     * @param int $offset The offset of the violation.
     *
     * @return ConstraintViolationInterface The violation.
     *
     * @throws \OutOfBoundsException If the offset does not exist.
=======
     * @param int $offset The offset of the violation
     *
     * @return ConstraintViolationInterface The violation
     *
     * @throws \OutOfBoundsException if the offset does not exist
>>>>>>> git-aline/master/master
     */
    public function get($offset);

    /**
     * Returns whether the given offset exists.
     *
<<<<<<< HEAD
     * @param int $offset The violation offset.
     *
     * @return bool Whether the offset exists.
=======
     * @param int $offset The violation offset
     *
     * @return bool Whether the offset exists
>>>>>>> git-aline/master/master
     */
    public function has($offset);

    /**
     * Sets a violation at a given offset.
     *
<<<<<<< HEAD
     * @param int                          $offset    The violation offset.
     * @param ConstraintViolationInterface $violation The violation.
=======
     * @param int                          $offset    The violation offset
     * @param ConstraintViolationInterface $violation The violation
>>>>>>> git-aline/master/master
     */
    public function set($offset, ConstraintViolationInterface $violation);

    /**
     * Removes a violation at a given offset.
     *
<<<<<<< HEAD
     * @param int $offset The offset to remove.
=======
     * @param int $offset The offset to remove
>>>>>>> git-aline/master/master
     */
    public function remove($offset);
}
