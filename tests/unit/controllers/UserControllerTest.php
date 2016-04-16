<?php

namespace tests\unit\controllers;

use components\Language;
use models\AbstractModel;
use models\UserModel;

/**
 * Class UserControllerTest
 *
 * @package tests\unit\controllers
 */
class UserControllerTest extends AbstractControllerTest
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
            // actionWindow
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
            ],
            // actionWindow with empty all fields
            [
                "user.login",
                Language::LANGUAGE_EN_ALIAS,
                [],
                [
                    "error" => "Incorrect URL"
                ]
            ],
            // actionWindow with empty password
            [
                "user.login",
                Language::LANGUAGE_EN_ALIAS,
                [
                    "t.login" => ""
                ],
                [
                    "error" => "Incorrect URL"
                ]
            ],
            // actionWindow with empty login
            [
                "user.login",
                Language::LANGUAGE_EN_ALIAS,
                [
                    "t.password" => ""
                ],
                [
                    "error" => "Incorrect URL"
                ]
            ],
            // actionWindow with empty values
            [
                "user.login",
                Language::LANGUAGE_EN_ALIAS,
                [
                    "t.login"    => "",
                    "t.password" => ""
                ],
                [
                    "errors" => [
                        "t.login"    => "required",
                        "t.password" => "required"
                    ]
                ]
            ],
            // actionWindow with non nonexistent login
            [
                "user.login",
                Language::LANGUAGE_EN_ALIAS,
                [
                    "t.login"    => "nonexistent_login",
                    "t.password" => "nonexistent_password"
                ],
                [
                    "errors" => [
                        "t.login" => "login-not-exist"
                    ]
                ]
            ],
            // actionWindow with non nonexistent password
            [
                "user.login",
                Language::LANGUAGE_EN_ALIAS,
                [
                    "t.login"    => "login",
                    "t.password" => "nonexistent_password"
                ],
                [
                    "errors" => [
                        "t.password" => "password-incorrect"
                    ]
                ]
            ],
            // actionWindow with correct values
            [
                "user.login",
                Language::LANGUAGE_EN_ALIAS,
                [
                    "t.login"    => "login",
                    "t.password" => "password"
                ],
                [
                    "errors" => [],
                    "reload" => true
                ]
            ]
        ];
    }
}