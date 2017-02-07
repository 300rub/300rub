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

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $host . "/aaa/aa");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");


        $data = [
            "sid" => "aaa"
        ];
        $dataString = json_encode($data);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $dataString);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($dataString))
        );

        $body = curl_exec($curl);
        $info = curl_getinfo($curl);
        $code = $info["http_code"];
        $type = $info["content_type"];

        var_dump($code);
        var_dump($type);
        var_dump($body);

        exit();
    }
}