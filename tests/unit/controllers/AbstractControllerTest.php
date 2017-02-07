<?php

namespace testS\tests\unit\controllers;

use testS\tests\unit\AbstractUnitTest;

/**
 * Class AbstractControllerTest
 *
 * @package testS\tests\unit\controllers
 */
abstract class AbstractControllerTest extends AbstractUnitTest
{

    protected function sendRequest()
    {
        $host = trim(shell_exec("/sbin/ip route|awk '/default/ { print $3 }'"));
        $curl = curl_init(); curl_setopt($curl, CURLOPT_URL, $host);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        var_dump($result);
        exit();
    }
}