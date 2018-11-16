<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Validator\Mapping;

use Symfony\Component\Validator\Exception\ValidatorException;

/**
 * Stores all metadata needed for validating a class property.
 *
 * The value of the property is obtained by directly accessing the property.
 * The property will be accessed by reflection, so the access of private and
 * protected properties is supported.
 *
 * This class supports serialization and cloning.
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 *
 * @see PropertyMetadataInterface
 */
class PropertyMetadata extends MemberMetadata
{
    /**
<<<<<<< HEAD
     * Constructor.
     *
=======
>>>>>>> git-aline/master/master
     * @param string $class The class this property is defined on
     * @param string $name  The name of this property
     *
     * @throws ValidatorException
     */
    public function __construct($class, $name)
    {
        if (!property_exists($class, $name)) {
<<<<<<< HEAD
            throw new ValidatorException(sprintf('Property %s does not exist in class %s', $name, $class));
=======
            throw new ValidatorException(sprintf('Property "%s" does not exist in class "%s"', $name, $class));
>>>>>>> git-aline/master/master
        }

        parent::__construct($class, $name, $name);
    }

    /**
     * {@inheritdoc}
     */
    public function getPropertyValue($object)
    {
        return $this->getReflectionMember($object)->getValue($object);
    }

    /**
     * {@inheritdoc}
     */
    protected function newReflectionMember($objectOrClassName)
    {
<<<<<<< HEAD
        $class = new \ReflectionClass($objectOrClassName);
        while (!$class->hasProperty($this->getName())) {
            $class = $class->getParentClass();
        }

        $member = new \ReflectionProperty($class->getName(), $this->getName());
=======
        $originalClass = \is_string($objectOrClassName) ? $objectOrClassName : \get_class($objectOrClassName);

        while (!property_exists($objectOrClassName, $this->getName())) {
            $objectOrClassName = get_parent_class($objectOrClassName);

            if (false === $objectOrClassName) {
                throw new ValidatorException(sprintf('Property "%s" does not exist in class "%s".', $this->getName(), $originalClass));
            }
        }

        $member = new \ReflectionProperty($objectOrClassName, $this->getName());
>>>>>>> git-aline/master/master
        $member->setAccessible(true);

        return $member;
    }
}
