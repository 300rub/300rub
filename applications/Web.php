<?php

/**
 * PHP version 7
 *
 * @category TestS
 * @package  Applications
 * @author   Mikhail Vasilev <donvasilion@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     -
 */

namespace testS\applications;

use testS\components\Db;
use testS\components\exceptions\BadRequestException;
use Exception;
use testS\components\exceptions\ContentException;
use testS\components\Language;
use testS\components\User;
use testS\controllers\AbstractController;
use testS\controllers\PageController;
use testS\models\FileModel;
use testS\models\UserModel;
use testS\models\UserSessionModel;

/**
 * Class for working with WEB application
 *
 * @category TestS
 * @package  Applications
 * @author   Mikhail Vasilev <donvasilion@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     -
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
     * User in session
     *
     * @var User
     */
    private $_user = null;

    /**
     * Runs application
     *
     * @return void
     */
    public function run()
    {
        $this->setSite($_SERVER["HTTP_HOST"]);

        $isAjax = false;
        if (strpos(trim($_SERVER["REQUEST_URI"], "/"), self::API_URL) === 0) {
            $isAjax = true;
        }

        try {
            session_start();
            $this->_initialUserSet();

            if ($isAjax === true) {
                header('Content-Type: application/json');
                $output = $this->_getAjaxOutput();
            } else {
                $output = (new PageController())->getPage();
            }
        } catch (Exception $e) {
            if ($this->_useTransaction === true) {
                Db::rollbackTransaction();
            }

            $output = $e->getMessage();
            if ($isAjax === true) {
                $output = json_encode(
                    [
                        "error" => [
                            "message" => $e->getMessage(),
                            "file"    => $e->getFile(),
                            "line"    => $e->getLine(),
                            "trace"   => $e->getTraceAsString(),
                        ]
                    ]
                );
            }
            switch ($e->getCode()) {
            case 204:
                http_response_code(204);
                break;
            case 400:
                http_response_code(400);
                break;
            case 404:
                http_response_code(404);
                break;
            case 403:
                http_response_code(403);
                break;
            default:
                http_response_code(500);
                break;
            }
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
            $actionPrefix = "create";
            $this->_useTransaction = true;
            break;
        case self::METHOD_PUT:
            $actionPrefix = "update";
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

        if (APP_ENV !== ENV_DEV
            && (!array_key_exists("HTTP_X_REQUESTED_WITH", $_SERVER)
            || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== "xmlhttprequest")
        ) {
            throw new BadRequestException("Only AJAX request is allowed");
        }

        if ($method === self::METHOD_GET) {
            $input = $_GET;
        } else {
            if (array_key_exists(FileModel::POST_FILE_NAME, $_FILES)) {
                $input = $_POST;
            } else {
                $input = json_decode(file_get_contents('php://input'), true);
            }
        }

        if (empty($input["controller"])
            || empty($input["action"])
            || empty($input["language"])
        ) {
            throw new BadRequestException(
                "Incorrect input data. Input: {input}",
                [
                    "input" => json_encode($input)
                ]
            );
        }

        $language = (int) $input["language"];
        if (!array_key_exists($language, Language::$aliasList)) {
            throw new BadRequestException(
                "Incorrect request. [language] is incorrect.",
                [
                    "input" => json_encode($input)
                ]
            );
        }
        Language::setActiveId($language);

        if (!isset($input["data"])
            || !is_array($input["data"])
        ) {
            $input["data"] = [];
        }

        $controllerClassName = sprintf(
            "\\testS\\controllers\\%sController",
            ucfirst($input["controller"])
        );
        if (!class_exists($controllerClassName)) {
            throw new BadRequestException(
                "Class: {controllerClassName} doesn't exists",
                [
                    "controllerClassName" => $controllerClassName
                ]
            );
        }

        $controllerMethodName = sprintf(
            "%s%s",
            $actionPrefix,
            ucfirst($input["action"])
        );
        $controller = $this->_getControllerByClassName($controllerClassName);
        $controller->setData($input["data"]);
        if (!method_exists($controller, $controllerMethodName)) {
            throw new BadRequestException(
                "Method: {methodName} doesn't exist in class: {className}",
                [
                    "methodName" => $controllerMethodName,
                    "className"  => $controllerClassName
                ]
            );
        }

        $output = $controller->$controllerMethodName();
        if (empty($output)) {
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
     * Gets controller by class name
     *
     * @param string $controllerClassName Class name
     *
     * @return AbstractController
     */
    private function _getControllerByClassName($controllerClassName)
    {
        return new $controllerClassName;
    }

    /**
     * Gets token
     *
     * @return string|null
     */
    private function _getToken()
    {
        if (!empty($_SESSION["token"])) {
            return $_SESSION["token"];
        }

        if (!empty($_COOKIE["token"])) {
            $_SESSION["token"] = $_COOKIE["token"];
            return $_COOKIE["token"];
        }

        $method = strtoupper($_SERVER['REQUEST_METHOD']);
        if ($method === self::METHOD_GET) {
            $input = $_GET;
        } else {
            if (array_key_exists(FileModel::POST_FILE_NAME, $_FILES)) {
                $input = $_POST;
            } else {
                $input = json_decode(file_get_contents('php://input'), true);
            }
        }

        if (!empty($input["token"])) {
            $_SESSION["token"] = $input["token"];
            $_COOKIE["token"] = $input["token"];
            return $input["token"];
        }

        return null;
    }

    /**
     * Initial user set
     *
     * @return Web
     */
    private function _initialUserSet()
    {
        $token = $this->_getToken();
        if (!$token) {
            return $this;
        }

        $user = $this->getMemcached()->get($token);
        if ($user instanceof User) {
            $this->_user = $user;
            return $this;
        }

        $userSessionModel = (new UserSessionModel())->byToken($token)->find();
        if (!$userSessionModel instanceof UserSessionModel) {
            return $this;
        }

        $userModel = (new UserModel())
            ->byId($userSessionModel->get("userId"))
            ->find();
        if (!$userModel instanceof UserModel) {
            return $this;
        }

        return $this->setUser($token, $userModel);
    }

    /**
     * Gets user
     *
     * @return User
     */
    public function getUser()
    {
        if ($this->_user instanceof User) {
            return $this->_user;
        }

        return $this->_initialUserSet()->_user;
    }

    /**
     * Sets User
     *
     * @param string    $token     Token
     * @param UserModel $userModel User model
     *
     * @return Web
     */
    public function setUser($token, UserModel $userModel)
    {
        $this->_user = new User($token, $userModel);

        $this->getMemcached()->set($token, $this->_user);

        return $this;
    }
}