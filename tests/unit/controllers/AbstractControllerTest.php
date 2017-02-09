<?php

namespace testS\tests\unit\controllers;

use testS\components\Language;
use testS\tests\unit\AbstractUnitTest;

/**
 * Class AbstractControllerTest
 *
 * @package testS\tests\unit\controllers
 */
abstract class AbstractControllerTest extends AbstractUnitTest
{

    /**
     * User agents
     */
    const UA_MOZILLA_50 = "User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:2.0.1) Gecko/20100101 Firefox/4.0.1";

    /**
     * Default token
     */
    const DEFAULT_TOKEN = "defaultToken";

    /**
     * Response code
     *
     * @var int
     */
    private $_statusCode = 0;

    /**
     * Gets status code
     *
     * @return int
     */
    protected function getStatusCode()
    {
        return $this->_statusCode;
    }

    /**
     * Gets response
     *
     * @param string $controller
     * @param string $action
     * @param array  $data
     * @param string $method
     * @param string $token
     * @param int    $language
     * @param string $ua
     *
     * @return mixed
     */
    protected function getResponse(
        $controller,
        $action,
        array $data = [],
        $method = "GET",
        $token = self::DEFAULT_TOKEN,
        $language = Language::LANGUAGE_EN_ID,
        $ua = self::UA_MOZILLA_50
    )
    {
        $host = trim(shell_exec("/sbin/ip route|awk '/default/ { print $3 }'"));

        $dataJson = json_encode(
            [
                "token"      => $token,
                "controller" => $controller,
                "action"     => $action,
                "language"   => $language,
                "data"       => $data
            ]
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $host . "/api/");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt(
            $curl,
            CURLOPT_POSTFIELDS,
            json_encode(
                [
                    "token"      => $token,
                    "controller" => $controller,
                    "action"     => $action,
                    "language"   => $language,
                    "data"       => $data
                ]
            )
        );
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($dataJson),
                "X-Requested-With: XMLHttpRequest",
                "User-Agent: " . $ua,
            ]
        );

        $body = curl_exec($curl);
        $info = curl_getinfo($curl);
        $this->_statusCode = $info["http_code"];

        return json_decode($body, true);
    }
}