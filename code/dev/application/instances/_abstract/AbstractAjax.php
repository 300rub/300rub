<?php

namespace ss\application\instances\_abstract;

use ss\application\components\SuperGlobalVariable;
use ss\application\exceptions\BadRequestException;
use ss\application\exceptions\ContentException;
use ss\controllers\_abstract\AbstractController;

/**
 * Abstract class for working with AJAX requests
 */
abstract class AbstractAjax extends AbstractApplication
{

    /**
     * API uri
     */
    const API_PREFIX = 'api';

    /**
     * HTTP Methods
     */
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';

    /**
     * Flag to skip transaction
     *
     * @var bool
     */
    private $_skipTransaction = false;

    /**
     * Flag of using transaction
     *
     * @var boolean
     */
    private $_useTransaction = false;

    /**
     * Controller prefix
     *
     * @var string
     */
    private $_prefix = '';

    /**
     * Controller
     *
     * @var AbstractController
     */
    private $_controller = '';

    /**
     * Input
     *
     * @var array
     */
    private $_input = [];

    /**
     * Output
     *
     * @var array
     */
    private $_output = [];

    /**
     * Gets AJAX output
     *
     * @return string
     */
    protected function processAjax()
    {
        try {
            $output = $this
                ->_setPrefix()
                ->_setUseTransaction()
                ->_startTransaction()
                ->_checkAjaxRequest()
                ->_setInput()
                ->_checkInput()
                ->_setLanguageId()
                ->_setController()
                ->_runController()
                ->_commitTransaction()
                ->_getAjaxOutput();
        } catch (\Exception $exception) {
            $this->_rollbackTransaction();
            $output = $this->_getAjaxErrorOutput($exception);
        }

        header('Content-Type: application/json');
        return json_encode($output);
    }

    /**
     * Sets transaction skipped
     *
     * @return AbstractAjax
     */
    public function setTransactionSkipped()
    {
        $this->_skipTransaction = true;
        return $this;
    }

    /**
     * Sets prefix
     *
     * @return AbstractAjax
     *
     * @throws BadRequestException
     */
    private function _setPrefix()
    {
        $method = strtoupper(
            $this
                ->getSuperGlobalVariable()
                ->getServerValue('REQUEST_METHOD')
        );

        switch ($method) {
            case self::METHOD_GET:
                $this->_prefix = 'Get';
                break;
            case self::METHOD_POST:
                $this->_prefix = 'Create';
                break;
            case self::METHOD_PUT:
                $this->_prefix = 'Update';
                break;
            case self::METHOD_DELETE:
                $this->_prefix = 'Delete';
                break;
            default:
                throw new BadRequestException(
                    'AJAX request method: {method} is not allowed',
                    [
                        'method' => $method
                    ]
                );
        }

        return $this;
    }

    /**
     * Sets using transaction
     *
     * @return AbstractAjax
     */
    private function _setUseTransaction()
    {
        if ($this->_skipTransaction === true) {
            $this->_useTransaction = false;
            return $this;
        }

        $method = strtoupper(
            $this
                ->getSuperGlobalVariable()
                ->getServerValue('REQUEST_METHOD')
        );

        $this->_useTransaction = true;
        if ($method === self::METHOD_GET) {
            $this->_useTransaction = false;
        }

        return $this;
    }

    /**
     * Starts transaction
     *
     * @return AbstractAjax
     */
    private function _startTransaction()
    {
        if ($this->_useTransaction === true) {
            $this->getDb()->startTransaction();
        }

        return $this;
    }

    /**
     * Commits transaction
     *
     * @return AbstractAjax
     */
    private function _commitTransaction()
    {
        if ($this->_useTransaction === true) {
            $this->getDb()->commitTransaction();
        }

        return $this;
    }

    /**
     * Rollbacks transaction
     *
     * @return AbstractAjax
     */
    private function _rollbackTransaction()
    {
        if ($this->_useTransaction === true) {
            $this->getDb()->rollbackTransaction();
        }

        return $this;
    }

    /**
     * Checks AJAX request
     *
     * @throws BadRequestException
     *
     * @return AbstractAjax
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
     * Sets input value
     *
     * @return AbstractAjax
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
            ->getFilesValue(SuperGlobalVariable::POST_FILE_NAME);
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

    /**
     * Checks input
     *
     * @return AbstractAjax
     *
     * @throws BadRequestException
     */
    private function _checkInput()
    {
        if (empty($this->_input['group']) === true
            || empty($this->_input['controller']) === true
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
     * Sets language ID
     *
     * @return AbstractAjax
     *
     * @throws BadRequestException
     */
    private function _setLanguageId()
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
     * Sets controller
     *
     * @return AbstractAjax
     *
     * @throws BadRequestException
     */
    private function _setController()
    {
        $controllerClassName = sprintf(
            '\\ss\\controllers\\%s\\%s%sController',
            strtolower($this->_input['group']),
            $this->_prefix,
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

        $this->_controller = new $controllerClassName;
        $this->_controller->setData($this->_getInputData());

        return $this;
    }

    /**
     * Gets input data
     *
     * @return array
     */
    private function _getInputData()
    {
        if (array_key_exists('data', $this->_input) === false) {
            return [];
        }

        if (is_array($this->_input['data']) === false) {
            return [];
        }

        return $this->_input['data'];
    }

    /**
     * Runs controller
     *
     * @return AbstractAjax
     */
    private function _runController()
    {
        $this->_output = $this->_controller->run();
        return $this;
    }

    /**
     * Gets output
     *
     * @return string
     *
     * @throws ContentException
     */
    private function _getAjaxOutput()
    {
        if (empty($this->_output) === true) {
            throw new ContentException(
                'Nothing to output',
                [
                    'input' => json_encode($this->_input)
                ]
            );
        }

        return $this->_output;
    }

    /**
     * Gets AJAX error output
     *
     * @param \Exception $exception Exception
     *
     * @return array
     */
    private function _getAjaxErrorOutput(\Exception $exception)
    {
        switch ($exception->getCode()) {
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

        return [
            'error' => [
                'message' => $exception->getMessage(),
                'file'    => sprintf(
                    '%s (%s)',
                    $exception->getFile(),
                    $exception->getLine()
                ),
                'trace'   => $exception->getTraceAsString(),
            ]
        ];
    }
}
