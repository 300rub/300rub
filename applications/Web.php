<?php

namespace testS\applications;

use testS\components\Db;
use testS\components\exceptions\BadRequestException;
use Exception;
use testS\components\exceptions\ContentException;
use testS\components\User;

/**
 * Class for working with WEB application
 *
 * @package testS\application
 */
class Web extends AbstractApplication
{

    /**
     * HTTP Methods
     */
    const METHOD_GET = "GET";
    const METHOD_POST = "POST";
    const METHOD_PUT = "PUT";
    const METHOD_DELETE = "DELETE";

    /**
     * API url
     */
    const API_URL = "api";

    /**
     * Flag of using transaction
     *
     * @var bool
     */
    private $_useTransaction = false;

    /**
     * Runs application
     *
     * @return void
     */
    public function run()
    {
        try {
            if (trim($_SERVER["REQUEST_URI"], "/") === self::API_URL) {
                header('Content-Type: application/json');
                $output = $this->_getAjaxOutput();
            } else {
                $output = "not ajax";
            }
        } catch (Exception $e) {
            if ($this->_useTransaction === true) {
                Db::rollbackTransaction();
            }
            $output = $e->getMessage();
            http_response_code($e->getCode());
        }

        echo $output;
    }

    /**
     * Gets AJAX output
     *
     * @return string
     *
     * @throws BadRequestException
     * @throws ContentException
     */
    private function _getAjaxOutput()
    {
        $method = strtoupper($_SERVER['REQUEST_METHOD']);
        switch ($method) {
            case self::METHOD_GET:
                $actionPrefix = "get";
                $this->_useTransaction = false;
                break;
            case self::METHOD_POST:
                $actionPrefix = "update";
                $this->_useTransaction = true;
                break;
            case self::METHOD_PUT:
                $actionPrefix = "add";
                $this->_useTransaction = true;
                break;
            case self::METHOD_DELETE:
                $actionPrefix = "delete";
                $this->_useTransaction = true;
                break;
            default:
                throw new BadRequestException(
                    "AJAX request method: {method} is not allowed",
                    [
                        "method" => $method
                    ]
                );
        }
        if ($this->_useTransaction === true) {
            Db::startTransaction();
        }

        if (!array_key_exists("HTTP_X_REQUESTED_WITH", $_SERVER)
            || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== "xmlhttprequest"
        ) {
            throw new BadRequestException("Only AJAX request is allowed");
        }

        $input = json_decode(file_get_contents('php://input'));
        if (empty($input->token)
            || empty($input->controller)
            || empty($input->action)
            || empty($input->language)
            || !isset($input->data)
        ) {
            throw new BadRequestException(
                "Incorrect post data. Input: {input}",
                [
                    "input" => json_encode($input)
                ]
            );
        }

        $controllerClassName = sprintf("\\testS\\controllers\\%sController", ucfirst($input->controller));
        if (!class_exists($controllerClassName)) {
            throw new BadRequestException(
                "Class: {controllerClassName} doesn't exists",
                [
                    "controllerClassName" => $controllerClassName
                ]
            );
        }

        $controllerMethodName = sprintf("%s%s", $actionPrefix, ucfirst($input->action));
        $controller = new $controllerClassName;
        if (!method_exists($controller, $controllerMethodName)) {
            throw new BadRequestException(
                "Method: {methodName} doesn't exist in class: {className}",
                [
                    "methodName" => $controllerMethodName,
                    "className"  => $controllerClassName
                ]
            );
        }

        $this->_setUserByToken($input->token);

        $output = $controller->$controllerMethodName();
        if (!$output) {
            throw new ContentException(
                "Nothing to output. Input: {input}",
                [
                    "input" => json_encode($input)
                ]
            );
        }

        if ($this->_useTransaction === true) {
            Db::commitTransaction();
        }

        return json_encode($output);
    }

    /**
     * Sets User
     *
     * @param string $token
     *
     * @return Web
     */
    private function _setUserByToken($token)
    {
        $user = $this->getMemcached()->get($token);
        if ($user instanceof User) {
            $this->user = $user;
            $this->getMemcached()->set($token, $user, User::USER_LIFE_TIME);
        }  else {
            $this->user = null;
        }

        return $this;
    }
}