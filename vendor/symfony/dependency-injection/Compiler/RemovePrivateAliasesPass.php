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

/**
 * Remove private aliases from the container. They were only used to establish
 * dependencies between services, and these dependencies have been resolved in
 * one of the previous passes.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class RemovePrivateAliasesPass implements CompilerPassInterface
{
    /**
     * Removes private aliases from the ContainerBuilder.
<<<<<<< HEAD
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $compiler = $container->getCompiler();
        $formatter = $compiler->getLoggingFormatter();

        foreach ($container->getAliases() as $id => $alias) {
            if ($alias->isPublic()) {
=======
     */
    public function process(ContainerBuilder $container)
    {
        foreach ($container->getAliases() as $id => $alias) {
            if ($alias->isPublic() || $alias->isPrivate()) {
>>>>>>> git-aline/master/master
                continue;
            }

            $container->removeAlias($id);
<<<<<<< HEAD
            $compiler->addLogMessage($formatter->formatRemoveService($this, $id, 'private alias'));
=======
            $container->log($this, sprintf('Removed service "%s"; reason: private alias.', $id));
>>>>>>> git-aline/master/master
        }
    }
}
