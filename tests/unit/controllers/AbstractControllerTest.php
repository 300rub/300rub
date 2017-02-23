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
     * Session IDs
     */
    const SESSION_ID_DEFAULT = "session1c2c128f53f550c5ccbf2115b";

    /**
     * Cookie path
     */
    const COOKIE_PATH = "/tmp/cookie";

    /**
     * Response code
     *
     * @var int
     */
    private $_statusCode = 0;

    /**
     * Request body
     *
     * @var array
     */
    private $_body;

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
     * Gets body
     *
     * @return array
     */
    protected function getBody()
    {
        return $this->_body;
    }

    /**
     * Gets response
     *
     * @param string $controller
     * @param string $action
     * @param array  $data
     * @param string $method
     * @param string $token
     * @param string $sessionId
     * @param int    $language
     * @param string $ua
     *
     * @return AbstractControllerTest
     */
    protected function sendRequest(
        $controller,
        $action,
        array $data = [],
        $method = "GET",
        $token = self::TOKEN_USER,
        $sessionId = self::SESSION_ID_DEFAULT,
        $language = Language::LANGUAGE_EN_ID,
        $ua = self::UA_FIREFOX_4_0_1
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
        if ($sessionId !== null) {
            curl_setopt($curl, CURLOPT_COOKIE, sprintf("%s=%s", session_name(), $sessionId));
        }

        curl_setopt($curl, CURLOPT_COOKIESESSION, true);
        curl_setopt($curl, CURLOPT_COOKIEJAR, self::COOKIE_PATH);
        curl_setopt($curl, CURLOPT_COOKIEFILE, self::COOKIE_PATH);

        $body = curl_exec($curl);
        $info = curl_getinfo($curl);

        $this->_statusCode = $info["http_code"];
        $this->_body = json_decode($body, true);

        return $this;
    }

    /**
     * Removes cookie
     */
    protected function removeCookie()
    {
        if (file_exists(self::COOKIE_PATH)) {
            unlink(self::COOKIE_PATH);
        }
    }

    /**
     * Gets SessionId from cookies
     *
     * @return string|null
     */
    protected function getSessionIdFromCookie()
    {
        if (!file_exists(self::COOKIE_PATH)) {
            return null;
        }

        $cookieFile = fopen(self::COOKIE_PATH, "r");
        $cookieContent = fread($cookieFile, filesize(self::COOKIE_PATH));
        fclose($cookieFile);

        preg_match('/' . session_name() . '	([a-z0-9]+)/', $cookieContent, $matches, PREG_OFFSET_CAPTURE);
        if (empty($matches[1][0])) {
            return null;
        }

        return $matches[1][0];
    }

    /**
     * Gets token from cookies
     *
     * @return string|null
     */
    protected function getTokenFromCookie()
    {
        if (!file_exists(self::COOKIE_PATH)) {
            return null;
        }

        $cookieFile = fopen(self::COOKIE_PATH, "r");
        $cookieContent = fread($cookieFile, filesize(self::COOKIE_PATH));
        fclose($cookieFile);

        preg_match('/token	([a-z0-9]+)/', $cookieContent, $matches, PREG_OFFSET_CAPTURE);
        if (empty($matches[1][0])) {
            return null;
        }

        return $matches[1][0];
    }
}