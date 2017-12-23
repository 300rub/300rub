<?php

namespace testS\application\components;

/**
 * Class to work with super-global variables
 */
class SuperGlobalVariable
{

    /**
     * Post file name
     */
    const POST_FILE_NAME = 'file';

    /**
     * Gets $_SERVER value by key
     *
     * @param string $key Server key
     *
     * @return mixed|null
     *
     * @SuppressWarnings(PMD.Superglobals)
     */
    public function getServerValue($key)
    {
        if (array_key_exists($key, $_SERVER) === true) {
            return $_SERVER[$key];
        }

        return null;
    }

    /**
     * Gets $_POST value by key
     *
     * @param string $key POST key
     *
     * @return mixed|null
     *
     * @SuppressWarnings(PMD.Superglobals)
     */
    public function getPostValue($key = null)
    {
        if ($key === null) {
            return $_POST;
        }

        if (array_key_exists($key, $_POST) === true) {
            return $_POST[$key];
        }

        return null;
    }

    /**
     * Gets $_GET value by key
     *
     * @param string $key GET key
     *
     * @return mixed|null
     *
     * @SuppressWarnings(PMD.Superglobals)
     */
    public function getGetValue($key = null)
    {
        if ($key === null) {
            return $_GET;
        }

        if (array_key_exists($key, $_GET) === true) {
            return $_GET[$key];
        }

        return null;
    }

    /**
     * Gets $_FILES value by key
     *
     * @param string $key FILES key
     *
     * @return mixed|null
     *
     * @SuppressWarnings(PMD.Superglobals)
     */
    public function getFilesValue($key = null)
    {
        if ($key === null) {
            return $_FILES;
        }

        if (array_key_exists($key, $_FILES) === true) {
            return $_FILES[$key];
        }

        return null;
    }

    /**
     * Gets $_SESSION value by key
     *
     * @param string $key SESSION key
     *
     * @return mixed|null
     *
     * @SuppressWarnings(PMD.Superglobals)
     */
    public function getSessionValue($key)
    {
        if (array_key_exists($key, $_SESSION) === true) {
            return $_SESSION[$key];
        }

        return null;
    }

    /**
     * Sets $_SESSION value
     *
     * @param string $key   SESSION key
     * @param string $value SESSION value
     *
     * @return SuperGlobalVariable
     *
     * @SuppressWarnings(PMD.Superglobals)
     */
    public function setSessionValue($key, $value)
    {
        $_SESSION[$key] = $value;

        return $this;
    }

    /**
     * Gets $_COOKIE value by key
     *
     * @param string $key COOKIE key
     *
     * @return mixed|null
     *
     * @SuppressWarnings(PMD.Superglobals)
     */
    public function getCookieValue($key)
    {
        if (array_key_exists($key, $_COOKIE) === true) {
            return $_COOKIE[$key];
        }

        return null;
    }

    /**
     * Sets $_COOKIE value
     *
     * @param string $key   COOKIE  key
     * @param string $value COOKIE  value
     *
     * @return SuperGlobalVariable
     *
     * @SuppressWarnings(PMD.Superglobals)
     */
    public function setCookieValue($key, $value)
    {
        $_COOKIE[$key] = $value;

        return $this;
    }
}
