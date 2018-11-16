<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

/**
 * Compiler Pass Configuration.
 *
 * This class has a default configuration embedded.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class PassConfig
{
    const TYPE_AFTER_REMOVING = 'afterRemoving';
    const TYPE_BEFORE_OPTIMIZATION = 'beforeOptimization';
    const TYPE_BEFORE_REMOVING = 'beforeRemoving';
    const TYPE_OPTIMIZE = 'optimization';
    const TYPE_REMOVE = 'removing';

    private $mergePass;
    private $afterRemovingPasses = array();
    private $beforeOptimizationPasses = array();
    private $beforeRemovingPasses = array();
    private $optimizationPasses;
    private $removingPasses;

<<<<<<< HEAD
    /**
     * Constructor.
     */
=======
>>>>>>> git-aline/master/master
    public function __construct()
    {
        $this->mergePass = new MergeExtensionConfigurationPass();

<<<<<<< HEAD
        $this->optimizationPasses = array(
            new ExtensionCompilerPass(),
            new ResolveDefinitionTemplatesPass(),
            new DecoratorServicePass(),
            new ResolveParameterPlaceHoldersPass(),
            new CheckDefinitionValidityPass(),
=======
        $this->beforeOptimizationPasses = array(
            100 => array(
                $resolveClassPass = new ResolveClassPass(),
                new ResolveInstanceofConditionalsPass(),
                new RegisterEnvVarProcessorsPass(),
            ),
            -1000 => array(new ExtensionCompilerPass()),
        );

        $this->optimizationPasses = array(array(
            new ResolveChildDefinitionsPass(),
            new ServiceLocatorTagPass(),
            new DecoratorServicePass(),
            new ResolveParameterPlaceHoldersPass(false),
            new ResolveFactoryClassPass(),
            new FactoryReturnTypePass($resolveClassPass),
            new CheckDefinitionValidityPass(),
            new RegisterServiceSubscribersPass(),
            new ResolveNamedArgumentsPass(),
            new AutowireRequiredMethodsPass(),
            new ResolveBindingsPass(),
            new AutowirePass(false),
            new ResolveTaggedIteratorArgumentPass(),
            new ResolveServiceSubscribersPass(),
>>>>>>> git-aline/master/master
            new ResolveReferencesToAliasesPass(),
            new ResolveInvalidReferencesPass(),
            new AnalyzeServiceReferencesPass(true),
            new CheckCircularReferencesPass(),
            new CheckReferenceValidityPass(),
<<<<<<< HEAD
        );

        $this->removingPasses = array(
            new RemovePrivateAliasesPass(),
            new RemoveAbstractDefinitionsPass(),
            new ReplaceAliasByActualDefinitionPass(),
=======
            new CheckArgumentsValidityPass(false),
        ));

        $this->beforeRemovingPasses = array(
            -100 => array(
                new ResolvePrivatesPass(),
            ),
        );

        $this->removingPasses = array(array(
            new RemovePrivateAliasesPass(),
            new ReplaceAliasByActualDefinitionPass(),
            new RemoveAbstractDefinitionsPass(),
>>>>>>> git-aline/master/master
            new RepeatedPass(array(
                new AnalyzeServiceReferencesPass(),
                new InlineServiceDefinitionsPass(),
                new AnalyzeServiceReferencesPass(),
                new RemoveUnusedDefinitionsPass(),
            )),
<<<<<<< HEAD
            new CheckExceptionOnInvalidReferenceBehaviorPass(),
        );
=======
            new DefinitionErrorExceptionPass(),
            new CheckExceptionOnInvalidReferenceBehaviorPass(),
            new ResolveHotPathPass(),
        ));
>>>>>>> git-aline/master/master
    }

    /**
     * Returns all passes in order to be processed.
     *
<<<<<<< HEAD
     * @return array An array of all passes to process
=======
     * @return CompilerPassInterface[]
>>>>>>> git-aline/master/master
     */
    public function getPasses()
    {
        return array_merge(
            array($this->mergePass),
<<<<<<< HEAD
            $this->beforeOptimizationPasses,
            $this->optimizationPasses,
            $this->beforeRemovingPasses,
            $this->removingPasses,
            $this->afterRemovingPasses
=======
            $this->getBeforeOptimizationPasses(),
            $this->getOptimizationPasses(),
            $this->getBeforeRemovingPasses(),
            $this->getRemovingPasses(),
            $this->getAfterRemovingPasses()
>>>>>>> git-aline/master/master
        );
    }

    /**
     * Adds a pass.
     *
<<<<<<< HEAD
     * @param CompilerPassInterface $pass A Compiler pass
     * @param string                $type The pass type
     *
     * @throws InvalidArgumentException when a pass type doesn't exist
     */
    public function addPass(CompilerPassInterface $pass, $type = self::TYPE_BEFORE_OPTIMIZATION)
    {
=======
     * @param CompilerPassInterface $pass     A Compiler pass
     * @param string                $type     The pass type
     * @param int                   $priority Used to sort the passes
     *
     * @throws InvalidArgumentException when a pass type doesn't exist
     */
    public function addPass(CompilerPassInterface $pass, $type = self::TYPE_BEFORE_OPTIMIZATION/*, int $priority = 0*/)
    {
        if (\func_num_args() >= 3) {
            $priority = func_get_arg(2);
        } else {
            if (__CLASS__ !== \get_class($this)) {
                $r = new \ReflectionMethod($this, __FUNCTION__);
                if (__CLASS__ !== $r->getDeclaringClass()->getName()) {
                    @trigger_error(sprintf('Method %s() will have a third `int $priority = 0` argument in version 4.0. Not defining it is deprecated since Symfony 3.2.', __METHOD__), E_USER_DEPRECATED);
                }
            }

            $priority = 0;
        }

>>>>>>> git-aline/master/master
        $property = $type.'Passes';
        if (!isset($this->$property)) {
            throw new InvalidArgumentException(sprintf('Invalid type "%s".', $type));
        }

        $passes = &$this->$property;
<<<<<<< HEAD
        $passes[] = $pass;
=======

        if (!isset($passes[$priority])) {
            $passes[$priority] = array();
        }
        $passes[$priority][] = $pass;
>>>>>>> git-aline/master/master
    }

    /**
     * Gets all passes for the AfterRemoving pass.
     *
<<<<<<< HEAD
     * @return array An array of passes
     */
    public function getAfterRemovingPasses()
    {
        return $this->afterRemovingPasses;
=======
     * @return CompilerPassInterface[]
     */
    public function getAfterRemovingPasses()
    {
        return $this->sortPasses($this->afterRemovingPasses);
>>>>>>> git-aline/master/master
    }

    /**
     * Gets all passes for the BeforeOptimization pass.
     *
<<<<<<< HEAD
     * @return array An array of passes
     */
    public function getBeforeOptimizationPasses()
    {
        return $this->beforeOptimizationPasses;
=======
     * @return CompilerPassInterface[]
     */
    public function getBeforeOptimizationPasses()
    {
        return $this->sortPasses($this->beforeOptimizationPasses);
>>>>>>> git-aline/master/master
    }

    /**
     * Gets all passes for the BeforeRemoving pass.
     *
<<<<<<< HEAD
     * @return array An array of passes
     */
    public function getBeforeRemovingPasses()
    {
        return $this->beforeRemovingPasses;
=======
     * @return CompilerPassInterface[]
     */
    public function getBeforeRemovingPasses()
    {
        return $this->sortPasses($this->beforeRemovingPasses);
>>>>>>> git-aline/master/master
    }

    /**
     * Gets all passes for the Optimization pass.
     *
<<<<<<< HEAD
     * @return array An array of passes
     */
    public function getOptimizationPasses()
    {
        return $this->optimizationPasses;
=======
     * @return CompilerPassInterface[]
     */
    public function getOptimizationPasses()
    {
        return $this->sortPasses($this->optimizationPasses);
>>>>>>> git-aline/master/master
    }

    /**
     * Gets all passes for the Removing pass.
     *
<<<<<<< HEAD
     * @return array An array of passes
     */
    public function getRemovingPasses()
    {
        return $this->removingPasses;
    }

    /**
     * Gets all passes for the Merge pass.
     *
     * @return array An array of passes
=======
     * @return CompilerPassInterface[]
     */
    public function getRemovingPasses()
    {
        return $this->sortPasses($this->removingPasses);
    }

    /**
     * Gets the Merge pass.
     *
     * @return CompilerPassInterface
>>>>>>> git-aline/master/master
     */
    public function getMergePass()
    {
        return $this->mergePass;
    }

<<<<<<< HEAD
    /**
     * Sets the Merge Pass.
     *
     * @param CompilerPassInterface $pass The merge pass
     */
=======
>>>>>>> git-aline/master/master
    public function setMergePass(CompilerPassInterface $pass)
    {
        $this->mergePass = $pass;
    }

    /**
     * Sets the AfterRemoving passes.
     *
<<<<<<< HEAD
     * @param array $passes An array of passes
     */
    public function setAfterRemovingPasses(array $passes)
    {
        $this->afterRemovingPasses = $passes;
=======
     * @param CompilerPassInterface[] $passes
     */
    public function setAfterRemovingPasses(array $passes)
    {
        $this->afterRemovingPasses = array($passes);
>>>>>>> git-aline/master/master
    }

    /**
     * Sets the BeforeOptimization passes.
     *
<<<<<<< HEAD
     * @param array $passes An array of passes
     */
    public function setBeforeOptimizationPasses(array $passes)
    {
        $this->beforeOptimizationPasses = $passes;
=======
     * @param CompilerPassInterface[] $passes
     */
    public function setBeforeOptimizationPasses(array $passes)
    {
        $this->beforeOptimizationPasses = array($passes);
>>>>>>> git-aline/master/master
    }

    /**
     * Sets the BeforeRemoving passes.
     *
<<<<<<< HEAD
     * @param array $passes An array of passes
     */
    public function setBeforeRemovingPasses(array $passes)
    {
        $this->beforeRemovingPasses = $passes;
=======
     * @param CompilerPassInterface[] $passes
     */
    public function setBeforeRemovingPasses(array $passes)
    {
        $this->beforeRemovingPasses = array($passes);
>>>>>>> git-aline/master/master
    }

    /**
     * Sets the Optimization passes.
     *
<<<<<<< HEAD
     * @param array $passes An array of passes
     */
    public function setOptimizationPasses(array $passes)
    {
        $this->optimizationPasses = $passes;
=======
     * @param CompilerPassInterface[] $passes
     */
    public function setOptimizationPasses(array $passes)
    {
        $this->optimizationPasses = array($passes);
>>>>>>> git-aline/master/master
    }

    /**
     * Sets the Removing passes.
     *
<<<<<<< HEAD
     * @param array $passes An array of passes
     */
    public function setRemovingPasses(array $passes)
    {
        $this->removingPasses = $passes;
=======
     * @param CompilerPassInterface[] $passes
     */
    public function setRemovingPasses(array $passes)
    {
        $this->removingPasses = array($passes);
    }

    /**
     * Sort passes by priority.
     *
     * @param array $passes CompilerPassInterface instances with their priority as key
     *
     * @return CompilerPassInterface[]
     */
    private function sortPasses(array $passes)
    {
        if (0 === \count($passes)) {
            return array();
        }

        krsort($passes);

        // Flatten the array
        return \call_user_func_array('array_merge', $passes);
>>>>>>> git-aline/master/master
    }
}
