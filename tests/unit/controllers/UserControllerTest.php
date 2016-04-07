<?php

namespace tests\unit\controllers;

use components\Language;
use models\AbstractModel;
use models\UserModel;
use tests\unit\AbstractUnitTest;

/**
 * Class UserControllerTest
 *
 * @package tests\unit\controllers
 */
abstract class UserControllerTest extends AbstractUnitTest
{

    /**
     * Data provider for testAjaxRequest
     *
     * @return array
     */
    public function dataProviderForAjaxRequest()
    {
        return array_merge(
            $this->_dataProviderForActionWindow()
        );
    }

    /**
     * Data provider for testAjaxRequest. Tests actionWindow
     *
     * @return array
     */
    private function _dataProviderForActionWindow()
    {
        $model = new UserModel();

        return [
            [
                "user.window",
                Language::LANGUAGE_EN_ALIAS,
                [],
                [
                    "title"       => Language::t("user", "windowTitle"),
                    "action"      => "user.login",
                    "buttonLabel" => Language::t("user", "windowButton"),
                    "forms"       => [
                        [
                            "name"  => "t.login",
                            "rules" => $model->getRulesForField("login"),
                            "type"  => AbstractModel::FORM_TYPE_FIELD,
                            "value" => ""
                        ],
                        [
                            "name"  => "t.password",
                            "rules" => $model->getRulesForField("password"),
                            "type"  => AbstractModel::FORM_TYPE_FIELD,
                            "value" => ""
                        ],
                        [
                            "name"  => "t.is_remember",
                            "rules" => $model->getRulesForField("is_remember"),
                            "type"  => AbstractModel::FORM_TYPE_CHECKBOX,
                            "value" => false
                        ]
                    ]
                ]
            ]
        ];
    }
}