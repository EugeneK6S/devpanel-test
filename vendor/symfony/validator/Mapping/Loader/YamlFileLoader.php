<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Validator\Mapping\Loader;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Parser as YamlParser;
<<<<<<< HEAD
=======
use Symfony\Component\Yaml\Yaml;
>>>>>>> git-aline/master/master

/**
 * Loads validation metadata from a YAML file.
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
class YamlFileLoader extends FileLoader
{
    /**
     * An array of YAML class descriptions.
     *
     * @var array
     */
    protected $classes = null;

    /**
     * Caches the used YAML parser.
     *
     * @var YamlParser
     */
    private $yamlParser;

    /**
     * {@inheritdoc}
     */
    public function loadClassMetadata(ClassMetadata $metadata)
    {
        if (null === $this->classes) {
<<<<<<< HEAD
            if (null === $this->yamlParser) {
                $this->yamlParser = new YamlParser();
            }

            // This method may throw an exception. Do not modify the class'
            // state before it completes
            if (false === ($classes = $this->parseFile($this->file))) {
                return false;
            }

            $this->classes = $classes;

            if (isset($this->classes['namespaces'])) {
                foreach ($this->classes['namespaces'] as $alias => $namespace) {
                    $this->addNamespaceAlias($alias, $namespace);
                }

                unset($this->classes['namespaces']);
            }
=======
            $this->loadClassesFromYaml();
>>>>>>> git-aline/master/master
        }

        if (isset($this->classes[$metadata->getClassName()])) {
            $classDescription = $this->classes[$metadata->getClassName()];

            $this->loadClassMetadataFromYaml($metadata, $classDescription);

            return true;
        }

        return false;
    }

    /**
<<<<<<< HEAD
=======
     * Return the names of the classes mapped in this file.
     *
     * @return string[] The classes names
     */
    public function getMappedClasses()
    {
        if (null === $this->classes) {
            $this->loadClassesFromYaml();
        }

        return array_keys($this->classes);
    }

    /**
>>>>>>> git-aline/master/master
     * Parses a collection of YAML nodes.
     *
     * @param array $nodes The YAML nodes
     *
     * @return array An array of values or Constraint instances
     */
    protected function parseNodes(array $nodes)
    {
        $values = array();

        foreach ($nodes as $name => $childNodes) {
<<<<<<< HEAD
            if (is_numeric($name) && is_array($childNodes) && 1 === count($childNodes)) {
                $options = current($childNodes);

                if (is_array($options)) {
=======
            if (is_numeric($name) && \is_array($childNodes) && 1 === \count($childNodes)) {
                $options = current($childNodes);

                if (\is_array($options)) {
>>>>>>> git-aline/master/master
                    $options = $this->parseNodes($options);
                }

                $values[] = $this->newConstraint(key($childNodes), $options);
            } else {
<<<<<<< HEAD
                if (is_array($childNodes)) {
=======
                if (\is_array($childNodes)) {
>>>>>>> git-aline/master/master
                    $childNodes = $this->parseNodes($childNodes);
                }

                $values[$name] = $childNodes;
            }
        }

        return $values;
    }

    /**
     * Loads the YAML class descriptions from the given file.
     *
     * @param string $path The path of the YAML file
     *
<<<<<<< HEAD
     * @return array|null The class descriptions or null, if the file was empty
=======
     * @return array The class descriptions
>>>>>>> git-aline/master/master
     *
     * @throws \InvalidArgumentException If the file could not be loaded or did
     *                                   not contain a YAML array
     */
    private function parseFile($path)
    {
<<<<<<< HEAD
        try {
            $classes = $this->yamlParser->parse(file_get_contents($path));
        } catch (ParseException $e) {
            throw new \InvalidArgumentException(sprintf('The file "%s" does not contain valid YAML.', $path), 0, $e);
=======
        $prevErrorHandler = set_error_handler(function ($level, $message, $script, $line) use ($path, &$prevErrorHandler) {
            $message = E_USER_DEPRECATED === $level ? preg_replace('/ on line \d+/', ' in "'.$path.'"$0', $message) : $message;

            return $prevErrorHandler ? $prevErrorHandler($level, $message, $script, $line) : false;
        });

        try {
            $classes = $this->yamlParser->parseFile($path, Yaml::PARSE_CONSTANT);
        } catch (ParseException $e) {
            throw new \InvalidArgumentException(sprintf('The file "%s" does not contain valid YAML.', $path), 0, $e);
        } finally {
            restore_error_handler();
>>>>>>> git-aline/master/master
        }

        // empty file
        if (null === $classes) {
<<<<<<< HEAD
            return;
        }

        // not an array
        if (!is_array($classes)) {
=======
            return array();
        }

        // not an array
        if (!\is_array($classes)) {
>>>>>>> git-aline/master/master
            throw new \InvalidArgumentException(sprintf('The file "%s" must contain a YAML array.', $this->file));
        }

        return $classes;
    }

<<<<<<< HEAD
    /**
     * Loads the validation metadata from the given YAML class description.
     *
     * @param ClassMetadata $metadata         The metadata to load
     * @param array         $classDescription The YAML class description
     */
=======
    private function loadClassesFromYaml()
    {
        if (null === $this->yamlParser) {
            $this->yamlParser = new YamlParser();
        }

        $this->classes = $this->parseFile($this->file);

        if (isset($this->classes['namespaces'])) {
            foreach ($this->classes['namespaces'] as $alias => $namespace) {
                $this->addNamespaceAlias($alias, $namespace);
            }

            unset($this->classes['namespaces']);
        }
    }

>>>>>>> git-aline/master/master
    private function loadClassMetadataFromYaml(ClassMetadata $metadata, array $classDescription)
    {
        if (isset($classDescription['group_sequence_provider'])) {
            $metadata->setGroupSequenceProvider(
                (bool) $classDescription['group_sequence_provider']
            );
        }

        if (isset($classDescription['group_sequence'])) {
            $metadata->setGroupSequence($classDescription['group_sequence']);
        }

<<<<<<< HEAD
        if (isset($classDescription['constraints']) && is_array($classDescription['constraints'])) {
=======
        if (isset($classDescription['constraints']) && \is_array($classDescription['constraints'])) {
>>>>>>> git-aline/master/master
            foreach ($this->parseNodes($classDescription['constraints']) as $constraint) {
                $metadata->addConstraint($constraint);
            }
        }

<<<<<<< HEAD
        if (isset($classDescription['properties']) && is_array($classDescription['properties'])) {
=======
        if (isset($classDescription['properties']) && \is_array($classDescription['properties'])) {
>>>>>>> git-aline/master/master
            foreach ($classDescription['properties'] as $property => $constraints) {
                if (null !== $constraints) {
                    foreach ($this->parseNodes($constraints) as $constraint) {
                        $metadata->addPropertyConstraint($property, $constraint);
                    }
                }
            }
        }

<<<<<<< HEAD
        if (isset($classDescription['getters']) && is_array($classDescription['getters'])) {
=======
        if (isset($classDescription['getters']) && \is_array($classDescription['getters'])) {
>>>>>>> git-aline/master/master
            foreach ($classDescription['getters'] as $getter => $constraints) {
                if (null !== $constraints) {
                    foreach ($this->parseNodes($constraints) as $constraint) {
                        $metadata->addGetterConstraint($getter, $constraint);
                    }
                }
            }
        }
    }
}
