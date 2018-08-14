<?php

namespace ss\controllers\site;

use ss\controllers\site\_abstract\AbstractController;
use ss\application\App;
use ss\models\system\SiteModel;
use ss\models\user\UserModel;

/**
 * GetCreateFormController to get create form data
 */
class GetCreateFormController extends AbstractController
{

    /**
     * Gets site page
     *
     * @return string
     */
    public function run()
    {
        $language = App::getInstance()->getLanguage();
        $siteModel = new SiteModel();
        $userModel = new UserModel();

        return [
            'title'
                => $language->getMessage('user', 'loginTitle'),
            'forms' => [
                'name'       => [
                    'name'       => 'name',
                    'label'
                        => $language->getMessage('user', 'user'),
                    'validation'
                        => $siteModel->getValidationRulesForField('name')
                ],
                'email'       => [
                    'name'       => 'email',
                    'label'
                        => $language->getMessage('user', 'user'),
                    'validation'
                        => $siteModel->getValidationRulesForField('email')
                ],
                'user'       => [
                    'name'       => 'user',
                    'label'
                        => $language->getMessage('user', 'user'),
                    'validation'
                        => $userModel->getValidationRulesForField('login')
                ],
                'password'   => [
                    'name'       => 'password',
                    'label'
                        => $language->getMessage('user', 'password'),
                    'validation' => array_merge(
                        $userModel->getValidationRulesForField('password'),
                        [
                            'minLength' => 3
                        ]
                    )
                ],
                'button'     => [
                    'label'
                        => $language->getMessage('user', 'loginButton'),
                ]
            ]
        ];
    }
}
