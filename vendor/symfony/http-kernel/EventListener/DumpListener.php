<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\EventListener;

<<<<<<< HEAD
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
=======
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
>>>>>>> git-aline/master/master
use Symfony\Component\VarDumper\Cloner\ClonerInterface;
use Symfony\Component\VarDumper\Dumper\DataDumperInterface;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Configures dump() handler.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
class DumpListener implements EventSubscriberInterface
{
    private $cloner;
    private $dumper;

<<<<<<< HEAD
    /**
     * @param ClonerInterface     $cloner Cloner service.
     * @param DataDumperInterface $dumper Dumper service.
     */
=======
>>>>>>> git-aline/master/master
    public function __construct(ClonerInterface $cloner, DataDumperInterface $dumper)
    {
        $this->cloner = $cloner;
        $this->dumper = $dumper;
    }

    public function configure()
    {
        $cloner = $this->cloner;
        $dumper = $this->dumper;

        VarDumper::setHandler(function ($var) use ($cloner, $dumper) {
            $dumper->dump($cloner->cloneVar($var));
        });
    }

    public static function getSubscribedEvents()
    {
<<<<<<< HEAD
        // Register early to have a working dump() as early as possible
        return array(KernelEvents::REQUEST => array('configure', 1024));
=======
        if (!class_exists(ConsoleEvents::class)) {
            return array();
        }

        // Register early to have a working dump() as early as possible
        return array(ConsoleEvents::COMMAND => array('configure', 1024));
>>>>>>> git-aline/master/master
    }
}
