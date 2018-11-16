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

<<<<<<< HEAD
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;
=======
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\Event;
>>>>>>> git-aline/master/master

/**
 * Test class for Event.
 */
<<<<<<< HEAD
class EventTest extends \PHPUnit_Framework_TestCase
=======
class EventTest extends TestCase
>>>>>>> git-aline/master/master
{
    /**
     * @var \Symfony\Component\EventDispatcher\Event
     */
    protected $event;

    /**
<<<<<<< HEAD
     * @var \Symfony\Component\EventDispatcher\EventDispatcher
     */
    protected $dispatcher;

    /**
=======
>>>>>>> git-aline/master/master
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->event = new Event();
<<<<<<< HEAD
        $this->dispatcher = new EventDispatcher();
=======
>>>>>>> git-aline/master/master
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        $this->event = null;
<<<<<<< HEAD
        $this->dispatcher = null;
=======
>>>>>>> git-aline/master/master
    }

    public function testIsPropagationStopped()
    {
        $this->assertFalse($this->event->isPropagationStopped());
    }

    public function testStopPropagationAndIsPropagationStopped()
    {
        $this->event->stopPropagation();
        $this->assertTrue($this->event->isPropagationStopped());
    }
<<<<<<< HEAD

    /**
     * @group legacy
     */
    public function testLegacySetDispatcher()
    {
        $this->event->setDispatcher($this->dispatcher);
        $this->assertSame($this->dispatcher, $this->event->getDispatcher());
    }

    /**
     * @group legacy
     */
    public function testLegacyGetDispatcher()
    {
        $this->assertNull($this->event->getDispatcher());
    }

    /**
     * @group legacy
     */
    public function testLegacyGetName()
    {
        $this->assertNull($this->event->getName());
    }

    /**
     * @group legacy
     */
    public function testLegacySetName()
    {
        $this->event->setName('foo');
        $this->assertEquals('foo', $this->event->getName());
    }
=======
>>>>>>> git-aline/master/master
}
