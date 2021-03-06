<?php

namespace ss\controllers\page;

use ss\application\App;
use ss\controllers\page\_abstract\AbstractPageController;

/**
 * Error controller to display error message
 */
class ErrorController extends AbstractPageController
{

    /**
     * Code
     *
     * @var integer
     */
    private $_code = 0;

    /**
     * Message
     *
     * @var string
     */
    private $_message = '';

    /**
     * File
     *
     * @var string
     */
    private $_file = '';

    /**
     * Line
     *
     * @var string
     */
    private $_line = '';

    /**
     * Backtrace
     *
     * @var array
     */
    private $_backtrace = [];

    /**
     * Sets code
     *
     * @param string $code Code
     *
     * @return ErrorController
     */
    public function setCode($code)
    {
        switch ($code) {
            case 204:
                $code = 204;
                break;
            case 400:
                $code = 400;
                break;
            case 404:
                $code = 404;
                break;
            case 403:
                $code = 403;
                break;
            default:
                $code = 500;
                break;
        }

        $this->_code = $code;
        return $this;
    }

    /**
     * Sets message
     *
     * @param string $message Message
     *
     * @return ErrorController
     */
    public function setMessage($message)
    {
        $this->_message = $message;

        if (APP_ENV !== ENV_DEV) {
            $this->_message = App::getInstance()
                ->getLanguage()
                ->getMessage('error', $this->_code);
        }

        return $this;
    }

    /**
     * Sets file
     *
     * @param string $file File
     *
     * @return ErrorController
     */
    public function setFile($file)
    {
        $this->_file = $file;
        return $this;
    }

    /**
     * Sets line
     *
     * @param string $line Line
     *
     * @return ErrorController
     */
    public function setLine($line)
    {
        $this->_line = $line;
        return $this;
    }

    /**
     * Sets Backtrace
     *
     * @param array $backtrace Backtrace
     *
     * @return ErrorController
     */
    public function setBacktrace($backtrace)
    {
        $this->_backtrace = $backtrace;
        return $this;
    }

    /**
     * Gets login page
     *
     * @return string
     */
    public function run()
    {
        http_response_code($this->_code);

        $isDev = false;
        if (APP_ENV === ENV_DEV) {
            $isDev = true;
        }

        return $this->render(
            'layout/error',
            [
                'icon'      => '/static/common/core/img/favicon.ico',
                'isDev'     => $isDev,
                'css'       => $this->getCss(),
                'less'      => $this->getLess(),
                'code'      => $this->_code,
                'message'   => $this->_message,
                'file'      => $this->_file,
                'line'      => $this->_line,
                'backtrace' => $this->_backtrace,
            ]
        );
    }
}
