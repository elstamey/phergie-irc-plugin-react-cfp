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
     * @return string
     */
    public function getApiUrl()
    {
        return 'http://api.joind.in/v2.1/events?filter=cfp';
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
        foreach ($data as $d) {
            die(var_dump($d));
        }
        if ($code == 201) {
            return $data;
        }
        return false;
    }
}