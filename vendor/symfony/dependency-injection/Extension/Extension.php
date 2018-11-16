<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\DependencyInjection\Extension;

<<<<<<< HEAD
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\BadMethodCallException;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\Definition\ConfigurationInterface;
=======
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\BadMethodCallException;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
>>>>>>> git-aline/master/master

/**
 * Provides useful features shared by many extensions.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
abstract class Extension implements ExtensionInterface, ConfigurationExtensionInterface
{
<<<<<<< HEAD
    /**
     * Returns the base path for the XSD files.
     *
     * @return string The XSD base path
=======
    private $processedConfigs = array();

    /**
     * {@inheritdoc}
>>>>>>> git-aline/master/master
     */
    public function getXsdValidationBasePath()
    {
        return false;
    }

    /**
<<<<<<< HEAD
     * Returns the namespace to be used for this extension (XML namespace).
     *
     * @return string The XML namespace
=======
     * {@inheritdoc}
>>>>>>> git-aline/master/master
     */
    public function getNamespace()
    {
        return 'http://example.org/schema/dic/'.$this->getAlias();
    }

    /**
     * Returns the recommended alias to use in XML.
     *
     * This alias is also the mandatory prefix to use when using YAML.
     *
     * This convention is to remove the "Extension" postfix from the class
     * name and then lowercase and underscore the result. So:
     *
     *     AcmeHelloExtension
     *
     * becomes
     *
     *     acme_hello
     *
     * This can be overridden in a sub-class to specify the alias manually.
     *
     * @return string The alias
     *
     * @throws BadMethodCallException When the extension name does not follow conventions
     */
    public function getAlias()
    {
<<<<<<< HEAD
        $className = get_class($this);
        if (substr($className, -9) != 'Extension') {
=======
        $className = \get_class($this);
        if ('Extension' != substr($className, -9)) {
>>>>>>> git-aline/master/master
            throw new BadMethodCallException('This extension does not follow the naming convention; you must overwrite the getAlias() method.');
        }
        $classBaseName = substr(strrchr($className, '\\'), 1, -9);

        return Container::underscore($classBaseName);
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration(array $config, ContainerBuilder $container)
    {
<<<<<<< HEAD
        $reflected = new \ReflectionClass($this);
        $namespace = $reflected->getNamespaceName();

        $class = $namespace.'\\Configuration';
        if (class_exists($class)) {
            $r = new \ReflectionClass($class);
            $container->addResource(new FileResource($r->getFileName()));

            if (!method_exists($class, '__construct')) {
                $configuration = new $class();

                return $configuration;
            }
=======
        $class = \get_class($this);
        $class = substr_replace($class, '\Configuration', strrpos($class, '\\'));
        $class = $container->getReflectionClass($class);
        $constructor = $class ? $class->getConstructor() : null;

        if ($class && (!$constructor || !$constructor->getNumberOfRequiredParameters())) {
            return $class->newInstance();
>>>>>>> git-aline/master/master
        }
    }

    final protected function processConfiguration(ConfigurationInterface $configuration, array $configs)
    {
        $processor = new Processor();

<<<<<<< HEAD
        return $processor->processConfiguration($configuration, $configs);
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     *
=======
        return $this->processedConfigs[] = $processor->processConfiguration($configuration, $configs);
    }

    /**
     * @internal
     */
    final public function getProcessedConfigs()
    {
        try {
            return $this->processedConfigs;
        } finally {
            $this->processedConfigs = array();
        }
    }

    /**
>>>>>>> git-aline/master/master
     * @return bool Whether the configuration is enabled
     *
     * @throws InvalidArgumentException When the config is not enableable
     */
    protected function isConfigEnabled(ContainerBuilder $container, array $config)
    {
        if (!array_key_exists('enabled', $config)) {
            throw new InvalidArgumentException("The config array has no 'enabled' key.");
        }

        return (bool) $container->getParameterBag()->resolveValue($config['enabled']);
    }
}
