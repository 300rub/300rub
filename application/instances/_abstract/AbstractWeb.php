<?php

namespace testS\application\instances\_abstract;

use testS\application\exceptions\BadRequestException;
use testS\application\exceptions\ContentException;
use testS\controllers\AbstractController;
use testS\controllers\PageController;
use testS\models\FileModel;

/**
 * Abstract class for working with WEB application
 */
abstract class AbstractWeb extends AbstractApplication
{

    /**
     * HTTP Methods
     */
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';

    /**
     * API url
     */
    const API_URL = 'api';

    /**
     * Flag of using transaction
     *
     * @var boolean
     */
    protected $useTransaction = false;

    /**
     * Input
     *
     * @var array
     */
    private $_input = [];

    /**
     * Gets output
     *
     * @param bool $isAjax Flag of ajax request
     *
     * @return string
     */
    protected function getOutput($isAjax)
    {
        if ($isAjax === true) {
            header('Content-Type: application/json');
            return $this->_getAjaxOutput();
        }

        $pageController = new PageController();
        return $pageController->getPage();
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
        $actionPrefix = $this->_getActionPrefix();

        if ($this->useTransaction === true) {
            $this->getDb()->startTransaction();
        }

        $this
            ->_checkAjaxRequest()
            ->_setInput()
            ->_checkInput()
            ->_setLanguage();

        if (isset($this->_input['data']) === false
            || is_array($this->_input['data']) === false
        ) {
            $this->_input['data'] = [];
        }

        $controllerClassName = sprintf(
            "\\testS\\controllers\\%sController",
            ucfirst($this->_input['controller'])
        );
        if (class_exists($controllerClassName) === false) {
            throw new BadRequestException(
                "Class: {controllerClassName} doesn't exists",
                [
                    'controllerClassName' => $controllerClassName
                ]
            );
        }

        $controllerMethodName = sprintf(
            '%s%s',
            $actionPrefix,
            ucfirst($this->_input['action'])
        );
        $controller = $this->_getControllerByClassName($controllerClassName);
        $controller->setData($this->_input['data']);
        if (method_exists($controller, $controllerMethodName) === false) {
            throw new BadRequestException(
                "Method: {methodName} doesn't exist in class: {className}",
                [
                    'methodName' => $controllerMethodName,
                    'className'  => $controllerClassName
                ]
            );
        }

        $output = $controller->$controllerMethodName();
        if (empty($output) === true) {
            throw new ContentException(
                'Nothing to output. Input: {input}',
                [
                    'input' => json_encode($this->_input)
                ]
            );
        }

        if ($this->useTransaction === true) {
            $this->getDb()->commitTransaction();
        }

        return json_encode($output);
    }

    /**
     * Checks AJAX request
     *
     * @throws BadRequestException
     *
     * @return AbstractWeb
     */
    private function _checkAjaxRequest()
    {
        $requestedWith = $this
            ->getSuperGlobalVariable()
            ->getServerValue('HTTP_X_REQUESTED_WITH');
        if (APP_ENV !== ENV_DEV
            && strtolower($requestedWith) !== 'xmlhttprequest'
        ) {
            throw new BadRequestException('Only AJAX request is allowed');
        }

        return $this;
    }

    /**
     * Checks input
     *
     * @return AbstractWeb
     *
     * @throws BadRequestException
     */
    private function _checkInput()
    {
        if (empty($this->_input['controller']) === true
            || empty($this->_input['action']) === true
            || empty($this->_input['language']) === true
        ) {
            throw new BadRequestException(
                'Incorrect input data. Input: {input}',
                [
                    'input' => json_encode($this->_input)
                ]
            );
        }

        return $this;
    }

    /**
     * Sets language
     *
     * @return AbstractWeb
     *
     * @throws BadRequestException
     */
    private function _setLanguage()
    {
        $language = (int)$this->_input['language'];
        $aliasList = $this->getLanguage()->getAliasList();

        if (array_key_exists($language, $aliasList) === false) {
            throw new BadRequestException(
                'Incorrect request. [language] is incorrect.',
                [
                    'input' => json_encode($this->_input)
                ]
            );
        }

        $this->getLanguage()->setActiveId($language);

        return $this;
    }

    /**
     * Gets action prefix
     *
     * @return string
     *
     * @throws BadRequestException
     */
    private function _getActionPrefix()
    {
        $method = strtoupper(
            $this
                ->getSuperGlobalVariable()
                ->getServerValue('REQUEST_METHOD')
        );

        switch ($method) {
            case self::METHOD_GET:
                $this->useTransaction = false;
                return 'get';
            case self::METHOD_POST:
                $this->useTransaction = true;
                return 'create';
            case self::METHOD_PUT:
                $this->useTransaction = true;
                return 'update';
            case self::METHOD_DELETE:
                $this->useTransaction = true;
                return 'delete';
            default:
                throw new BadRequestException(
                    'AJAX request method: {method} is not allowed',
                    [
                        'method' => $method
                    ]
                );
        }
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
     * Sets input value
     *
     * @return AbstractWeb
     */
    private function _setInput()
    {
        $method = strtoupper(
            $this
                ->getSuperGlobalVariable()
                ->getServerValue('REQUEST_METHOD')
        );

        if ($method === self::METHOD_GET) {
            $this->_input = $this->getSuperGlobalVariable()->getGetValue();
            return $this;
        }

        $file = $this
            ->getSuperGlobalVariable()
            ->getFilesValue(FileModel::POST_FILE_NAME);
        if ($file !== null) {
            $this->_input = $this
                ->getSuperGlobalVariable()
                ->getPostValue();
            return $this;
        }

        $this->_input = json_decode(file_get_contents('php://input'), true);
        return $this;
    }

    /**
     * Gets input
     *
     * @return array
     */
    protected function getInput()
    {
        if (count($this->_input) === 0) {
            $this->_setInput();
        }

        return $this->_input;
    }
}
