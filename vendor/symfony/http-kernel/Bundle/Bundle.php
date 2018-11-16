<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\Bundle;

<<<<<<< HEAD
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Console\Application;
use Symfony\Component\Finder\Finder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
=======
use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\Finder\Finder;
>>>>>>> git-aline/master/master

/**
 * An implementation of BundleInterface that adds a few conventions
 * for DependencyInjection extensions and Console commands.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
<<<<<<< HEAD
abstract class Bundle extends ContainerAware implements BundleInterface
{
    protected $name;
    protected $extension;
    protected $path;
=======
abstract class Bundle implements BundleInterface
{
    use ContainerAwareTrait;

    protected $name;
    protected $extension;
    protected $path;
    private $namespace;
>>>>>>> git-aline/master/master

    /**
     * Boots the Bundle.
     */
    public function boot()
    {
    }

    /**
     * Shutdowns the Bundle.
     */
    public function shutdown()
    {
    }

    /**
     * Builds the bundle.
     *
     * It is only ever called once when the cache is empty.
     *
     * This method can be overridden to register compilation passes,
     * other extensions, ...
<<<<<<< HEAD
     *
     * @param ContainerBuilder $container A ContainerBuilder instance
=======
>>>>>>> git-aline/master/master
     */
    public function build(ContainerBuilder $container)
    {
    }

    /**
     * Returns the bundle's container extension.
     *
     * @return ExtensionInterface|null The container extension
     *
     * @throws \LogicException
     */
    public function getContainerExtension()
    {
        if (null === $this->extension) {
<<<<<<< HEAD
            $class = $this->getContainerExtensionClass();
            if (class_exists($class)) {
                $extension = new $class();

                if (!$extension instanceof ExtensionInterface) {
                    throw new \LogicException(sprintf('Extension %s must implement Symfony\Component\DependencyInjection\Extension\ExtensionInterface.', $class));
=======
            $extension = $this->createContainerExtension();

            if (null !== $extension) {
                if (!$extension instanceof ExtensionInterface) {
                    throw new \LogicException(sprintf('Extension %s must implement Symfony\Component\DependencyInjection\Extension\ExtensionInterface.', \get_class($extension)));
>>>>>>> git-aline/master/master
                }

                // check naming convention
                $basename = preg_replace('/Bundle$/', '', $this->getName());
                $expectedAlias = Container::underscore($basename);
<<<<<<< HEAD
=======

>>>>>>> git-aline/master/master
                if ($expectedAlias != $extension->getAlias()) {
                    throw new \LogicException(sprintf(
                        'Users will expect the alias of the default extension of a bundle to be the underscored version of the bundle name ("%s"). You can override "Bundle::getContainerExtension()" if you want to use "%s" or another alias.',
                        $expectedAlias, $extension->getAlias()
                    ));
                }

                $this->extension = $extension;
            } else {
                $this->extension = false;
            }
        }

        if ($this->extension) {
            return $this->extension;
        }
    }

    /**
     * Gets the Bundle namespace.
     *
     * @return string The Bundle namespace
     */
    public function getNamespace()
    {
<<<<<<< HEAD
        $class = get_class($this);

        return substr($class, 0, strrpos($class, '\\'));
=======
        if (null === $this->namespace) {
            $this->parseClassName();
        }

        return $this->namespace;
>>>>>>> git-aline/master/master
    }

    /**
     * Gets the Bundle directory path.
     *
     * @return string The Bundle absolute path
     */
    public function getPath()
    {
        if (null === $this->path) {
            $reflected = new \ReflectionObject($this);
<<<<<<< HEAD
            $this->path = dirname($reflected->getFileName());
=======
            $this->path = \dirname($reflected->getFileName());
>>>>>>> git-aline/master/master
        }

        return $this->path;
    }

    /**
     * Returns the bundle parent name.
     *
<<<<<<< HEAD
     * @return string The Bundle parent name it overrides or null if no parent
=======
     * @return string|null The Bundle parent name it overrides or null if no parent
>>>>>>> git-aline/master/master
     */
    public function getParent()
    {
    }

    /**
     * Returns the bundle name (the class short name).
     *
     * @return string The Bundle name
     */
    final public function getName()
    {
<<<<<<< HEAD
        if (null !== $this->name) {
            return $this->name;
        }

        $name = get_class($this);
        $pos = strrpos($name, '\\');

        return $this->name = false === $pos ? $name : substr($name, $pos + 1);
=======
        if (null === $this->name) {
            $this->parseClassName();
        }

        return $this->name;
>>>>>>> git-aline/master/master
    }

    /**
     * Finds and registers Commands.
     *
     * Override this method if your bundle commands do not follow the conventions:
     *
     * * Commands are in the 'Command' sub-directory
     * * Commands extend Symfony\Component\Console\Command\Command
<<<<<<< HEAD
     *
     * @param Application $application An Application instance
=======
>>>>>>> git-aline/master/master
     */
    public function registerCommands(Application $application)
    {
        if (!is_dir($dir = $this->getPath().'/Command')) {
            return;
        }

<<<<<<< HEAD
=======
        if (!class_exists('Symfony\Component\Finder\Finder')) {
            throw new \RuntimeException('You need the symfony/finder component to register bundle commands.');
        }

>>>>>>> git-aline/master/master
        $finder = new Finder();
        $finder->files()->name('*Command.php')->in($dir);

        $prefix = $this->getNamespace().'\\Command';
        foreach ($finder as $file) {
            $ns = $prefix;
            if ($relativePath = $file->getRelativePath()) {
<<<<<<< HEAD
                $ns .= '\\'.strtr($relativePath, '/', '\\');
            }
            $class = $ns.'\\'.$file->getBasename('.php');
            if ($this->container) {
                $alias = 'console.command.'.strtolower(str_replace('\\', '_', $class));
                if ($this->container->has($alias)) {
=======
                $ns .= '\\'.str_replace('/', '\\', $relativePath);
            }
            $class = $ns.'\\'.$file->getBasename('.php');
            if ($this->container) {
                $commandIds = $this->container->hasParameter('console.command.ids') ? $this->container->getParameter('console.command.ids') : array();
                $alias = 'console.command.'.strtolower(str_replace('\\', '_', $class));
                if (isset($commandIds[$alias]) || $this->container->has($alias)) {
>>>>>>> git-aline/master/master
                    continue;
                }
            }
            $r = new \ReflectionClass($class);
            if ($r->isSubclassOf('Symfony\\Component\\Console\\Command\\Command') && !$r->isAbstract() && !$r->getConstructor()->getNumberOfRequiredParameters()) {
<<<<<<< HEAD
=======
                @trigger_error(sprintf('Auto-registration of the command "%s" is deprecated since Symfony 3.4 and won\'t be supported in 4.0. Use PSR-4 based service discovery instead.', $class), E_USER_DEPRECATED);

>>>>>>> git-aline/master/master
                $application->add($r->newInstance());
            }
        }
    }

    /**
     * Returns the bundle's container extension class.
     *
     * @return string
     */
    protected function getContainerExtensionClass()
    {
        $basename = preg_replace('/Bundle$/', '', $this->getName());

        return $this->getNamespace().'\\DependencyInjection\\'.$basename.'Extension';
    }
<<<<<<< HEAD
=======

    /**
     * Creates the bundle's container extension.
     *
     * @return ExtensionInterface|null
     */
    protected function createContainerExtension()
    {
        if (class_exists($class = $this->getContainerExtensionClass())) {
            return new $class();
        }
    }

    private function parseClassName()
    {
        $pos = strrpos(static::class, '\\');
        $this->namespace = false === $pos ? '' : substr(static::class, 0, $pos);
        if (null === $this->name) {
            $this->name = false === $pos ? static::class : substr(static::class, $pos + 1);
        }
    }
>>>>>>> git-aline/master/master
}
