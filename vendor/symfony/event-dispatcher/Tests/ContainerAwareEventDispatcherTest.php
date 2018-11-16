<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\EventDispatcher\Tests;

use Symfony\Component\DependencyInjection\Container;
<<<<<<< HEAD
use Symfony\Component\DependencyInjection\Scope;
=======
>>>>>>> git-aline/master/master
use Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

<<<<<<< HEAD
=======
/**
 * @group legacy
 */
>>>>>>> git-aline/master/master
class ContainerAwareEventDispatcherTest extends AbstractEventDispatcherTest
{
    protected function createEventDispatcher()
    {
        $container = new Container();

        return new ContainerAwareEventDispatcher($container);
    }

    public function testAddAListenerService()
    {
        $event = new Event();

<<<<<<< HEAD
        $service = $this->getMock('Symfony\Component\EventDispatcher\Tests\Service');
=======
        $service = $this->getMockBuilder('Symfony\Component\EventDispatcher\Tests\Service')->getMock();
>>>>>>> git-aline/master/master

        $service
            ->expects($this->once())
            ->method('onEvent')
            ->with($event)
        ;

        $container = new Container();
        $container->set('service.listener', $service);

        $dispatcher = new ContainerAwareEventDispatcher($container);
        $dispatcher->addListenerService('onEvent', array('service.listener', 'onEvent'));

        $dispatcher->dispatch('onEvent', $event);
    }

    public function testAddASubscriberService()
    {
        $event = new Event();

<<<<<<< HEAD
        $service = $this->getMock('Symfony\Component\EventDispatcher\Tests\SubscriberService');
=======
        $service = $this->getMockBuilder('Symfony\Component\EventDispatcher\Tests\SubscriberService')->getMock();
>>>>>>> git-aline/master/master

        $service
            ->expects($this->once())
            ->method('onEvent')
            ->with($event)
        ;

<<<<<<< HEAD
=======
        $service
            ->expects($this->once())
            ->method('onEventWithPriority')
            ->with($event)
        ;

        $service
            ->expects($this->once())
            ->method('onEventNested')
            ->with($event)
        ;

>>>>>>> git-aline/master/master
        $container = new Container();
        $container->set('service.subscriber', $service);

        $dispatcher = new ContainerAwareEventDispatcher($container);
        $dispatcher->addSubscriberService('service.subscriber', 'Symfony\Component\EventDispatcher\Tests\SubscriberService');

        $dispatcher->dispatch('onEvent', $event);
<<<<<<< HEAD
=======
        $dispatcher->dispatch('onEventWithPriority', $event);
        $dispatcher->dispatch('onEventNested', $event);
>>>>>>> git-aline/master/master
    }

    public function testPreventDuplicateListenerService()
    {
        $event = new Event();

<<<<<<< HEAD
        $service = $this->getMock('Symfony\Component\EventDispatcher\Tests\Service');
=======
        $service = $this->getMockBuilder('Symfony\Component\EventDispatcher\Tests\Service')->getMock();
>>>>>>> git-aline/master/master

        $service
            ->expects($this->once())
            ->method('onEvent')
            ->with($event)
        ;

        $container = new Container();
        $container->set('service.listener', $service);

        $dispatcher = new ContainerAwareEventDispatcher($container);
        $dispatcher->addListenerService('onEvent', array('service.listener', 'onEvent'), 5);
        $dispatcher->addListenerService('onEvent', array('service.listener', 'onEvent'), 10);

        $dispatcher->dispatch('onEvent', $event);
    }

<<<<<<< HEAD
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testTriggerAListenerServiceOutOfScope()
    {
        $service = $this->getMock('Symfony\Component\EventDispatcher\Tests\Service');

        $scope = new Scope('scope');
        $container = new Container();
        $container->addScope($scope);
        $container->enterScope('scope');

        $container->set('service.listener', $service, 'scope');

        $dispatcher = new ContainerAwareEventDispatcher($container);
        $dispatcher->addListenerService('onEvent', array('service.listener', 'onEvent'));

        $container->leaveScope('scope');
        $dispatcher->dispatch('onEvent');
    }

