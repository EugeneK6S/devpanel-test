<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Serializer\Mapping;

/**
 * Stores metadata needed for serializing and deserializing objects of specific class.
 *
<<<<<<< HEAD
 * Primarily, the metadata stores the list of attributes to serialize or deserialize.
=======
 * Primarily, the metadata stores the set of attributes to serialize or deserialize.
 *
 * There may only exist one metadata for each attribute according to its name.
 *
 * @internal
>>>>>>> git-aline/master/master
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
interface ClassMetadataInterface
{
    /**
     * Returns the name of the backing PHP class.
     *
<<<<<<< HEAD
     * @return string The name of the backing class.
=======
     * @return string The name of the backing class
>>>>>>> git-aline/master/master
     */
    public function getName();

    /**
     * Adds an {@link AttributeMetadataInterface}.
<<<<<<< HEAD
     *
     * @param AttributeMetadataInterface $attributeMetadata
=======
>>>>>>> git-aline/master/master
     */
    public function addAttributeMetadata(AttributeMetadataInterface $attributeMetadata);

    /**
     * Gets the list of {@link AttributeMetadataInterface}.
     *
     * @return AttributeMetadataInterface[]
     */
    public function getAttributesMetadata();

    /**
     * Merges a {@link ClassMetadataInterface} in the current one.
<<<<<<< HEAD
     *
     * @param ClassMetadataInterface $classMetadata
     */
    public function merge(ClassMetadataInterface $classMetadata);
=======
     */
    public function merge(self $classMetadata);
>>>>>>> git-aline/master/master

    /**
     * Returns a {@link \ReflectionClass} instance for this class.
     *
     * @return \ReflectionClass
     */
    public function getReflectionClass();
}
