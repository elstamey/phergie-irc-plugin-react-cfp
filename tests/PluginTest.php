<?php
/**
 * Phergie plugin for To list the currently open calls for papers (https://github.com/elstamey/phergie-irc-plugin-react-cfp)
 *
 * @link https://github.com/elstamey/phergie-irc-plugin-react-cfp for the canonical source repository
 * @copyright Copyright (c) 2015 Emily Stamey (http://phergie.org)
 * @license http://phergie.org/license Simplified BSD License
 * @package Phergie\Irc\Plugin\React\Cfp
 */

namespace Phergie\Irc\Tests\Plugin\React\Cfp;

use Phake;
use Phergie\Irc\Bot\React\EventQueueInterface as Queue;
use Phergie\Irc\Plugin\React\Command\CommandEvent as Event;
use Phergie\Irc\Plugin\React\Cfp\Plugin;

/**
 * Tests for the Plugin class.
 *
 * @category Phergie
 * @package Phergie\Irc\Plugin\React\Cfp
 */
class PluginTest extends \PHPUnit_Framework_TestCase
{


    /**
     * Tests that getSubscribedEvents() returns an array.
     */
    public function testGetSubscribedEvents()
    {
        $plugin = new Plugin;
        $this->assertInternalType('array', $plugin->getSubscribedEvents());
    }

    /**
     * Tests handleCfpCommand().
     */
    public function testHandleCfpCommand()
    {
        $event = $this->getMockCommandEvent();
        $queue = $this->getMockEventQueue();
        $plugin = new Plugin;

        Phake::when($event)->getSource()->thenReturn('#channel1');
        Phake::when($event)->getCommand()->thenReturn('PRIVMSG');

        $plugin->handleCfpCommand($event, $queue);
        Phake::when($event)->getCustomParams()->thenReturn(array('#channel1'));

        Phake::verify($queue, Phake::atLeast(1))->ircPrivmsg('#channel1', $this->isType('string'));
    }

    public function testFetchCfp()
    {
        $event = $this->getMockCommandEvent();
        $queue = $this->getMockEventQueue();
        $method = new \ReflectionMethod(
            'Phergie\Irc\Plugin\React\Cfp\Plugin', 'fetchCfp'
        );
        $method->setAccessible(TRUE);

        $this->assertEquals(
            'some CFPs from the API',
            $method->invoke(new Plugin(), $event, $queue, array('php'))
        );
    }

    /**
     * Tests handleCfpHelp().
     *
     * @param string $method
     * @dataProvider dataProviderHandleHelp
     */
    public function testHandleCfpHelp($method)
    {
        $event = $this->getMockCommandEvent();

        Phake::when($event)->getCustomParams()->thenReturn(array());
        Phake::when($event)->getSource()->thenReturn('#channel');
        Phake::when($event)->getCommand()->thenReturn('PRIVMSG');
        $queue = $this->getMockEventQueue();

        $plugin = new Plugin;
        $plugin->$method($event, $queue);

        Phake::verify($queue, Phake::atLeast(1))
             ->ircPrivmsg('#channel', $this->isType('string'));
    }

    /**
     * Returns a mock command event
     *
     * @return \Phergie\Irc\Plugin\React\Command\CommandEvent
     */
    private function getMockCommandEvent()
    {
        return Phake::mock('Phergie\Irc\Plugin\React\Command\CommandEvent');
    }

    /**
     * Returns a mock event queue.
     *
     * @return \Phergie\Irc\Bot\React\EventQueueInterface
     */
    protected function getMockEventQueue()
    {
        return Phake::mock('Phergie\Irc\Bot\React\EventQueueInterface');
    }

    /**
     * Data provider for testHandleHelp().
     *
     * @return array
     */
    public function dataProviderHandleHelp()
    {
        $data = array();
        $methods = array(
            'handleCfpHelp',
        );
        foreach ($methods as $method) {
            $data[] = array($method);
        }
        return $data;
    }
}