    public function testReEnteringAScope()
    {
        $event = new Event();

        $service1 = $this->getMock('Symfony\Component\EventDispatcher\Tests\Service');

        $service1
            ->expects($this->exactly(2))
            ->method('onEvent')
            ->with($event)
        ;

        $scope = new Scope('scope');
        $container = new Container();
        $container->addScope($scope);
        $container->enterScope('scope');

        $container->set('service.listener', $service1, 'scope');

        $dispatcher = new ContainerAwareEventDispatcher($container);
        $dispatcher->addListenerService('onEvent', array('service.listener', 'onEvent'));
        $dispatcher->dispatch('onEvent', $event);

        $service2 = $this->getMock('Symfony\Component\EventDispatcher\Tests\Service');

        $service2
            ->expects($this->once())
            ->method('onEvent')
            ->with($event)
        ;

        $container->enterScope('scope');
        $container->set('service.listener', $service2, 'scope');

        $dispatcher->dispatch('onEvent', $event);

        $container->leaveScope('scope');

        $dispatcher->dispatch('onEvent');
    }

=======
>>>>>>> git-aline/master/master
    public function testHasListenersOnLazyLoad()
    {
        $event = new Event();

<<<<<<< HEAD
        $service = $this->getMock('Symfony\Component\EventDispatcher\Tests\Service');
=======
        $service = $this->getMockBuilder('Symfony\Component\EventDispatcher\Tests\Service')->getMock();
>>>>>>> git-aline/master/master

        $container = new Container();
        $container->set('service.listener', $service);

        $dispatcher = new ContainerAwareEventDispatcher($container);
        $dispatcher->addListenerService('onEvent', array('service.listener', 'onEvent'));

<<<<<<< HEAD
        $event->setDispatcher($dispatcher);
        $event->setName('onEvent');

=======
>>>>>>> git-aline/master/master
        $service
            ->expects($this->once())
            ->method('onEvent')
            ->with($event)
        ;

        $this->assertTrue($dispatcher->hasListeners());

        if ($dispatcher->hasListeners('onEvent')) {
            $dispatcher->dispatch('onEvent');
        }
    }

    public function testGetListenersOnLazyLoad()
    {
<<<<<<< HEAD
        $service = $this->getMock('Symfony\Component\EventDispatcher\Tests\Service');
=======
        $service = $this->getMockBuilder('Symfony\Component\EventDispatcher\Tests\Service')->getMock();
>>>>>>> git-aline/master/master

        $container = new Container();
        $container->set('service.listener', $service);

        $dispatcher = new ContainerAwareEventDispatcher($container);
        $dispatcher->addListenerService('onEvent', array('service.listener', 'onEvent'));

        $listeners = $dispatcher->getListeners();

<<<<<<< HEAD
        $this->assertTrue(isset($listeners['onEvent']));
=======
        $this->assertArrayHasKey('onEvent', $listeners);
>>>>>>> git-aline/master/master

        $this->assertCount(1, $dispatcher->getListeners('onEvent'));
    }

    public function testRemoveAfterDispatch()
    {
<<<<<<< HEAD
        $service = $this->getMock('Symfony\Component\EventDispatcher\Tests\Service');
=======
        $service = $this->getMockBuilder('Symfony\Component\EventDispatcher\Tests\Service')->getMock();
>>>>>>> git-aline/master/master

        $container = new Container();
        $container->set('service.listener', $service);

        $dispatcher = new ContainerAwareEventDispatcher($container);
        $dispatcher->addListenerService('onEvent', array('service.listener', 'onEvent'));

        $dispatcher->dispatch('onEvent', new Event());
        $dispatcher->removeListener('onEvent', array($container->get('service.listener'), 'onEvent'));
        $this->assertFalse($dispatcher->hasListeners('onEvent'));
    }

    public function testRemoveBeforeDispatch()
    {
<<<<<<< HEAD
        $service = $this->getMock('Symfony\Component\EventDispatcher\Tests\Service');
=======
        $service = $this->getMockBuilder('Symfony\Component\EventDispatcher\Tests\Service')->getMock();
>>>>>>> git-aline/master/master

        $container = new Container();
        $container->set('service.listener', $service);

        $dispatcher = new ContainerAwareEventDispatcher($container);
        $dispatcher->addListenerService('onEvent', array('service.listener', 'onEvent'));

        $dispatcher->removeListener('onEvent', array($container->get('service.listener'), 'onEvent'));
        $this->assertFalse($dispatcher->hasListeners('onEvent'));
    }
}

class Service
{
    public function onEvent(Event $e)
    {
    }
}

class SubscriberService implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
<<<<<<< HEAD
            'onEvent' => array('onEvent'),
=======
            'onEvent' => 'onEvent',
            'onEventWithPriority' => array('onEventWithPriority', 10),
            'onEventNested' => array(array('onEventNested')),
>>>>>>> git-aline/master/master
        );
    }

    public function onEvent(Event $e)
    {
    }
<<<<<<< HEAD
=======

    public function onEventWithPriority(Event $e)
    {
    }

    public function onEventNested(Event $e)
    {
    }
>>>>>>> git-aline/master/master
}
