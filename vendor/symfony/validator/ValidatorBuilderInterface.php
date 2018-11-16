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

use Doctrine\Common\Annotations\Reader;
<<<<<<< HEAD
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Mapping\Cache\CacheInterface;
=======
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Mapping\Cache\CacheInterface;
use Symfony\Component\Validator\Mapping\Factory\MetadataFactoryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
>>>>>>> git-aline/master/master

/**
 * A configurable builder for ValidatorInterface objects.
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
interface ValidatorBuilderInterface
{
    /**
     * Adds an object initializer to the validator.
     *
<<<<<<< HEAD
     * @param ObjectInitializerInterface $initializer The initializer
     *
     * @return ValidatorBuilderInterface The builder object
=======
     * @return $this
>>>>>>> git-aline/master/master
     */
    public function addObjectInitializer(ObjectInitializerInterface $initializer);

    /**
     * Adds a list of object initializers to the validator.
     *
<<<<<<< HEAD
     * @param array $initializers The initializer
     *
     * @return ValidatorBuilderInterface The builder object
=======
     * @param ObjectInitializerInterface[] $initializers
     *
     * @return $this
>>>>>>> git-aline/master/master
     */
    public function addObjectInitializers(array $initializers);

    /**
     * Adds an XML constraint mapping file to the validator.
     *
     * @param string $path The path to the mapping file
     *
<<<<<<< HEAD
     * @return ValidatorBuilderInterface The builder object
=======
     * @return $this
>>>>>>> git-aline/master/master
     */
    public function addXmlMapping($path);

    /**
     * Adds a list of XML constraint mapping files to the validator.
     *
<<<<<<< HEAD
     * @param array $paths The paths to the mapping files
     *
     * @return ValidatorBuilderInterface The builder object
=======
     * @param string[] $paths The paths to the mapping files
     *
     * @return $this
>>>>>>> git-aline/master/master
     */
    public function addXmlMappings(array $paths);

    /**
     * Adds a YAML constraint mapping file to the validator.
     *
     * @param string $path The path to the mapping file
     *
<<<<<<< HEAD
     * @return ValidatorBuilderInterface The builder object
=======
     * @return $this
>>>>>>> git-aline/master/master
     */
    public function addYamlMapping($path);

    /**
     * Adds a list of YAML constraint mappings file to the validator.
     *
<<<<<<< HEAD
     * @param array $paths The paths to the mapping files
     *
     * @return ValidatorBuilderInterface The builder object
=======
     * @param string[] $paths The paths to the mapping files
     *
     * @return $this
>>>>>>> git-aline/master/master
     */
    public function addYamlMappings(array $paths);

    /**
     * Enables constraint mapping using the given static method.
     *
     * @param string $methodName The name of the method
     *
<<<<<<< HEAD
     * @return ValidatorBuilderInterface The builder object
=======
     * @return $this
>>>>>>> git-aline/master/master
     */
    public function addMethodMapping($methodName);

    /**
     * Enables constraint mapping using the given static methods.
     *
<<<<<<< HEAD
     * @param array $methodNames The names of the methods
     *
     * @return ValidatorBuilderInterface The builder object
=======
     * @param string[] $methodNames The names of the methods
     *
     * @return $this
>>>>>>> git-aline/master/master
     */
    public function addMethodMappings(array $methodNames);

    /**
     * Enables annotation based constraint mapping.
     *
<<<<<<< HEAD
     * @param Reader $annotationReader The annotation reader to be used
     *
     * @return ValidatorBuilderInterface The builder object
=======
     * @return $this
>>>>>>> git-aline/master/master
     */
    public function enableAnnotationMapping(Reader $annotationReader = null);

    /**
     * Disables annotation based constraint mapping.
     *
<<<<<<< HEAD
     * @return ValidatorBuilderInterface The builder object
=======
     * @return $this
>>>>>>> git-aline/master/master
     */
    public function disableAnnotationMapping();

    /**
     * Sets the class metadata factory used by the validator.
     *
<<<<<<< HEAD
     * @param MetadataFactoryInterface $metadataFactory The metadata factory
     *
     * @return ValidatorBuilderInterface The builder object
=======
     * @return $this
>>>>>>> git-aline/master/master
     */
    public function setMetadataFactory(MetadataFactoryInterface $metadataFactory);

    /**
     * Sets the cache for caching class metadata.
     *
<<<<<<< HEAD
     * @param CacheInterface $cache The cache instance
     *
     * @return ValidatorBuilderInterface The builder object
=======
     * @return $this
>>>>>>> git-aline/master/master
     */
    public function setMetadataCache(CacheInterface $cache);

    /**
     * Sets the constraint validator factory used by the validator.
     *
<<<<<<< HEAD
     * @param ConstraintValidatorFactoryInterface $validatorFactory The validator factory
     *
     * @return ValidatorBuilderInterface The builder object
=======
     * @return $this
>>>>>>> git-aline/master/master
     */
    public function setConstraintValidatorFactory(ConstraintValidatorFactoryInterface $validatorFactory);

    /**
     * Sets the translator used for translating violation messages.
     *
<<<<<<< HEAD
     * @param TranslatorInterface $translator The translator instance
     *
     * @return ValidatorBuilderInterface The builder object
=======
     * @return $this
>>>>>>> git-aline/master/master
     */
    public function setTranslator(TranslatorInterface $translator);

    /**
     * Sets the default translation domain of violation messages.
     *
     * The same message can have different translations in different domains.
     * Pass the domain that is used for violation messages by default to this
     * method.
     *
     * @param string $translationDomain The translation domain of the violation messages
     *
<<<<<<< HEAD
     * @return ValidatorBuilderInterface The builder object
=======
     * @return $this
>>>>>>> git-aline/master/master
     */
    public function setTranslationDomain($translationDomain);

    /**
<<<<<<< HEAD
     * Sets the property accessor for resolving property paths.
     *
     * @param PropertyAccessorInterface $propertyAccessor The property accessor
     *
     * @return ValidatorBuilderInterface The builder object
     *
     * @deprecated since version 2.5, to be removed in 3.0.
     */
    public function setPropertyAccessor(PropertyAccessorInterface $propertyAccessor);

    /**
     * Sets the API version that the returned validator should support.
     *
     * @param int $apiVersion The required API version
     *
     * @return ValidatorBuilderInterface The builder object
     *
     * @see Validation::API_VERSION_2_5
     * @see Validation::API_VERSION_2_5_BC
     * @deprecated since version 2.7, to be removed in 3.0.
     */
    public function setApiVersion($apiVersion);

    /**
     * Builds and returns a new validator object.
     *
     * @return ValidatorInterface The built validator.
=======
     * Builds and returns a new validator object.
     *
     * @return ValidatorInterface The built validator
>>>>>>> git-aline/master/master
     */
    public function getValidator();
}
