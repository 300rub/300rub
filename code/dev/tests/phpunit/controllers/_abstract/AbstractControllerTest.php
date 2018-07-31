<?php

namespace ss\tests\phpunit\controllers\_abstract;

use ss\application\App;
use ss\application\components\Language;
use ss\tests\phpunit\_abstract\AbstractUnitTest;

/**
 * Abstract class to work with controller tests
 */
abstract class AbstractControllerTest extends AbstractUnitTest
{

    /**
     * Cookie path
     */
    const COOKIE_PATH = '/tmp/cookie';

    /**
     * User types
     */
    const TYPE_OWNER = 'owner';
    const TYPE_FULL = 'admin';
    const TYPE_LIMITED = 'user';
    const TYPE_NO_OPERATIONS_USER = 'user_no_operation';
    const TYPE_BLOCKED_USER = 'blocked_user';

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
     * @var integer
     */
    private $_statusCode = 0;

    /**
     * Request body
     *
     * @var array
     */
    private $_body;

    /**
     * File data
     *
     * @var array
     */
    private $_fileData = [];

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
     * @param string $type      User type
     * @param string $token     Token
     * @param string $sessionId Session ID
     *
     * @return AbstractControllerTest
     */
    protected function setUser(
        $type = self::TYPE_OWNER,
        $token = '',
        $sessionId = ''
    ) {
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

        if ($token !== '') {
            $this->_userToken = $token;
        }

        if ($sessionId !== '') {
            $this->_userSessionId = $sessionId;
        }

        return $this;
    }

    /**
     * Gets host
     *
     * @return string
     */
    protected function getHost()
    {
        return sprintf(
            'phpunit.%s',
            App::getInstance()->getConfig()->getValue(['host'])
        );
    }

    /**
     * Sends a file
     *
     * @param string $group      Group
     * @param string $controller Controller
     * @param string $fileName   File name
     * @param array  $data       Data
     * @param string $mimeType   Mime type
     * @param int    $language   Language ID
     *
     * @return AbstractControllerTest
     */
    protected function sendFile(
        $group,
        $controller,
        $fileName,
        array $data = [],
        $mimeType = 'application/octet-stream',
        $language = Language::LANGUAGE_EN_ID
    ) {
        $host = $this->getHost();

        $this->_setFileData($data);
        $postData = [
            'token'      => $this->getUserToken(),
            'group'      => $group,
            'controller' => $controller,
            'language'   => $language,
            'file'       => curl_file_create(
                CODE_ROOT . '/fixtures/files/' . $fileName,
                $mimeType
            )
        ];
        $postData = array_merge($postData, $this->_fileData);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $host . '/api/');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            [
                'Content-type: multipart/form-data',
                'X-Requested-With: XMLHttpRequest'
            ]
        );

        $body = curl_exec($curl);
        $info = curl_getinfo($curl);

        $this->_statusCode = $info['http_code'];
        $this->_body = json_decode($body, true);

        return $this;
    }

    /**
     * Sets file data
     *
     * @param array  $data   Data
     * @param string $prefix Prefix
     *
     * @return AbstractControllerTest
     */
    private function _setFileData(array $data, $prefix = 'data')
    {
        foreach ($data as $key => $value) {
            if (is_array($value) === true) {
                $this->_setFileData($value, sprintf('%s[%s]', $prefix, $key));
                continue;
            }

            $this->_fileData[sprintf('%s[%s]', $prefix, $key)] = $value;
        }

        return $this;
    }

    /**
     * Gets response
     *
     * @param string $group      Group
     * @param string $controller Controller
     * @param array  $data       Data
     * @param string $method     HTTP Method
     * @param int    $language   Language ID
     * @param string $userAgent  User Agent
     *
     * @return AbstractControllerTest
     */
    protected function sendRequest(
        $group,
        $controller,
        array $data = [],
        $method = 'GET',
        $language = Language::LANGUAGE_EN_ID,
        $userAgent = self::UA_FIREFOX_4_0_1
    ) {
        $host = $this->getHost();

        $dataJson = [
            'token'      => $this->getUserToken(),
            'group'      => $group,
            'controller' => $controller,
            'language'   => $language,
            'data'       => $data
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

        $host = $host . '/api/';
        if ($method === 'GET') {
            $query = http_build_query($dataJson);
            $host .= '?' . $query;
        }

        curl_setopt($curl, CURLOPT_URL, $host);

        $headers = [
            'User-Agent: ' . $userAgent,
        ];
        if ($method !== 'GET') {
            $headers[] = 'Content-Type: application/json';
        }

        $headers[] = 'X-Requested-With: XMLHttpRequest';

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        if ($method !== 'GET') {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($dataJson));
        }

        $this->_removeCookie();
        if ($this->_userSessionId !== null) {
            $cookie = sprintf(
                '%s=%s',
                session_name(),
                $this->_userSessionId
            );
            curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }

        curl_setopt($curl, CURLOPT_COOKIESESSION, true);
        curl_setopt($curl, CURLOPT_COOKIEJAR, self::COOKIE_PATH);
        curl_setopt($curl, CURLOPT_COOKIEFILE, self::COOKIE_PATH);

        $body = curl_exec($curl);
        $info = curl_getinfo($curl);

        $this->_statusCode = $info['http_code'];
        $this->_body = json_decode($body, true);

        return $this;
    }

    /**
     * Removes cookie
     *
     * @return void
     */
    private function _removeCookie()
    {
        if (file_exists(self::COOKIE_PATH) === true) {
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
        if (file_exists(self::COOKIE_PATH) === false) {
            return null;
        }

        $cookieFile = fopen(self::COOKIE_PATH, 'r');
        $cookieContent = fread($cookieFile, filesize(self::COOKIE_PATH));
        fclose($cookieFile);

        preg_match(
            '/' . session_name() . '	([a-z0-9]+)/',
            $cookieContent,
            $matches,
            PREG_OFFSET_CAPTURE
        );
        if (empty($matches[1][0]) === true) {
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
        if (file_exists(self::COOKIE_PATH) === false) {
            return null;
        }

        $cookieFile = fopen(self::COOKIE_PATH, 'r');
        $cookieContent = fread($cookieFile, filesize(self::COOKIE_PATH));
        fclose($cookieFile);

        preg_match(
            '/token	([a-z0-9]+)/',
            $cookieContent,
            $matches,
            PREG_OFFSET_CAPTURE
        );
        if (empty($matches[1][0]) === true) {
            return null;
        }

        return $matches[1][0];
    }

    /**
     * Asserts an error in body response
     *
     * @return void
     */
    protected function assertError()
    {
        $this->assertArrayHasKey('error', $this->getBody());
    }

    /**
     * Asserts an errors in body response
     *
     * @return void
     */
    protected function assertErrors()
    {
        $this->assertArrayHasKey('errors', $this->getBody());
    }
}
