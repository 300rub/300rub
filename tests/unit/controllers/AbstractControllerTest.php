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
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://127.0.0.1/');
        $result = curl_exec($curl);
        var_dump($result);
    }
}