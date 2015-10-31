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
use WyriHaximus\React\Guzzle\HttpClient\Request;

abstract class AbstractAdapter
{
    /**
     * Get the URL for the API Request
     *
     * @param $url
     * @return string
     */
    public abstract function getApiUrl($url);

    /**
     * Create the API Request
     *
     * @param string $apiUrl
     * @param Deferred $deferred
     * @return Request
     */
    public function getApiRequest($apiUrl, $deferred)
    {
        return new Request([
            'url' => $apiUrl,
            'resolveCallback' =>
                function ($data, $headers, $code) use ($deferred) {
                    $cfps = $this->handleResponse($data, $headers, $code);
                    if ($cfps === false) {
                        $deferred->reject();
                    } else {
                        $deferred->resolve($cfps);
                    }
                },
            'rejectCallback' => [$deferred, 'reject']
        ]);
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