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
}
