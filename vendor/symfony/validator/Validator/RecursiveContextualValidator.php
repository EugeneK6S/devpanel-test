<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Validator\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\GroupSequence;
use Symfony\Component\Validator\ConstraintValidatorFactoryInterface;
<<<<<<< HEAD
=======
use Symfony\Component\Validator\Context\ExecutionContext;
>>>>>>> git-aline/master/master
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\NoSuchMetadataException;
use Symfony\Component\Validator\Exception\RuntimeException;
use Symfony\Component\Validator\Exception\UnsupportedMetadataException;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Mapping\CascadingStrategy;
use Symfony\Component\Validator\Mapping\ClassMetadataInterface;
<<<<<<< HEAD
=======
use Symfony\Component\Validator\Mapping\Factory\MetadataFactoryInterface;
>>>>>>> git-aline/master/master
use Symfony\Component\Validator\Mapping\GenericMetadata;
use Symfony\Component\Validator\Mapping\MetadataInterface;
use Symfony\Component\Validator\Mapping\PropertyMetadataInterface;
use Symfony\Component\Validator\Mapping\TraversalStrategy;
<<<<<<< HEAD
use Symfony\Component\Validator\MetadataFactoryInterface;
=======
>>>>>>> git-aline/master/master
use Symfony\Component\Validator\ObjectInitializerInterface;
use Symfony\Component\Validator\Util\PropertyPath;

/**
 * Recursive implementation of {@link ContextualValidatorInterface}.
 *
<<<<<<< HEAD
 * @since  2.5
 *
=======
>>>>>>> git-aline/master/master
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
class RecursiveContextualValidator implements ContextualValidatorInterface
{
<<<<<<< HEAD
    /**
     * @var ExecutionContextInterface
     */
    private $context;

    /**
     * @var string
     */
    private $defaultPropertyPath;

    /**
     * @var array
     */
    private $defaultGroups;

    /**
     * @var MetadataFactoryInterface
     */
    private $metadataFactory;

    /**
     * @var ConstraintValidatorFactoryInterface
     */
    private $validatorFactory;

    /**
     * @var ObjectInitializerInterface[]
     */
=======
    private $context;
    private $defaultPropertyPath;
    private $defaultGroups;
    private $metadataFactory;
    private $validatorFactory;
