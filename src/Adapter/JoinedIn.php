<?php
/**
 * Created by PhpStorm.
 * User: elstamey
 * Date: 10/30/15
 * Time: 10:03 PM
 */

namespace Phergie\Irc\Plugin\React\Cfp\Adapter;


class JoinedIn extends AbstractAdapter
{
    /**
     * Get the URL for the API Request
     *
     * @param $url
     * @return string
     */
    public function getApiUrl($url)
    {
        return 'http://api.joind.in';
    }

    /**
     * Parse the reply
     *
     * @param $data
     * @param $headers
     * @param $code
     * @return string|false
     */
    public function handleResponse($data, $headers, $code)
    {
        if ($code == 201) {
            return $data;
        }
        return false;
    }
}