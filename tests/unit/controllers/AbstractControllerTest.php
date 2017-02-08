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
        curl_setopt($curl, CURLOPT_URL, $host . "/api/");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");

        $data = [
            "token"      => "guest",
            "controller" => "text",
            "action"     => "block",
            "language"   => 1,
            "data"       => []
        ];
        $dataString = json_encode($data);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $dataString);
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($dataString),
                "X-Requested-With: XMLHttpRequest",
                "User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:2.0.1) Gecko/20100101 Firefox/4.0.1",
            ]
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