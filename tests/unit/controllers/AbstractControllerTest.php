<?php

namespace tests\unit\controllers;

use components\Language;
use tests\unit\AbstractUnitTest;

/**
 * Class AbstractControllerTest
 *
 * @package tests\unit\controllers
 */
abstract class AbstractControllerTest extends AbstractUnitTest
{

    /**
     * Tests AJAX request
     *
     * @param string $action
     * @param string $languageAlias
     * @param array  $fields
     * @param array  $expected
     *
     * @dataProvider dataProviderForAjaxRequest
     */
    public function testAjaxRequest($action, $languageAlias, array $fields, array $expected)
    {
        list($controllerName, $actionName) = explode(".", $action);
        $className = "\\controllers\\" . ucfirst($controllerName) . "Controller";

        /**
         * @var \controllers\AbstractController $controller
         */
        $controller = new $className;
        $methodName = "action" . ucfirst($actionName);
        Language::setIdByAlias($languageAlias);
        $controller->data = $fields;
        $controller->$methodName();

        $this->_checkJson($expected, $controller->json);
    }

    /**
     * Checks JSON content
     *
     * @param array $expected
     * @param array $json
     */
    private function _checkJson(array $expected, array $json)
    {
        foreach ($expected as $key => $value) {
            $this->assertArrayHasKey($key, $json);

            if (is_array($value)) {
                $this->_checkJson($value, $json[$key]);
            } else {
                $this->assertEquals($value, $json[$key]);
            }
        }
    }
}