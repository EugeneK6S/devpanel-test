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

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Replaces aliases with actual service definitions, effectively removing these
 * aliases.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
<<<<<<< HEAD
class ReplaceAliasByActualDefinitionPass implements CompilerPassInterface
{
    private $compiler;
    private $formatter;
    private $sourceId;
=======
class ReplaceAliasByActualDefinitionPass extends AbstractRecursivePass
{
    private $replacements;
>>>>>>> git-aline/master/master

    /**
     * Process the Container to replace aliases with service definitions.
     *
<<<<<<< HEAD
     * @param ContainerBuilder $container
     *
=======
>>>>>>> git-aline/master/master
     * @throws InvalidArgumentException if the service definition does not exist
     */
    public function process(ContainerBuilder $container)
    {
<<<<<<< HEAD
        $this->compiler = $container->getCompiler();
        $this->formatter = $this->compiler->getLoggingFormatter();

        foreach ($container->getAliases() as $id => $alias) {
            $aliasId = (string) $alias;

            try {
                $definition = $container->getDefinition($aliasId);
            } catch (InvalidArgumentException $e) {
                throw new InvalidArgumentException(sprintf('Unable to replace alias "%s" with "%s".', $alias, $id), null, $e);
            }

            if ($definition->isPublic()) {
                continue;
            }

            $definition->setPublic(true);
            $container->setDefinition($id, $definition);
            $container->removeDefinition($aliasId);

            $this->updateReferences($container, $aliasId, $id);

            // we have to restart the process due to concurrent modification of
            // the container
            $this->process($container);

            break;
        }
    }

    /**
     * Updates references to remove aliases.
     *
     * @param ContainerBuilder $container The container
     * @param string           $currentId The alias identifier being replaced
     * @param string           $newId     The id of the service the alias points to
     */
    private function updateReferences($container, $currentId, $newId)
    {
        foreach ($container->getAliases() as $id => $alias) {
            if ($currentId === (string) $alias) {
                $container->setAlias($id, $newId);
            }
        }

        foreach ($container->getDefinitions() as $id => $definition) {
            $this->sourceId = $id;

            $definition->setArguments(
                $this->updateArgumentReferences($definition->getArguments(), $currentId, $newId)
            );

            $definition->setMethodCalls(
                $this->updateArgumentReferences($definition->getMethodCalls(), $currentId, $newId)
            );

            $definition->setProperties(
                $this->updateArgumentReferences($definition->getProperties(), $currentId, $newId)
            );
        }
    }

    /**
     * Updates argument references.
     *
     * @param array  $arguments An array of Arguments
     * @param string $currentId The alias identifier
     * @param string $newId     The identifier the alias points to
     *
     * @return array
     */
    private function updateArgumentReferences(array $arguments, $currentId, $newId)
    {
        foreach ($arguments as $k => $argument) {
            if (is_array($argument)) {
                $arguments[$k] = $this->updateArgumentReferences($argument, $currentId, $newId);
            } elseif ($argument instanceof Reference) {
                if ($currentId === (string) $argument) {
                    $arguments[$k] = new Reference($newId, $argument->getInvalidBehavior());
                    $this->compiler->addLogMessage($this->formatter->formatUpdateReference($this, $this->sourceId, $currentId, $newId));
                }
            }
        }

        return $arguments;
=======
        // First collect all alias targets that need to be replaced
        $seenAliasTargets = array();
        $replacements = array();
        foreach ($container->getAliases() as $definitionId => $target) {
            $targetId = $container->normalizeId($target);
            // Special case: leave this target alone
            if ('service_container' === $targetId) {
                continue;
            }
            // Check if target needs to be replaces
            if (isset($replacements[$targetId])) {
                $container->setAlias($definitionId, $replacements[$targetId])->setPublic($target->isPublic())->setPrivate($target->isPrivate());
            }
            // No need to process the same target twice
            if (isset($seenAliasTargets[$targetId])) {
                continue;
            }
            // Process new target
            $seenAliasTargets[$targetId] = true;
            try {
                $definition = $container->getDefinition($targetId);
            } catch (InvalidArgumentException $e) {
                throw new InvalidArgumentException(sprintf('Unable to replace alias "%s" with actual definition "%s".', $definitionId, $targetId), null, $e);
            }
            if ($definition->isPublic() || $definition->isPrivate()) {
                continue;
            }
            // Remove private definition and schedule for replacement
            $definition->setPublic(!$target->isPrivate());
            $definition->setPrivate($target->isPrivate());
            $container->setDefinition($definitionId, $definition);
            $container->removeDefinition($targetId);
            $replacements[$targetId] = $definitionId;
        }
        $this->replacements = $replacements;

        parent::process($container);
        $this->replacements = array();
    }

    /**
     * {@inheritdoc}
     */
    protected function processValue($value, $isRoot = false)
    {
        if ($value instanceof Reference && isset($this->replacements[$referenceId = $this->container->normalizeId($value)])) {
            // Perform the replacement
            $newId = $this->replacements[$referenceId];
            $value = new Reference($newId, $value->getInvalidBehavior());
            $this->container->log($this, sprintf('Changed reference of service "%s" previously pointing to "%s" to "%s".', $this->currentId, $referenceId, $newId));
        }

        return parent::processValue($value, $isRoot);
>>>>>>> git-aline/master/master
    }
}
