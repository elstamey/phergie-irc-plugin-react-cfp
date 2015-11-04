<?php
/**
 * Phergie plugin for To list the currently open calls for papers (https://github.com/elstamey/phergie-irc-plugin-react-cfp)
 *
 * @link https://github.com/elstamey/phergie-irc-plugin-react-cfp for the canonical source repository
 * @copyright Copyright (c) 2015 Emily Stamey (http://phergie.org)
 * @license http://phergie.org/license Simplified BSD License
 * @package Phergie\Irc\Plugin\React\Cfp
 */

namespace Phergie\Irc\Plugin\React\Cfp\Adapter;

use React\Promise\Deferred;
use Phergie\Plugin\Http\Request;

abstract class AbstractAdapter
{
    /**
     * Get the URL for the API Request
     *
     * @return string
     */
    public abstract function getApiUrl();

    /**
     * Create the API Request
     *
     * @param string $apiUrl
     * @param $event
     * @param $queue
     *
     * @return Request
     */
    public function getApiRequest($apiUrl, $event, $queue)
    {
        $request = new Request([
            'url' => $apiUrl,
            'resolveCallback' =>
                function ($data) use ($event, $queue) {
                    $cfps = $this->handleResponse($data);
                    if (count($cfps) > 0) {
                        $queue->ircPrivmsg($event->getSource(), $cfps);
                    }
                },
            'method' => 'GET',
            'rejectCallback' =>
                function ($response) use ($event, $queue) {
                    $this->getLogger()->notice('[JoindIn] Site failed to respond');
                    $queue->ircPrivmsg($event->getSource(), 'Sorry, there was a problem communicating with the CFP site');
                },
        ]);

        return $this->getEventEmitter()->emit('http.request',[$request]);
    }

    /**
     * Parse the reply
     *
     * @param $data
     * @param $headers
     * @param $code
     * @return string|false
     */
    public abstract function handleResponse($data, $headers, $code);
}