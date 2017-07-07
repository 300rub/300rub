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
     * Cookie path
     */
    const COOKIE_PATH = "/tmp/cookie";

    /**
     * User types
     */
    const TYPE_OWNER = "owner";
    const TYPE_FULL = "admin";
    const TYPE_LIMITED = "user";
    const TYPE_NO_OPERATIONS_USER = "user_no_operation";
    const TYPE_BLOCKED_USER = "blocked_user";

    /**
     * User session ID
     *
     * @var string
     */
    private $_userSessionId = self::SESSION_ID_OWNER;

    /**
     * User token
     *
     * @var string
     */
    private $_userToken = self::TOKEN_OWNER;

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
     * Gets user token
     *
     * @return string
     */
    protected function getUserToken()
    {
        return $this->_userToken;
    }

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
     * Sets User
     *
     * @param string $type
     * @param string $token
     * @param string $sessionId
     *
     * @return AbstractControllerTest
     */
    protected function setUser($type = self::TYPE_OWNER, $token = "", $sessionId = "")
    {
        switch ($type) {
            case self::TYPE_OWNER:
                $this->_userSessionId = self::SESSION_ID_OWNER;
                $this->_userToken = self::TOKEN_OWNER;
                break;
            case self::TYPE_FULL:
                $this->_userSessionId = self::SESSION_ID_FULL;
                $this->_userToken = self::TOKEN_FULL;
                break;
            case self::TYPE_LIMITED:
                $this->_userSessionId = self::SESSION_ID_LIMITED;
                $this->_userToken = self::TOKEN_LIMITED;
                break;
            case self::TYPE_NO_OPERATIONS_USER:
                $this->_userSessionId = self::SESSION_NO_OPERATION_USER;
                $this->_userToken = self::TOKEN_NO_OPERATION_USER;
                break;
            case self::TYPE_BLOCKED_USER:
                $this->_userSessionId = self::SESSION_BLOCKED_USER;
                $this->_userToken = self::TOKEN_BLOCKED_USER;
                break;
            default:
                $this->_userSessionId = null;
                $this->_userToken = null;
                break;
        }

        if ($token !== "") {
            $this->_userToken = $token;
        }

        if ($sessionId !== "") {
            $this->_userSessionId = $sessionId;
        }

        return $this;
    }

    /**
     * Gets response
     *
     * @param string $controller
     * @param string $action
     * @param array  $data
     * @param string $method
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
        $language = Language::LANGUAGE_EN_ID,
        $ua = self::UA_FIREFOX_4_0_1
    )
    {
        $host = trim(shell_exec("/sbin/ip route|awk '/default/ { print $3 }'"));

        $dataJson = [
            "token"      => $this->getUserToken(),
            "controller" => $controller,
            "action"     => $action,
            "language"   => $language,
            "data"       => $data
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

        if ($method === "GET") {
            $query = http_build_query($dataJson);
            curl_setopt($curl, CURLOPT_URL, $host . "/api/?" . $query);
            curl_setopt(
                $curl,
                CURLOPT_HTTPHEADER,
                [
                    "User-Agent: " . $ua,
                ]
            );
        } else {
            curl_setopt($curl, CURLOPT_URL, $host . "/api/");
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($dataJson));
            curl_setopt(
                $curl,
                CURLOPT_HTTPHEADER,
                [
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen(json_encode($dataJson)),
                    "X-Requested-With: XMLHttpRequest",
                    "User-Agent: " . $ua,
                ]
            );
        }

        if ($this->_userSessionId !== null) {
            curl_setopt($curl, CURLOPT_COOKIE, sprintf("%s=%s", session_name(), $this->_userSessionId));
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

    /**
     * Asserts an error in body response
     */
    protected function assertError()
    {
        $this->assertArrayHasKey("error", $this->getBody());
    }

    /**
     * Asserts an errors in body response
     */
    protected function assertErrors()
    {
        $this->assertArrayHasKey("errors", $this->getBody());
    }
}