>>>>>>> git-aline/master/master
    private $objectInitializers;

    /**
     * Creates a validator for the given context.
     *
     * @param ExecutionContextInterface           $context            The execution context
     * @param MetadataFactoryInterface            $metadataFactory    The factory for
     *                                                                fetching the metadata
     *                                                                of validated objects
     * @param ConstraintValidatorFactoryInterface $validatorFactory   The factory for creating
     *                                                                constraint validators
     * @param ObjectInitializerInterface[]        $objectInitializers The object initializers
     */
    public function __construct(ExecutionContextInterface $context, MetadataFactoryInterface $metadataFactory, ConstraintValidatorFactoryInterface $validatorFactory, array $objectInitializers = array())
    {
        $this->context = $context;
        $this->defaultPropertyPath = $context->getPropertyPath();
        $this->defaultGroups = array($context->getGroup() ?: Constraint::DEFAULT_GROUP);
        $this->metadataFactory = $metadataFactory;
        $this->validatorFactory = $validatorFactory;
        $this->objectInitializers = $objectInitializers;
    }

    /**
     * {@inheritdoc}
     */
    public function atPath($path)
    {
        $this->defaultPropertyPath = $this->context->getPropertyPath($path);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value, $constraints = null, $groups = null)
    {
        $groups = $groups ? $this->normalizeGroups($groups) : $this->defaultGroups;

        $previousValue = $this->context->getValue();
        $previousObject = $this->context->getObject();
        $previousMetadata = $this->context->getMetadata();
        $previousPath = $this->context->getPropertyPath();
        $previousGroup = $this->context->getGroup();
<<<<<<< HEAD
=======
        $previousConstraint = null;

        if ($this->context instanceof ExecutionContext || method_exists($this->context, 'getConstraint')) {
            $previousConstraint = $this->context->getConstraint();
        }
>>>>>>> git-aline/master/master

        // If explicit constraints are passed, validate the value against
        // those constraints
        if (null !== $constraints) {
            // You can pass a single constraint or an array of constraints
            // Make sure to deal with an array in the rest of the code
<<<<<<< HEAD
            if (!is_array($constraints)) {
=======
            if (!\is_array($constraints)) {
>>>>>>> git-aline/master/master
                $constraints = array($constraints);
            }

            $metadata = new GenericMetadata();
            $metadata->addConstraints($constraints);

            $this->validateGenericNode(
                $value,
<<<<<<< HEAD
                null,
                is_object($value) ? spl_object_hash($value) : null,
=======
                $previousObject,
                \is_object($value) ? spl_object_hash($value) : null,
>>>>>>> git-aline/master/master
                $metadata,
                $this->defaultPropertyPath,
                $groups,
                null,
                TraversalStrategy::IMPLICIT,
                $this->context
            );

            $this->context->setNode($previousValue, $previousObject, $previousMetadata, $previousPath);
            $this->context->setGroup($previousGroup);

<<<<<<< HEAD
=======
            if (null !== $previousConstraint) {
                $this->context->setConstraint($previousConstraint);
            }

>>>>>>> git-aline/master/master
            return $this;
        }

        // If an object is passed without explicit constraints, validate that
        // object against the constraints defined for the object's class
<<<<<<< HEAD
        if (is_object($value)) {
=======
        if (\is_object($value)) {
>>>>>>> git-aline/master/master
            $this->validateObject(
                $value,
                $this->defaultPropertyPath,
                $groups,
                TraversalStrategy::IMPLICIT,
                $this->context
            );

            $this->context->setNode($previousValue, $previousObject, $previousMetadata, $previousPath);
            $this->context->setGroup($previousGroup);

            return $this;
        }

        // If an array is passed without explicit constraints, validate each
        // object in the array
<<<<<<< HEAD
        if (is_array($value)) {
=======
        if (\is_array($value)) {
>>>>>>> git-aline/master/master
            $this->validateEachObjectIn(
                $value,
                $this->defaultPropertyPath,
                $groups,
<<<<<<< HEAD
                true,
=======
>>>>>>> git-aline/master/master
                $this->context
            );

            $this->context->setNode($previousValue, $previousObject, $previousMetadata, $previousPath);
            $this->context->setGroup($previousGroup);

            return $this;
        }

        throw new RuntimeException(sprintf(
            'Cannot validate values of type "%s" automatically. Please '.
            'provide a constraint.',
<<<<<<< HEAD
            gettype($value)
=======
            \gettype($value)
>>>>>>> git-aline/master/master
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function validateProperty($object, $propertyName, $groups = null)
    {
        $classMetadata = $this->metadataFactory->getMetadataFor($object);

        if (!$classMetadata instanceof ClassMetadataInterface) {
<<<<<<< HEAD
            // Cannot be UnsupportedMetadataException because of BC with
            // Symfony < 2.5
=======
>>>>>>> git-aline/master/master
            throw new ValidatorException(sprintf(
                'The metadata factory should return instances of '.
                '"\Symfony\Component\Validator\Mapping\ClassMetadataInterface", '.
                'got: "%s".',
<<<<<<< HEAD
                is_object($classMetadata) ? get_class($classMetadata) : gettype($classMetadata)
=======
                \is_object($classMetadata) ? \get_class($classMetadata) : \gettype($classMetadata)
>>>>>>> git-aline/master/master
            ));
        }

        $propertyMetadatas = $classMetadata->getPropertyMetadata($propertyName);
        $groups = $groups ? $this->normalizeGroups($groups) : $this->defaultGroups;
        $cacheKey = spl_object_hash($object);
        $propertyPath = PropertyPath::append($this->defaultPropertyPath, $propertyName);

        $previousValue = $this->context->getValue();
        $previousObject = $this->context->getObject();
        $previousMetadata = $this->context->getMetadata();
        $previousPath = $this->context->getPropertyPath();
        $previousGroup = $this->context->getGroup();

        foreach ($propertyMetadatas as $propertyMetadata) {
            $propertyValue = $propertyMetadata->getPropertyValue($object);

            $this->validateGenericNode(
                $propertyValue,
                $object,
<<<<<<< HEAD
                $cacheKey.':'.$propertyName,
=======
                $cacheKey.':'.\get_class($object).':'.$propertyName,
>>>>>>> git-aline/master/master
                $propertyMetadata,
                $propertyPath,
                $groups,
                null,
                TraversalStrategy::IMPLICIT,
                $this->context
            );
        }

        $this->context->setNode($previousValue, $previousObject, $previousMetadata, $previousPath);
        $this->context->setGroup($previousGroup);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function validatePropertyValue($objectOrClass, $propertyName, $value, $groups = null)
    {
        $classMetadata = $this->metadataFactory->getMetadataFor($objectOrClass);

        if (!$classMetadata instanceof ClassMetadataInterface) {
<<<<<<< HEAD
            // Cannot be UnsupportedMetadataException because of BC with
            // Symfony < 2.5
=======
>>>>>>> git-aline/master/master
            throw new ValidatorException(sprintf(
                'The metadata factory should return instances of '.
                '"\Symfony\Component\Validator\Mapping\ClassMetadataInterface", '.
                'got: "%s".',
<<<<<<< HEAD
                is_object($classMetadata) ? get_class($classMetadata) : gettype($classMetadata)
=======
                \is_object($classMetadata) ? \get_class($classMetadata) : \gettype($classMetadata)
>>>>>>> git-aline/master/master
            ));
        }

        $propertyMetadatas = $classMetadata->getPropertyMetadata($propertyName);
        $groups = $groups ? $this->normalizeGroups($groups) : $this->defaultGroups;

<<<<<<< HEAD
        if (is_object($objectOrClass)) {
            $object = $objectOrClass;
=======
        if (\is_object($objectOrClass)) {
            $object = $objectOrClass;
            $class = \get_class($object);
>>>>>>> git-aline/master/master
            $cacheKey = spl_object_hash($objectOrClass);
            $propertyPath = PropertyPath::append($this->defaultPropertyPath, $propertyName);
        } else {
            // $objectOrClass contains a class name
            $object = null;
<<<<<<< HEAD
=======
            $class = $objectOrClass;
>>>>>>> git-aline/master/master
            $cacheKey = null;
            $propertyPath = $this->defaultPropertyPath;
        }

        $previousValue = $this->context->getValue();
        $previousObject = $this->context->getObject();
        $previousMetadata = $this->context->getMetadata();
        $previousPath = $this->context->getPropertyPath();
        $previousGroup = $this->context->getGroup();

        foreach ($propertyMetadatas as $propertyMetadata) {
            $this->validateGenericNode(
                $value,
                $object,
<<<<<<< HEAD
                $cacheKey.':'.$propertyName,
=======
                $cacheKey.':'.$class.':'.$propertyName,
>>>>>>> git-aline/master/master
                $propertyMetadata,
                $propertyPath,
                $groups,
                null,
                TraversalStrategy::IMPLICIT,
                $this->context
            );
        }

        $this->context->setNode($previousValue, $previousObject, $previousMetadata, $previousPath);
        $this->context->setGroup($previousGroup);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getViolations()
    {
        return $this->context->getViolations();
    }

    /**
     * Normalizes the given group or list of groups to an array.
     *
     * @param mixed $groups The groups to normalize
     *
     * @return array A group array
     */
    protected function normalizeGroups($groups)
    {
<<<<<<< HEAD
        if (is_array($groups)) {
=======
        if (\is_array($groups)) {
>>>>>>> git-aline/master/master
            return $groups;
        }

        return array($groups);
    }
<<<<<<< HEAD
=======

>>>>>>> git-aline/master/master
    /**
     * Validates an object against the constraints defined for its class.
     *
     * If no metadata is available for the class, but the class is an instance
     * of {@link \Traversable} and the selected traversal strategy allows
     * traversal, the object will be iterated and each nested object will be
     * validated instead.
     *
     * @param object                    $object            The object to cascade
     * @param string                    $propertyPath      The current property path
     * @param string[]                  $groups            The validated groups
     * @param int                       $traversalStrategy The strategy for traversing the
     *                                                     cascaded object
     * @param ExecutionContextInterface $context           The current execution context
     *
     * @throws NoSuchMetadataException      If the object has no associated metadata
     *                                      and does not implement {@link \Traversable}
     *                                      or if traversal is disabled via the
     *                                      $traversalStrategy argument
     * @throws UnsupportedMetadataException If the metadata returned by the
     *                                      metadata factory does not implement
     *                                      {@link ClassMetadataInterface}
     */
    private function validateObject($object, $propertyPath, array $groups, $traversalStrategy, ExecutionContextInterface $context)
    {
        try {
            $classMetadata = $this->metadataFactory->getMetadataFor($object);

            if (!$classMetadata instanceof ClassMetadataInterface) {
                throw new UnsupportedMetadataException(sprintf(
                    'The metadata factory should return instances of '.
                    '"Symfony\Component\Validator\Mapping\ClassMetadataInterface", '.
                    'got: "%s".',
<<<<<<< HEAD
                    is_object($classMetadata) ? get_class($classMetadata) : gettype($classMetadata)
=======
                    \is_object($classMetadata) ? \get_class($classMetadata) : \gettype($classMetadata)
>>>>>>> git-aline/master/master
                ));
            }

            $this->validateClassNode(
                $object,
                spl_object_hash($object),
                $classMetadata,
                $propertyPath,
                $groups,
                null,
                $traversalStrategy,
                $context
            );
        } catch (NoSuchMetadataException $e) {
            // Rethrow if not Traversable
            if (!$object instanceof \Traversable) {
                throw $e;
            }

            // Rethrow unless IMPLICIT or TRAVERSE
            if (!($traversalStrategy & (TraversalStrategy::IMPLICIT | TraversalStrategy::TRAVERSE))) {
                throw $e;
            }

            $this->validateEachObjectIn(
                $object,
                $propertyPath,
                $groups,
<<<<<<< HEAD
                $traversalStrategy & TraversalStrategy::STOP_RECURSION,
=======
>>>>>>> git-aline/master/master
                $context
            );
        }
    }

    /**
     * Validates each object in a collection against the constraints defined
     * for their classes.
     *
     * If the parameter $recursive is set to true, nested {@link \Traversable}
     * objects are iterated as well. Nested arrays are always iterated,
     * regardless of the value of $recursive.
     *
<<<<<<< HEAD
     * @param array|\Traversable        $collection    The collection
     * @param string                    $propertyPath  The current property path
     * @param string[]                  $groups        The validated groups
     * @param bool                      $stopRecursion Whether to disable
     *                                                 recursive iteration. For
     *                                                 backwards compatibility
     *                                                 with Symfony < 2.5.
     * @param ExecutionContextInterface $context       The current execution context
=======
     * @param iterable                  $collection   The collection
     * @param string                    $propertyPath The current property path
     * @param string[]                  $groups       The validated groups
     * @param ExecutionContextInterface $context      The current execution context
>>>>>>> git-aline/master/master
     *
     * @see ClassNode
     * @see CollectionNode
     */
<<<<<<< HEAD
    private function validateEachObjectIn($collection, $propertyPath, array $groups, $stopRecursion, ExecutionContextInterface $context)
    {
        if ($stopRecursion) {
            $traversalStrategy = TraversalStrategy::NONE;
        } else {
            $traversalStrategy = TraversalStrategy::IMPLICIT;
        }

        foreach ($collection as $key => $value) {
            if (is_array($value)) {
                // Arrays are always cascaded, independent of the specified
                // traversal strategy
                // (BC with Symfony < 2.5)
=======
    private function validateEachObjectIn($collection, $propertyPath, array $groups, ExecutionContextInterface $context)
    {
        foreach ($collection as $key => $value) {
            if (\is_array($value)) {
                // Arrays are always cascaded, independent of the specified
                // traversal strategy
>>>>>>> git-aline/master/master
                $this->validateEachObjectIn(
                    $value,
                    $propertyPath.'['.$key.']',
                    $groups,
<<<<<<< HEAD
                    $stopRecursion,
=======
>>>>>>> git-aline/master/master
                    $context
                );

                continue;
            }

            // Scalar and null values in the collection are ignored
<<<<<<< HEAD
            // (BC with Symfony < 2.5)
            if (is_object($value)) {
=======
            if (\is_object($value)) {
>>>>>>> git-aline/master/master
                $this->validateObject(
                    $value,
                    $propertyPath.'['.$key.']',
                    $groups,
<<<<<<< HEAD
                    $traversalStrategy,
=======
                    TraversalStrategy::IMPLICIT,
>>>>>>> git-aline/master/master
                    $context
                );
            }
        }
    }

    /**
     * Validates a class node.
     *
     * A class node is a combination of an object with a {@link ClassMetadataInterface}
     * instance. Each class node (conceptionally) has zero or more succeeding
     * property nodes:
     *
     *     (Article:class node)
     *                \
     *        ($title:property node)
     *
     * This method validates the passed objects against all constraints defined
     * at class level. It furthermore triggers the validation of each of the
     * class' properties against the constraints for that property.
     *
     * If the selected traversal strategy allows traversal, the object is
     * iterated and each nested object is validated against its own constraints.
     * The object is not traversed if traversal is disabled in the class
     * metadata.
     *
     * If the passed groups contain the group "Default", the validator will
     * check whether the "Default" group has been replaced by a group sequence
     * in the class metadata. If this is the case, the group sequence is
     * validated instead.
     *
     * @param object                    $object            The validated object
     * @param string                    $cacheKey          The key for caching
     *                                                     the validated object
     * @param ClassMetadataInterface    $metadata          The class metadata of
     *                                                     the object
     * @param string                    $propertyPath      The property path leading
     *                                                     to the object
     * @param string[]                  $groups            The groups in which the
     *                                                     object should be validated
     * @param string[]|null             $cascadedGroups    The groups in which
     *                                                     cascaded objects should
     *                                                     be validated
     * @param int                       $traversalStrategy The strategy used for
     *                                                     traversing the object
     * @param ExecutionContextInterface $context           The current execution context
     *
     * @throws UnsupportedMetadataException  If a property metadata does not
     *                                       implement {@link PropertyMetadataInterface}
     * @throws ConstraintDefinitionException If traversal was enabled but the
     *                                       object does not implement
     *                                       {@link \Traversable}
     *
     * @see TraversalStrategy
     */
    private function validateClassNode($object, $cacheKey, ClassMetadataInterface $metadata = null, $propertyPath, array $groups, $cascadedGroups, $traversalStrategy, ExecutionContextInterface $context)
    {
        $context->setNode($object, $object, $metadata, $propertyPath);

        if (!$context->isObjectInitialized($cacheKey)) {
            foreach ($this->objectInitializers as $initializer) {
                $initializer->initialize($object);
            }

            $context->markObjectAsInitialized($cacheKey);
        }

        foreach ($groups as $key => $group) {
            // If the "Default" group is replaced by a group sequence, remember
            // to cascade the "Default" group when traversing the group
            // sequence
            $defaultOverridden = false;

            // Use the object hash for group sequences
<<<<<<< HEAD
            $groupHash = is_object($group) ? spl_object_hash($group) : $group;
=======
            $groupHash = \is_object($group) ? spl_object_hash($group) : $group;
>>>>>>> git-aline/master/master

            if ($context->isGroupValidated($cacheKey, $groupHash)) {
                // Skip this group when validating the properties and when
                // traversing the object
                unset($groups[$key]);

                continue;
            }

            $context->markGroupAsValidated($cacheKey, $groupHash);

            // Replace the "Default" group by the group sequence defined
            // for the class, if applicable.
            // This is done after checking the cache, so that
            // spl_object_hash() isn't called for this sequence and
            // "Default" is used instead in the cache. This is useful
            // if the getters below return different group sequences in
            // every call.
            if (Constraint::DEFAULT_GROUP === $group) {
                if ($metadata->hasGroupSequence()) {
                    // The group sequence is statically defined for the class
                    $group = $metadata->getGroupSequence();
                    $defaultOverridden = true;
                } elseif ($metadata->isGroupSequenceProvider()) {
                    // The group sequence is dynamically obtained from the validated
                    // object
                    /* @var \Symfony\Component\Validator\GroupSequenceProviderInterface $object */
                    $group = $object->getGroupSequence();
                    $defaultOverridden = true;

                    if (!$group instanceof GroupSequence) {
                        $group = new GroupSequence($group);
                    }
                }
            }

            // If the groups (=[<G1,G2>,G3,G4]) contain a group sequence
            // (=<G1,G2>), then call validateClassNode() with each entry of the
            // group sequence and abort if necessary (G1, G2)
            if ($group instanceof GroupSequence) {
                $this->stepThroughGroupSequence(
                     $object,
                     $object,
                     $cacheKey,
                     $metadata,
                     $propertyPath,
                     $traversalStrategy,
                     $group,
                     $defaultOverridden ? Constraint::DEFAULT_GROUP : null,
                     $context
                );

                // Skip the group sequence when validating properties, because
                // stepThroughGroupSequence() already validates the properties
                unset($groups[$key]);

                continue;
            }

            $this->validateInGroup($object, $cacheKey, $metadata, $group, $context);
        }

        // If no more groups should be validated for the property nodes,
        // we can safely quit
<<<<<<< HEAD
        if (0 === count($groups)) {
=======
        if (0 === \count($groups)) {
>>>>>>> git-aline/master/master
            return;
        }

        // Validate all properties against their constraints
        foreach ($metadata->getConstrainedProperties() as $propertyName) {
            // If constraints are defined both on the getter of a property as
            // well as on the property itself, then getPropertyMetadata()
            // returns two metadata objects, not just one
            foreach ($metadata->getPropertyMetadata($propertyName) as $propertyMetadata) {
                if (!$propertyMetadata instanceof PropertyMetadataInterface) {
                    throw new UnsupportedMetadataException(sprintf(
                        'The property metadata instances should implement '.
                        '"Symfony\Component\Validator\Mapping\PropertyMetadataInterface", '.
                        'got: "%s".',
<<<<<<< HEAD
                        is_object($propertyMetadata) ? get_class($propertyMetadata) : gettype($propertyMetadata)
=======
                        \is_object($propertyMetadata) ? \get_class($propertyMetadata) : \gettype($propertyMetadata)
>>>>>>> git-aline/master/master
                    ));
                }

                $propertyValue = $propertyMetadata->getPropertyValue($object);

                $this->validateGenericNode(
                    $propertyValue,
                    $object,
<<<<<<< HEAD
                    $cacheKey.':'.$propertyName,
=======
                    $cacheKey.':'.\get_class($object).':'.$propertyName,
>>>>>>> git-aline/master/master
                    $propertyMetadata,
                    PropertyPath::append($propertyPath, $propertyName),
                    $groups,
                    $cascadedGroups,
                    TraversalStrategy::IMPLICIT,
                    $context
                );
            }
        }

        // If no specific traversal strategy was requested when this method
        // was called, use the traversal strategy of the class' metadata
        if ($traversalStrategy & TraversalStrategy::IMPLICIT) {
<<<<<<< HEAD
            // Keep the STOP_RECURSION flag, if it was set
            $traversalStrategy = $metadata->getTraversalStrategy()
                | ($traversalStrategy & TraversalStrategy::STOP_RECURSION);
=======
            $traversalStrategy = $metadata->getTraversalStrategy();
>>>>>>> git-aline/master/master
        }

        // Traverse only if IMPLICIT or TRAVERSE
        if (!($traversalStrategy & (TraversalStrategy::IMPLICIT | TraversalStrategy::TRAVERSE))) {
            return;
        }

        // If IMPLICIT, stop unless we deal with a Traversable
        if ($traversalStrategy & TraversalStrategy::IMPLICIT && !$object instanceof \Traversable) {
            return;
        }

        // If TRAVERSE, fail if we have no Traversable
        if (!$object instanceof \Traversable) {
<<<<<<< HEAD
            // Must throw a ConstraintDefinitionException for backwards
            // compatibility reasons with Symfony < 2.5
            throw new ConstraintDefinitionException(sprintf(
                'Traversal was enabled for "%s", but this class '.
                'does not implement "\Traversable".',
                get_class($object)
=======
            throw new ConstraintDefinitionException(sprintf(
                'Traversal was enabled for "%s", but this class '.
                'does not implement "\Traversable".',
                \get_class($object)
>>>>>>> git-aline/master/master
            ));
        }

        $this->validateEachObjectIn(
            $object,
            $propertyPath,
            $groups,
<<<<<<< HEAD
            $traversalStrategy & TraversalStrategy::STOP_RECURSION,
=======
>>>>>>> git-aline/master/master
            $context
        );
    }

    /**
     * Validates a node that is not a class node.
     *
     * Currently, two such node types exist:
     *
     *  - property nodes, which consist of the value of an object's
     *    property together with a {@link PropertyMetadataInterface} instance
     *  - generic nodes, which consist of a value and some arbitrary
     *    constraints defined in a {@link MetadataInterface} container
     *
     * In both cases, the value is validated against all constraints defined
     * in the passed metadata object. Then, if the value is an instance of
     * {@link \Traversable} and the selected traversal strategy permits it,
     * the value is traversed and each nested object validated against its own
     * constraints. Arrays are always traversed.
     *
     * @param mixed                     $value             The validated value
     * @param object|null               $object            The current object
     * @param string                    $cacheKey          The key for caching
     *                                                     the validated value
     * @param MetadataInterface         $metadata          The metadata of the
     *                                                     value
     * @param string                    $propertyPath      The property path leading
     *                                                     to the value
     * @param string[]                  $groups            The groups in which the
     *                                                     value should be validated
     * @param string[]|null             $cascadedGroups    The groups in which
     *                                                     cascaded objects should
     *                                                     be validated
     * @param int                       $traversalStrategy The strategy used for
     *                                                     traversing the value
     * @param ExecutionContextInterface $context           The current execution context
     *
     * @see TraversalStrategy
     */
    private function validateGenericNode($value, $object, $cacheKey, MetadataInterface $metadata = null, $propertyPath, array $groups, $cascadedGroups, $traversalStrategy, ExecutionContextInterface $context)
    {
        $context->setNode($value, $object, $metadata, $propertyPath);

        foreach ($groups as $key => $group) {
            if ($group instanceof GroupSequence) {
                $this->stepThroughGroupSequence(
                     $value,
                     $object,
                     $cacheKey,
                     $metadata,
                     $propertyPath,
                     $traversalStrategy,
                     $group,
                     null,
                     $context
                );

                // Skip the group sequence when cascading, as the cascading
                // logic is already done in stepThroughGroupSequence()
                unset($groups[$key]);

                continue;
            }

            $this->validateInGroup($value, $cacheKey, $metadata, $group, $context);
        }

<<<<<<< HEAD
        if (0 === count($groups)) {
=======
        if (0 === \count($groups)) {
>>>>>>> git-aline/master/master
            return;
        }

        if (null === $value) {
            return;
        }

        $cascadingStrategy = $metadata->getCascadingStrategy();

        // Quit unless we have an array or a cascaded object
<<<<<<< HEAD
        if (!is_array($value) && !($cascadingStrategy & CascadingStrategy::CASCADE)) {
=======
        if (!\is_array($value) && !($cascadingStrategy & CascadingStrategy::CASCADE)) {
>>>>>>> git-aline/master/master
            return;
        }

        // If no specific traversal strategy was requested when this method
        // was called, use the traversal strategy of the node's metadata
        if ($traversalStrategy & TraversalStrategy::IMPLICIT) {
<<<<<<< HEAD
            // Keep the STOP_RECURSION flag, if it was set
            $traversalStrategy = $metadata->getTraversalStrategy()
                | ($traversalStrategy & TraversalStrategy::STOP_RECURSION);
=======
            $traversalStrategy = $metadata->getTraversalStrategy();
>>>>>>> git-aline/master/master
        }

        // The $cascadedGroups property is set, if the "Default" group is
        // overridden by a group sequence
        // See validateClassNode()
<<<<<<< HEAD
        $cascadedGroups = count($cascadedGroups) > 0
            ? $cascadedGroups
            : $groups;

        if (is_array($value)) {
            // Arrays are always traversed, independent of the specified
            // traversal strategy
            // (BC with Symfony < 2.5)
=======
        $cascadedGroups = null !== $cascadedGroups && \count($cascadedGroups) > 0 ? $cascadedGroups : $groups;

        if (\is_array($value)) {
            // Arrays are always traversed, independent of the specified
            // traversal strategy
>>>>>>> git-aline/master/master
            $this->validateEachObjectIn(
                $value,
                $propertyPath,
                $cascadedGroups,
<<<<<<< HEAD
                $traversalStrategy & TraversalStrategy::STOP_RECURSION,
=======
>>>>>>> git-aline/master/master
                $context
            );

            return;
        }

        // If the value is a scalar, pass it anyway, because we want
        // a NoSuchMetadataException to be thrown in that case
<<<<<<< HEAD
        // (BC with Symfony < 2.5)
=======
>>>>>>> git-aline/master/master
        $this->validateObject(
            $value,
            $propertyPath,
            $cascadedGroups,
            $traversalStrategy,
            $context
        );

        // Currently, the traversal strategy can only be TRAVERSE for a
        // generic node if the cascading strategy is CASCADE. Thus, traversable
        // objects will always be handled within validateObject() and there's
        // nothing more to do here.

        // see GenericMetadata::addConstraint()
    }

    /**
     * Sequentially validates a node's value in each group of a group sequence.
     *
     * If any of the constraints generates a violation, subsequent groups in the
     * group sequence are skipped.
     *
     * @param mixed                     $value             The validated value
     * @param object|null               $object            The current object
     * @param string                    $cacheKey          The key for caching
     *                                                     the validated value
     * @param MetadataInterface         $metadata          The metadata of the
     *                                                     value
     * @param string                    $propertyPath      The property path leading
     *                                                     to the value
     * @param int                       $traversalStrategy The strategy used for
     *                                                     traversing the value
     * @param GroupSequence             $groupSequence     The group sequence
<<<<<<< HEAD
     * @param string[]|null             $cascadedGroup     The group that should
=======
     * @param string|null               $cascadedGroup     The group that should
>>>>>>> git-aline/master/master
     *                                                     be passed to cascaded
     *                                                     objects instead of
     *                                                     the group sequence
     * @param ExecutionContextInterface $context           The execution context
     */
    private function stepThroughGroupSequence($value, $object, $cacheKey, MetadataInterface $metadata = null, $propertyPath, $traversalStrategy, GroupSequence $groupSequence, $cascadedGroup, ExecutionContextInterface $context)
    {
<<<<<<< HEAD
        $violationCount = count($context->getViolations());
        $cascadedGroups = $cascadedGroup ? array($cascadedGroup) : null;

        foreach ($groupSequence->groups as $groupInSequence) {
            $groups = array($groupInSequence);
=======
        $violationCount = \count($context->getViolations());
        $cascadedGroups = $cascadedGroup ? array($cascadedGroup) : null;

        foreach ($groupSequence->groups as $groupInSequence) {
            $groups = (array) $groupInSequence;
>>>>>>> git-aline/master/master

            if ($metadata instanceof ClassMetadataInterface) {
                $this->validateClassNode(
                     $value,
                     $cacheKey,
                     $metadata,
                     $propertyPath,
                     $groups,
                     $cascadedGroups,
                     $traversalStrategy,
                     $context
                );
            } else {
                $this->validateGenericNode(
                     $value,
                     $object,
                     $cacheKey,
                     $metadata,
                     $propertyPath,
                     $groups,
                     $cascadedGroups,
                     $traversalStrategy,
                     $context
                );
            }

            // Abort sequence validation if a violation was generated
<<<<<<< HEAD
            if (count($context->getViolations()) > $violationCount) {
=======
            if (\count($context->getViolations()) > $violationCount) {
>>>>>>> git-aline/master/master
                break;
            }
        }
    }

    /**
     * Validates a node's value against all constraints in the given group.
     *
     * @param mixed                     $value    The validated value
     * @param string                    $cacheKey The key for caching the
     *                                            validated value
     * @param MetadataInterface         $metadata The metadata of the value
     * @param string                    $group    The group to validate
     * @param ExecutionContextInterface $context  The execution context
     */
    private function validateInGroup($value, $cacheKey, MetadataInterface $metadata, $group, ExecutionContextInterface $context)
    {
        $context->setGroup($group);

        foreach ($metadata->findConstraints($group) as $constraint) {
            // Prevent duplicate validation of constraints, in the case
            // that constraints belong to multiple validated groups
            if (null !== $cacheKey) {
                $constraintHash = spl_object_hash($constraint);

                if ($context->isConstraintValidated($cacheKey, $constraintHash)) {
                    continue;
                }

                $context->markConstraintAsValidated($cacheKey, $constraintHash);
            }

            $context->setConstraint($constraint);

            $validator = $this->validatorFactory->getInstance($constraint);
            $validator->initialize($context);
            $validator->validate($value, $constraint);
        }
    }
}
