<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\DependencyInjection\Loader;

<<<<<<< HEAD
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Config\Util\XmlUtils;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
=======
use Symfony\Component\Config\Util\XmlUtils;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\Argument\BoundArgument;
use Symfony\Component\DependencyInjection\Argument\IteratorArgument;
use Symfony\Component\DependencyInjection\Argument\TaggedIteratorArgument;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\Reference;
>>>>>>> git-aline/master/master
use Symfony\Component\ExpressionLanguage\Expression;

/**
 * XmlFileLoader loads XML files service definitions.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class XmlFileLoader extends FileLoader
{
    const NS = 'http://symfony.com/schema/dic/services';

    /**
     * {@inheritdoc}
     */
    public function load($resource, $type = null)
    {
        $path = $this->locator->locate($resource);

        $xml = $this->parseFileToDOM($path);

<<<<<<< HEAD
        $this->container->addResource(new FileResource($path));

        // anonymous services
        $this->processAnonymousServices($xml, $path);
=======
        $this->container->fileExists($path);

        $defaults = $this->getServiceDefaults($xml, $path);

        // anonymous services
        $this->processAnonymousServices($xml, $path, $defaults);
>>>>>>> git-aline/master/master

        // imports
        $this->parseImports($xml, $path);

        // parameters
<<<<<<< HEAD
        $this->parseParameters($xml);
=======
        $this->parseParameters($xml, $path);
>>>>>>> git-aline/master/master

        // extensions
        $this->loadFromExtensions($xml);

        // services
<<<<<<< HEAD
        $this->parseDefinitions($xml, $path);
=======
        try {
            $this->parseDefinitions($xml, $path, $defaults);
        } finally {
            $this->instanceof = array();
        }
>>>>>>> git-aline/master/master
    }

    /**
     * {@inheritdoc}
     */
    public function supports($resource, $type = null)
    {
<<<<<<< HEAD
        return is_string($resource) && 'xml' === pathinfo($resource, PATHINFO_EXTENSION);
=======
        if (!\is_string($resource)) {
            return false;
        }

        if (null === $type && 'xml' === pathinfo($resource, PATHINFO_EXTENSION)) {
            return true;
        }

        return 'xml' === $type;
>>>>>>> git-aline/master/master
    }

    /**
     * Parses parameters.
     *
     * @param \DOMDocument $xml
<<<<<<< HEAD
     */
    private function parseParameters(\DOMDocument $xml)
    {
        if ($parameters = $this->getChildren($xml->documentElement, 'parameters')) {
            $this->container->getParameterBag()->add($this->getArgumentsAsPhp($parameters[0], 'parameter'));
=======
     * @param string       $file
     */
    private function parseParameters(\DOMDocument $xml, $file)
    {
        if ($parameters = $this->getChildren($xml->documentElement, 'parameters')) {
            $this->container->getParameterBag()->add($this->getArgumentsAsPhp($parameters[0], 'parameter', $file));
>>>>>>> git-aline/master/master
        }
    }

    /**
     * Parses imports.
     *
     * @param \DOMDocument $xml
     * @param string       $file
     */
    private function parseImports(\DOMDocument $xml, $file)
    {
        $xpath = new \DOMXPath($xml);
        $xpath->registerNamespace('container', self::NS);

        if (false === $imports = $xpath->query('//container:imports/container:import')) {
            return;
        }

<<<<<<< HEAD
        foreach ($imports as $import) {
            $this->setCurrentDir(dirname($file));
            $this->import($import->getAttribute('resource'), null, (bool) XmlUtils::phpize($import->getAttribute('ignore-errors')), $file);
=======
        $defaultDirectory = \dirname($file);
        foreach ($imports as $import) {
            $this->setCurrentDir($defaultDirectory);
            $this->import($import->getAttribute('resource'), XmlUtils::phpize($import->getAttribute('type')) ?: null, (bool) XmlUtils::phpize($import->getAttribute('ignore-errors')), $file);
>>>>>>> git-aline/master/master
        }
    }

    /**
     * Parses multiple definitions.
     *
     * @param \DOMDocument $xml
     * @param string       $file
     */
<<<<<<< HEAD
    private function parseDefinitions(\DOMDocument $xml, $file)
=======
    private function parseDefinitions(\DOMDocument $xml, $file, $defaults)
>>>>>>> git-aline/master/master
    {
        $xpath = new \DOMXPath($xml);
        $xpath->registerNamespace('container', self::NS);

<<<<<<< HEAD
        if (false === $services = $xpath->query('//container:services/container:service')) {
            return;
        }

        foreach ($services as $service) {
            if (null !== $definition = $this->parseDefinition($service, $file)) {
                $this->container->setDefinition((string) $service->getAttribute('id'), $definition);
            }
        }
=======
        if (false === $services = $xpath->query('//container:services/container:service|//container:services/container:prototype')) {
            return;
        }
        $this->setCurrentDir(\dirname($file));

        $this->instanceof = array();
        $this->isLoadingInstanceof = true;
        $instanceof = $xpath->query('//container:services/container:instanceof');
        foreach ($instanceof as $service) {
            $this->setDefinition((string) $service->getAttribute('id'), $this->parseDefinition($service, $file, array()));
        }

        $this->isLoadingInstanceof = false;
        foreach ($services as $service) {
            if (null !== $definition = $this->parseDefinition($service, $file, $defaults)) {
                if ('prototype' === $service->tagName) {
                    $this->registerClasses($definition, (string) $service->getAttribute('namespace'), (string) $service->getAttribute('resource'), (string) $service->getAttribute('exclude'));
                } else {
                    $this->setDefinition((string) $service->getAttribute('id'), $definition);
                }
            }
        }
    }

    /**
     * Get service defaults.
     *
     * @return array
     */
    private function getServiceDefaults(\DOMDocument $xml, $file)
    {
        $xpath = new \DOMXPath($xml);
        $xpath->registerNamespace('container', self::NS);

        if (null === $defaultsNode = $xpath->query('//container:services/container:defaults')->item(0)) {
            return array();
        }
        $defaults = array(
            'tags' => $this->getChildren($defaultsNode, 'tag'),
            'bind' => array_map(function ($v) { return new BoundArgument($v); }, $this->getArgumentsAsPhp($defaultsNode, 'bind', $file)),
        );

        foreach ($defaults['tags'] as $tag) {
            if ('' === $tag->getAttribute('name')) {
                throw new InvalidArgumentException(sprintf('The tag name for tag "<defaults>" in %s must be a non-empty string.', $file));
            }
        }

        if ($defaultsNode->hasAttribute('autowire')) {
            $defaults['autowire'] = XmlUtils::phpize($defaultsNode->getAttribute('autowire'));
        }
        if ($defaultsNode->hasAttribute('public')) {
            $defaults['public'] = XmlUtils::phpize($defaultsNode->getAttribute('public'));
        }
        if ($defaultsNode->hasAttribute('autoconfigure')) {
            $defaults['autoconfigure'] = XmlUtils::phpize($defaultsNode->getAttribute('autoconfigure'));
        }

        return $defaults;
>>>>>>> git-aline/master/master
    }

    /**
     * Parses an individual Definition.
     *
     * @param \DOMElement $service
     * @param string      $file
<<<<<<< HEAD
     *
     * @return Definition|null
     */
    private function parseDefinition(\DOMElement $service, $file)
    {
        if ($alias = $service->getAttribute('alias')) {
            $public = true;
            if ($publicAttr = $service->getAttribute('public')) {
                $public = XmlUtils::phpize($publicAttr);
            }
            $this->container->setAlias((string) $service->getAttribute('id'), new Alias($alias, $public));
=======
     * @param array       $defaults
     *
     * @return Definition|null
     */
    private function parseDefinition(\DOMElement $service, $file, array $defaults)
    {
        if ($alias = $service->getAttribute('alias')) {
            $this->validateAlias($service, $file);

            $this->container->setAlias((string) $service->getAttribute('id'), $alias = new Alias($alias));
            if ($publicAttr = $service->getAttribute('public')) {
                $alias->setPublic(XmlUtils::phpize($publicAttr));
            } elseif (isset($defaults['public'])) {
                $alias->setPublic($defaults['public']);
            }
>>>>>>> git-aline/master/master

            return;
        }

<<<<<<< HEAD
        if ($parent = $service->getAttribute('parent')) {
            $definition = new DefinitionDecorator($parent);
        } else {
            $definition = new Definition();
        }

        foreach (array('class', 'scope', 'public', 'factory-class', 'factory-method', 'factory-service', 'synthetic', 'lazy', 'abstract') as $key) {
            if ($value = $service->getAttribute($key)) {
                if (in_array($key, array('factory-class', 'factory-method', 'factory-service'))) {
                    @trigger_error(sprintf('The "%s" attribute of service "%s" in file "%s" is deprecated since version 2.6 and will be removed in 3.0. Use the "factory" element instead.', $key, (string) $service->getAttribute('id'), $file), E_USER_DEPRECATED);
                }
                $method = 'set'.str_replace('-', '', $key);
=======
        if ($this->isLoadingInstanceof) {
            $definition = new ChildDefinition('');
        } elseif ($parent = $service->getAttribute('parent')) {
            if (!empty($this->instanceof)) {
                throw new InvalidArgumentException(sprintf('The service "%s" cannot use the "parent" option in the same file where "instanceof" configuration is defined as using both is not supported. Move your child definitions to a separate file.', $service->getAttribute('id')));
            }

            foreach ($defaults as $k => $v) {
                if ('tags' === $k) {
                    // since tags are never inherited from parents, there is no confusion
                    // thus we can safely add them as defaults to ChildDefinition
                    continue;
                }
                if ('bind' === $k) {
                    if ($defaults['bind']) {
                        throw new InvalidArgumentException(sprintf('Bound values on service "%s" cannot be inherited from "defaults" when a "parent" is set. Move your child definitions to a separate file.', $service->getAttribute('id')));
                    }

                    continue;
                }
                if (!$service->hasAttribute($k)) {
                    throw new InvalidArgumentException(sprintf('Attribute "%s" on service "%s" cannot be inherited from "defaults" when a "parent" is set. Move your child definitions to a separate file or define this attribute explicitly.', $k, $service->getAttribute('id')));
                }
            }

            $definition = new ChildDefinition($parent);
        } else {
            $definition = new Definition();

            if (isset($defaults['public'])) {
                $definition->setPublic($defaults['public']);
            }
            if (isset($defaults['autowire'])) {
                $definition->setAutowired($defaults['autowire']);
            }
            if (isset($defaults['autoconfigure'])) {
                $definition->setAutoconfigured($defaults['autoconfigure']);
            }

            $definition->setChanges(array());
        }

        foreach (array('class', 'public', 'shared', 'synthetic', 'lazy', 'abstract') as $key) {
            if ($value = $service->getAttribute($key)) {
                $method = 'set'.$key;
>>>>>>> git-aline/master/master
                $definition->$method(XmlUtils::phpize($value));
            }
        }

<<<<<<< HEAD
        if ($value = $service->getAttribute('synchronized')) {
            $triggerDeprecation = 'request' !== (string) $service->getAttribute('id');

            if ($triggerDeprecation) {
                @trigger_error(sprintf('The "synchronized" attribute of service "%s" in file "%s" is deprecated since version 2.7 and will be removed in 3.0.', (string) $service->getAttribute('id'), $file), E_USER_DEPRECATED);
            }

            $definition->setSynchronized(XmlUtils::phpize($value), $triggerDeprecation);
=======
        if ($value = $service->getAttribute('autowire')) {
            $definition->setAutowired(XmlUtils::phpize($value));
        }

        if ($value = $service->getAttribute('autoconfigure')) {
            if (!$definition instanceof ChildDefinition) {
                $definition->setAutoconfigured(XmlUtils::phpize($value));
            } elseif ($value = XmlUtils::phpize($value)) {
                throw new InvalidArgumentException(sprintf('The service "%s" cannot have a "parent" and also have "autoconfigure". Try setting autoconfigure="false" for the service.', $service->getAttribute('id')));
            }
>>>>>>> git-aline/master/master
        }

        if ($files = $this->getChildren($service, 'file')) {
            $definition->setFile($files[0]->nodeValue);
        }

<<<<<<< HEAD
        $definition->setArguments($this->getArgumentsAsPhp($service, 'argument'));
        $definition->setProperties($this->getArgumentsAsPhp($service, 'property'));
=======
        if ($deprecated = $this->getChildren($service, 'deprecated')) {
            $definition->setDeprecated(true, $deprecated[0]->nodeValue ?: null);
        }

        $definition->setArguments($this->getArgumentsAsPhp($service, 'argument', $file, false, $definition instanceof ChildDefinition));
        $definition->setProperties($this->getArgumentsAsPhp($service, 'property', $file));
>>>>>>> git-aline/master/master

        if ($factories = $this->getChildren($service, 'factory')) {
            $factory = $factories[0];
            if ($function = $factory->getAttribute('function')) {
                $definition->setFactory($function);
            } else {
<<<<<<< HEAD
                $factoryService = $this->getChildren($factory, 'service');

                if (isset($factoryService[0])) {
                    $class = $this->parseDefinition($factoryService[0], $file);
                } elseif ($childService = $factory->getAttribute('service')) {
                    $class = new Reference($childService, ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE, false);
                } else {
                    $class = $factory->getAttribute('class');
=======
                if ($childService = $factory->getAttribute('service')) {
                    $class = new Reference($childService, ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE);
                } else {
                    $class = $factory->hasAttribute('class') ? $factory->getAttribute('class') : null;
>>>>>>> git-aline/master/master
                }

                $definition->setFactory(array($class, $factory->getAttribute('method')));
            }
        }

        if ($configurators = $this->getChildren($service, 'configurator')) {
            $configurator = $configurators[0];
            if ($function = $configurator->getAttribute('function')) {
                $definition->setConfigurator($function);
            } else {
<<<<<<< HEAD
                $configuratorService = $this->getChildren($configurator, 'service');

                if (isset($configuratorService[0])) {
                    $class = $this->parseDefinition($configuratorService[0], $file);
                } elseif ($childService = $configurator->getAttribute('service')) {
                    $class = new Reference($childService, ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE, false);
=======
                if ($childService = $configurator->getAttribute('service')) {
                    $class = new Reference($childService, ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE);
>>>>>>> git-aline/master/master
                } else {
                    $class = $configurator->getAttribute('class');
                }

                $definition->setConfigurator(array($class, $configurator->getAttribute('method')));
            }
        }

        foreach ($this->getChildren($service, 'call') as $call) {
<<<<<<< HEAD
            $definition->addMethodCall($call->getAttribute('method'), $this->getArgumentsAsPhp($call, 'argument'));
        }

        foreach ($this->getChildren($service, 'tag') as $tag) {
=======
            $definition->addMethodCall($call->getAttribute('method'), $this->getArgumentsAsPhp($call, 'argument', $file));
        }

        $tags = $this->getChildren($service, 'tag');

        if (!empty($defaults['tags'])) {
            $tags = array_merge($tags, $defaults['tags']);
        }

        foreach ($tags as $tag) {
>>>>>>> git-aline/master/master
            $parameters = array();
            foreach ($tag->attributes as $name => $node) {
                if ('name' === $name) {
                    continue;
                }

                if (false !== strpos($name, '-') && false === strpos($name, '_') && !array_key_exists($normalizedName = str_replace('-', '_', $name), $parameters)) {
                    $parameters[$normalizedName] = XmlUtils::phpize($node->nodeValue);
                }
<<<<<<< HEAD
                // keep not normalized key for BC too
                $parameters[$name] = XmlUtils::phpize($node->nodeValue);
            }

            $definition->addTag($tag->getAttribute('name'), $parameters);
        }

        if ($value = $service->getAttribute('decorates')) {
            $renameId = $service->hasAttribute('decoration-inner-name') ? $service->getAttribute('decoration-inner-name') : null;
            $definition->setDecoratedService($value, $renameId);
=======
                // keep not normalized key
                $parameters[$name] = XmlUtils::phpize($node->nodeValue);
            }

            if ('' === $tag->getAttribute('name')) {
                throw new InvalidArgumentException(sprintf('The tag name for service "%s" in %s must be a non-empty string.', (string) $service->getAttribute('id'), $file));
            }

            $definition->addTag($tag->getAttribute('name'), $parameters);
        }

        foreach ($this->getChildren($service, 'autowiring-type') as $type) {
            $definition->addAutowiringType($type->textContent);
        }

        $bindings = $this->getArgumentsAsPhp($service, 'bind', $file);
        if (isset($defaults['bind'])) {
            // deep clone, to avoid multiple process of the same instance in the passes
            $bindings = array_merge(unserialize(serialize($defaults['bind'])), $bindings);
        }
        if ($bindings) {
            $definition->setBindings($bindings);
        }

        if ($value = $service->getAttribute('decorates')) {
            $renameId = $service->hasAttribute('decoration-inner-name') ? $service->getAttribute('decoration-inner-name') : null;
            $priority = $service->hasAttribute('decoration-priority') ? $service->getAttribute('decoration-priority') : 0;
            $definition->setDecoratedService($value, $renameId, $priority);
>>>>>>> git-aline/master/master
        }

        return $definition;
    }

    /**
     * Parses a XML file to a \DOMDocument.
     *
     * @param string $file Path to a file
     *
     * @return \DOMDocument
     *
     * @throws InvalidArgumentException When loading of XML file returns error
     */
    private function parseFileToDOM($file)
    {
        try {
            $dom = XmlUtils::loadFile($file, array($this, 'validateSchema'));
        } catch (\InvalidArgumentException $e) {
            throw new InvalidArgumentException(sprintf('Unable to parse file "%s".', $file), $e->getCode(), $e);
        }

        $this->validateExtensions($dom, $file);

        return $dom;
    }

    /**
     * Processes anonymous services.
     *
     * @param \DOMDocument $xml
     * @param string       $file
<<<<<<< HEAD
     */
    private function processAnonymousServices(\DOMDocument $xml, $file)
    {
        $definitions = array();
        $count = 0;
=======
     * @param array        $defaults
     */
    private function processAnonymousServices(\DOMDocument $xml, $file, $defaults)
    {
        $definitions = array();
        $count = 0;
        $suffix = ContainerBuilder::hash($file);
>>>>>>> git-aline/master/master

        $xpath = new \DOMXPath($xml);
        $xpath->registerNamespace('container', self::NS);

        // anonymous services as arguments/properties
<<<<<<< HEAD
        if (false !== $nodes = $xpath->query('//container:argument[@type="service"][not(@id)]|//container:property[@type="service"][not(@id)]')) {
            foreach ($nodes as $node) {
                // give it a unique name
                $id = sprintf('%s_%d', hash('sha256', $file), ++$count);
                $node->setAttribute('id', $id);

                if ($services = $this->getChildren($node, 'service')) {
                    $definitions[$id] = array($services[0], $file, false);
                    $services[0]->setAttribute('id', $id);
=======
        if (false !== $nodes = $xpath->query('//container:argument[@type="service"][not(@id)]|//container:property[@type="service"][not(@id)]|//container:bind[not(@id)]|//container:factory[not(@service)]|//container:configurator[not(@service)]')) {
            foreach ($nodes as $node) {
                if ($services = $this->getChildren($node, 'service')) {
                    // give it a unique name
                    $id = sprintf('%d_%s', ++$count, preg_replace('/^.*\\\\/', '', $services[0]->getAttribute('class')).'~'.$suffix);
                    $node->setAttribute('id', $id);
                    $node->setAttribute('service', $id);

                    $definitions[$id] = array($services[0], $file, false);
                    $services[0]->setAttribute('id', $id);

                    // anonymous services are always private
                    // we could not use the constant false here, because of XML parsing
                    $services[0]->setAttribute('public', 'false');
>>>>>>> git-aline/master/master
                }
            }
        }

        // anonymous services "in the wild"
        if (false !== $nodes = $xpath->query('//container:services/container:service[not(@id)]')) {
            foreach ($nodes as $node) {
<<<<<<< HEAD
                // give it a unique name
                $id = sprintf('%s_%d', hash('sha256', $file), ++$count);
                $node->setAttribute('id', $id);

                if ($services = $this->getChildren($node, 'service')) {
                    $definitions[$id] = array($node, $file, true);
                    $services[0]->setAttribute('id', $id);
                }
=======
                @trigger_error(sprintf('Top-level anonymous services are deprecated since Symfony 3.4, the "id" attribute will be required in version 4.0 in %s at line %d.', $file, $node->getLineNo()), E_USER_DEPRECATED);

                // give it a unique name
                $id = sprintf('%d_%s', ++$count, preg_replace('/^.*\\\\/', '', $node->getAttribute('class')).$suffix);
                $node->setAttribute('id', $id);
                $definitions[$id] = array($node, $file, true);
>>>>>>> git-aline/master/master
            }
        }

        // resolve definitions
<<<<<<< HEAD
        krsort($definitions);
        foreach ($definitions as $id => $def) {
            list($domElement, $file, $wild) = $def;

            // anonymous services are always private
            // we could not use the constant false here, because of XML parsing
            $domElement->setAttribute('public', 'false');

            if (null !== $definition = $this->parseDefinition($domElement, $file)) {
                $this->container->setDefinition($id, $definition);
=======
        uksort($definitions, 'strnatcmp');
        foreach (array_reverse($definitions) as $id => list($domElement, $file, $wild)) {
            if (null !== $definition = $this->parseDefinition($domElement, $file, $wild ? $defaults : array())) {
                $this->setDefinition($id, $definition);
>>>>>>> git-aline/master/master
            }

            if (true === $wild) {
                $tmpDomElement = new \DOMElement('_services', null, self::NS);
                $domElement->parentNode->replaceChild($tmpDomElement, $domElement);
                $tmpDomElement->setAttribute('id', $id);
<<<<<<< HEAD
            } else {
                $domElement->parentNode->removeChild($domElement);
=======
>>>>>>> git-aline/master/master
            }
        }
    }

    /**
     * Returns arguments as valid php types.
     *
     * @param \DOMElement $node
     * @param string      $name
<<<<<<< HEAD
=======
     * @param string      $file
>>>>>>> git-aline/master/master
     * @param bool        $lowercase
     *
     * @return mixed
     */
<<<<<<< HEAD
    private function getArgumentsAsPhp(\DOMElement $node, $name, $lowercase = true)
=======
    private function getArgumentsAsPhp(\DOMElement $node, $name, $file, $lowercase = true, $isChildDefinition = false)
>>>>>>> git-aline/master/master
    {
        $arguments = array();
        foreach ($this->getChildren($node, $name) as $arg) {
            if ($arg->hasAttribute('name')) {
                $arg->setAttribute('key', $arg->getAttribute('name'));
            }

<<<<<<< HEAD
            if (!$arg->hasAttribute('key')) {
                $key = !$arguments ? 0 : max(array_keys($arguments)) + 1;
=======
            // this is used by ChildDefinition to overwrite a specific
            // argument of the parent definition
            if ($arg->hasAttribute('index')) {
                $key = ($isChildDefinition ? 'index_' : '').$arg->getAttribute('index');
            } elseif (!$arg->hasAttribute('key')) {
                // Append an empty argument, then fetch its key to overwrite it later
                $arguments[] = null;
                $keys = array_keys($arguments);
                $key = array_pop($keys);
>>>>>>> git-aline/master/master
            } else {
                $key = $arg->getAttribute('key');
            }

<<<<<<< HEAD
            // parameter keys are case insensitive
            if ('parameter' == $name && $lowercase) {
                $key = strtolower($key);
            }

            // this is used by DefinitionDecorator to overwrite a specific
            // argument of the parent definition
            if ($arg->hasAttribute('index')) {
                $key = 'index_'.$arg->getAttribute('index');
=======
            $onInvalid = $arg->getAttribute('on-invalid');
            $invalidBehavior = ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE;
            if ('ignore' == $onInvalid) {
                $invalidBehavior = ContainerInterface::IGNORE_ON_INVALID_REFERENCE;
            } elseif ('ignore_uninitialized' == $onInvalid) {
                $invalidBehavior = ContainerInterface::IGNORE_ON_UNINITIALIZED_REFERENCE;
            } elseif ('null' == $onInvalid) {
                $invalidBehavior = ContainerInterface::NULL_ON_INVALID_REFERENCE;
>>>>>>> git-aline/master/master
            }

            switch ($arg->getAttribute('type')) {
                case 'service':
<<<<<<< HEAD
                    $onInvalid = $arg->getAttribute('on-invalid');
                    $invalidBehavior = ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE;
                    if ('ignore' == $onInvalid) {
                        $invalidBehavior = ContainerInterface::IGNORE_ON_INVALID_REFERENCE;
                    } elseif ('null' == $onInvalid) {
                        $invalidBehavior = ContainerInterface::NULL_ON_INVALID_REFERENCE;
                    }

                    if ($strict = $arg->getAttribute('strict')) {
                        $strict = XmlUtils::phpize($strict);
                    } else {
                        $strict = true;
                    }

                    $arguments[$key] = new Reference($arg->getAttribute('id'), $invalidBehavior, $strict);
                    break;
                case 'expression':
                    $arguments[$key] = new Expression($arg->nodeValue);
                    break;
                case 'collection':
                    $arguments[$key] = $this->getArgumentsAsPhp($arg, $name, false);
=======
                    if (!$arg->getAttribute('id')) {
                        throw new InvalidArgumentException(sprintf('Tag "<%s>" with type="service" has no or empty "id" attribute in "%s".', $name, $file));
                    }
                    if ($arg->hasAttribute('strict')) {
                        @trigger_error(sprintf('The "strict" attribute used when referencing the "%s" service is deprecated since Symfony 3.3 and will be removed in 4.0.', $arg->getAttribute('id')), E_USER_DEPRECATED);
                    }

                    $arguments[$key] = new Reference($arg->getAttribute('id'), $invalidBehavior);
                    break;
                case 'expression':
                    if (!class_exists(Expression::class)) {
                        throw new \LogicException(sprintf('The type="expression" attribute cannot be used without the ExpressionLanguage component. Try running "composer require symfony/expression-language".'));
                    }

                    $arguments[$key] = new Expression($arg->nodeValue);
                    break;
                case 'collection':
                    $arguments[$key] = $this->getArgumentsAsPhp($arg, $name, $file, false);
                    break;
                case 'iterator':
                    $arg = $this->getArgumentsAsPhp($arg, $name, $file, false);
                    try {
                        $arguments[$key] = new IteratorArgument($arg);
                    } catch (InvalidArgumentException $e) {
                        throw new InvalidArgumentException(sprintf('Tag "<%s>" with type="iterator" only accepts collections of type="service" references in "%s".', $name, $file));
                    }
                    break;
                case 'tagged':
                    if (!$arg->getAttribute('tag')) {
                        throw new InvalidArgumentException(sprintf('Tag "<%s>" with type="tagged" has no or empty "tag" attribute in "%s".', $name, $file));
                    }
                    $arguments[$key] = new TaggedIteratorArgument($arg->getAttribute('tag'));
>>>>>>> git-aline/master/master
                    break;
                case 'string':
                    $arguments[$key] = $arg->nodeValue;
                    break;
                case 'constant':
<<<<<<< HEAD
                    $arguments[$key] = constant($arg->nodeValue);
=======
                    $arguments[$key] = \constant(trim($arg->nodeValue));
>>>>>>> git-aline/master/master
                    break;
                default:
                    $arguments[$key] = XmlUtils::phpize($arg->nodeValue);
            }
        }

        return $arguments;
    }

    /**
     * Get child elements by name.
     *
     * @param \DOMNode $node
     * @param mixed    $name
     *
     * @return array
     */
    private function getChildren(\DOMNode $node, $name)
    {
        $children = array();
        foreach ($node->childNodes as $child) {
<<<<<<< HEAD
            if ($child instanceof \DOMElement && $child->localName === $name && $child->namespaceURI === self::NS) {
=======
            if ($child instanceof \DOMElement && $child->localName === $name && self::NS === $child->namespaceURI) {
>>>>>>> git-aline/master/master
                $children[] = $child;
            }
        }

        return $children;
    }

    /**
     * Validates a documents XML schema.
     *
     * @param \DOMDocument $dom
     *
     * @return bool
     *
     * @throws RuntimeException When extension references a non-existent XSD file
     */
    public function validateSchema(\DOMDocument $dom)
    {
        $schemaLocations = array('http://symfony.com/schema/dic/services' => str_replace('\\', '/', __DIR__.'/schema/dic/services/services-1.0.xsd'));

        if ($element = $dom->documentElement->getAttributeNS('http://www.w3.org/2001/XMLSchema-instance', 'schemaLocation')) {
            $items = preg_split('/\s+/', $element);
<<<<<<< HEAD
            for ($i = 0, $nb = count($items); $i < $nb; $i += 2) {
=======
            for ($i = 0, $nb = \count($items); $i < $nb; $i += 2) {
>>>>>>> git-aline/master/master
                if (!$this->container->hasExtension($items[$i])) {
                    continue;
                }

                if (($extension = $this->container->getExtension($items[$i])) && false !== $extension->getXsdValidationBasePath()) {
                    $path = str_replace($extension->getNamespace(), str_replace('\\', '/', $extension->getXsdValidationBasePath()).'/', $items[$i + 1]);

                    if (!is_file($path)) {
<<<<<<< HEAD
                        throw new RuntimeException(sprintf('Extension "%s" references a non-existent XSD file "%s"', get_class($extension), $path));
=======
                        throw new RuntimeException(sprintf('Extension "%s" references a non-existent XSD file "%s"', \get_class($extension), $path));
>>>>>>> git-aline/master/master
                    }

                    $schemaLocations[$items[$i]] = $path;
                }
            }
        }

        $tmpfiles = array();
        $imports = '';
        foreach ($schemaLocations as $namespace => $location) {
            $parts = explode('/', $location);
<<<<<<< HEAD
            if (0 === stripos($location, 'phar://')) {
                $tmpfile = tempnam(sys_get_temp_dir(), 'sf2');
=======
            $locationstart = 'file:///';
            if (0 === stripos($location, 'phar://')) {
                $tmpfile = tempnam(sys_get_temp_dir(), 'symfony');
>>>>>>> git-aline/master/master
                if ($tmpfile) {
                    copy($location, $tmpfile);
                    $tmpfiles[] = $tmpfile;
                    $parts = explode('/', str_replace('\\', '/', $tmpfile));
<<<<<<< HEAD
                }
            }
            $drive = '\\' === DIRECTORY_SEPARATOR ? array_shift($parts).'/' : '';
            $location = 'file:///'.$drive.implode('/', array_map('rawurlencode', $parts));
=======
                } else {
                    array_shift($parts);
                    $locationstart = 'phar:///';
                }
            }
            $drive = '\\' === \DIRECTORY_SEPARATOR ? array_shift($parts).'/' : '';
            $location = $locationstart.$drive.implode('/', array_map('rawurlencode', $parts));
>>>>>>> git-aline/master/master

            $imports .= sprintf('  <xsd:import namespace="%s" schemaLocation="%s" />'."\n", $namespace, $location);
        }

        $source = <<<EOF
<?xml version="1.0" encoding="utf-8" ?>
<xsd:schema xmlns="http://symfony.com/schema"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema"
    targetNamespace="http://symfony.com/schema"
    elementFormDefault="qualified">

    <xsd:import namespace="http://www.w3.org/XML/1998/namespace"/>
$imports
</xsd:schema>
EOF
        ;

<<<<<<< HEAD
        $valid = @$dom->schemaValidateSource($source);
=======
        $disableEntities = libxml_disable_entity_loader(false);
        $valid = @$dom->schemaValidateSource($source);
        libxml_disable_entity_loader($disableEntities);
>>>>>>> git-aline/master/master

        foreach ($tmpfiles as $tmpfile) {
            @unlink($tmpfile);
        }

        return $valid;
    }

    /**
<<<<<<< HEAD
=======
     * Validates an alias.
     *
     * @param \DOMElement $alias
     * @param string      $file
     */
    private function validateAlias(\DOMElement $alias, $file)
    {
        foreach ($alias->attributes as $name => $node) {
            if (!\in_array($name, array('alias', 'id', 'public'))) {
                @trigger_error(sprintf('Using the attribute "%s" is deprecated for the service "%s" which is defined as an alias in "%s". Allowed attributes for service aliases are "alias", "id" and "public". The XmlFileLoader will raise an exception in Symfony 4.0, instead of silently ignoring unsupported attributes.', $name, $alias->getAttribute('id'), $file), E_USER_DEPRECATED);
            }
        }

        foreach ($alias->childNodes as $child) {
            if ($child instanceof \DOMElement && self::NS === $child->namespaceURI) {
                @trigger_error(sprintf('Using the element "%s" is deprecated for the service "%s" which is defined as an alias in "%s". The XmlFileLoader will raise an exception in Symfony 4.0, instead of silently ignoring unsupported elements.', $child->localName, $alias->getAttribute('id'), $file), E_USER_DEPRECATED);
            }
        }
    }

    /**
>>>>>>> git-aline/master/master
     * Validates an extension.
     *
     * @param \DOMDocument $dom
     * @param string       $file
     *
     * @throws InvalidArgumentException When no extension is found corresponding to a tag
     */
    private function validateExtensions(\DOMDocument $dom, $file)
    {
        foreach ($dom->documentElement->childNodes as $node) {
            if (!$node instanceof \DOMElement || 'http://symfony.com/schema/dic/services' === $node->namespaceURI) {
                continue;
            }

            // can it be handled by an extension?
            if (!$this->container->hasExtension($node->namespaceURI)) {
                $extensionNamespaces = array_filter(array_map(function ($ext) { return $ext->getNamespace(); }, $this->container->getExtensions()));
                throw new InvalidArgumentException(sprintf(
                    'There is no extension able to load the configuration for "%s" (in %s). Looked for namespace "%s", found %s',
                    $node->tagName,
                    $file,
                    $node->namespaceURI,
                    $extensionNamespaces ? sprintf('"%s"', implode('", "', $extensionNamespaces)) : 'none'
                ));
            }
        }
    }

    /**
     * Loads from an extension.
     *
     * @param \DOMDocument $xml
     */
    private function loadFromExtensions(\DOMDocument $xml)
    {
        foreach ($xml->documentElement->childNodes as $node) {
<<<<<<< HEAD
            if (!$node instanceof \DOMElement || $node->namespaceURI === self::NS) {
=======
            if (!$node instanceof \DOMElement || self::NS === $node->namespaceURI) {
>>>>>>> git-aline/master/master
                continue;
            }

            $values = static::convertDomElementToArray($node);
<<<<<<< HEAD
            if (!is_array($values)) {
=======
            if (!\is_array($values)) {
>>>>>>> git-aline/master/master
                $values = array();
            }

            $this->container->loadFromExtension($node->namespaceURI, $values);
        }
    }

    /**
<<<<<<< HEAD
     * Converts a \DomElement object to a PHP array.
=======
     * Converts a \DOMElement object to a PHP array.
>>>>>>> git-aline/master/master
     *
     * The following rules applies during the conversion:
     *
     *  * Each tag is converted to a key value or an array
     *    if there is more than one "value"
     *
     *  * The content of a tag is set under a "value" key (<foo>bar</foo>)
     *    if the tag also has some nested tags
     *
     *  * The attributes are converted to keys (<foo foo="bar"/>)
     *
     *  * The nested-tags are converted to keys (<foo><foo>bar</foo></foo>)
     *
<<<<<<< HEAD
     * @param \DomElement $element A \DomElement instance
     *
     * @return array A PHP array
     */
    public static function convertDomElementToArray(\DomElement $element)
=======
     * @param \DOMElement $element A \DOMElement instance
     *
     * @return array A PHP array
     */
    public static function convertDomElementToArray(\DOMElement $element)
>>>>>>> git-aline/master/master
    {
        return XmlUtils::convertDomElementToArray($element);
    }
}
