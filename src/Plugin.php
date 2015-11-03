<?php
/**
 * Phergie plugin for To list the currently open calls for papers (https://github.com/elstamey/phergie-irc-plugin-react-cfp)
 *
 * @link https://github.com/elstamey/phergie-irc-plugin-react-cfp for the canonical source repository
 * @copyright Copyright (c) 2015 Emily Stamey (http://phergie.org)
 * @license http://phergie.org/license Simplified BSD License
 * @package Phergie\Irc\Plugin\React\Cfp
 */

namespace Phergie\Irc\Plugin\React\Cfp;

use Phergie\Irc\Bot\React\AbstractPlugin;
use Phergie\Irc\Bot\React\EventQueueInterface as Queue;
use Phergie\Irc\Plugin\React\Cfp\Adapter\JoinedIn;
use Phergie\Irc\Plugin\React\Command\CommandEvent as Event;

/**
 * Plugin class.
 *
 * @category Phergie
 * @package Phergie\Irc\Plugin\React\Cfp
 */
class Plugin extends AbstractPlugin
{
    /**
     * Accepts plugin configuration.
     *
     * Supported keys:
     *
     *
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {

    }

    /**
     *
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            'command.cfp' => 'handleCfpCommand',
            'command.cfp.help' => 'handleCfpHelp',
        ];
    }

    /**
     *
     * @param \Phergie\Irc\Plugin\React\Command\CommandEvent $event
     * @param \Phergie\Irc\Bot\React\EventQueueInterface $queue
     *
     */
    public function handleCfpCommand(Event $event, Queue $queue)
    {
        $channel = $event->getSource();
        $params = $event->getCustomParams();

        if ($params[0] = "help") {
            $this->handleCfpHelp($event, $queue);
            $msgString = "";
        } else {
            $msgString = $this->fetchCfp($event, $queue, $event->getCustomParams());
        }

        $queue->ircPrivmsg($channel, $msgString);
    }

    /**
     * Cfp Command Help
     *
     * @param \Phergie\Irc\Plugin\React\Command\CommandEvent $event
     * @param \Phergie\Irc\Bot\React\EventQueueInterface $queue
     */
    public function handleCfpHelp(Event $event, Queue $queue)
    {
        $this->sendHelpReply($event, $queue, [
            'Usage: cfp ',
            'parameters - for now there are no implemented parameters for cfp to modify the request)',
            'Instructs the bot to return a list of open Calls for Papers.',
        ]);
    }

    /**
     * @param $event
     * @param $queue
     * @param array $params
     *
     * @return \WyriHaximus\React\Guzzle\HttpClient\Request
     */
    public function fetchCfp($event, $queue, $params=array())
    {
        if (count( $params ) > 1) {
            echo "handle these parameters";
        }

        $this->adapter = new JoinedIn();

        $cfps = $this->adapter->getApiRequest(
            $this->adapter->getApiUrl(),
            $event,
            $queue
        );


        $this->getEventEmitter()->emit('http.request',[$cfps]);

    }

    /**
     * Responds to a help command.
     *
     * @param \Phergie\Irc\Plugin\React\Command\CommandEvent $event
     * @param \Phergie\Irc\Bot\React\EventQueueInterface $queue
     * @param array $messages
     */
    protected function sendHelpReply(Event $event, Queue $queue, array $messages)
    {
        $method = 'irc' . $event->getCommand();
        $target = $event->getSource();
        foreach ($messages as $message) {
            $queue->$method($target, $message);
        }
    }
}
