<?php

namespace ss\controllers\site;

use ss\application\components\valueGenerator\ValueGenerator;
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

        $languageList = App::getInstance()
            ->getValueGenerator()
            ->getValue(
                ValueGenerator::ORDERED_ARRAY,
                $language->getValueList()
            );

        return [
            'title'
                => $language->getMessage('site', 'createWindowTitle'),
            'forms' => [
                'name'       => [
                    'name' => 'name',
                    'label'
                        => $language->getMessage('common', 'address'),
                    'validation'
                        => $siteModel->getValidationRulesForField('name'),
                    'prefix'  => 'http://',
                    'postfix' => sprintf(
                        '.%s',
                        App::getInstance()->getConfig()->getValue(['host'])
                    )
                ],
                'userName'       => [
                    'name'       => 'userName',
                    'label'
                        => $language->getMessage('user', 'name'),
                    'validation'
                        => $userModel->getValidationRulesForField('name')
                ],
                'email'       => [
                    'name'       => 'email',
                    'label'
                        => $language->getMessage('common', 'email'),
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
                'passwordConfirm'   => [
                    'name'       => 'passwordConfirm',
                    'label'
                    => $language->getMessage('user', 'passwordConfirm'),
                    'validation' => array_merge(
                        $userModel->getValidationRulesForField('password'),
                        [
                            'minLength' => 3
                        ]
                    )
                ],
                'language'       => [
                    'label' => $language->getMessage('site', 'defaultLanguage'),
                    'value' => $language->getActiveId(),
                    'name'  => 'language',
                    'list'  => $languageList
                ],
                'button'     => [
                    'label'
                        => $language->getMessage('site', 'createSiteButton'),
                ]
            ]
        ];
    }
}
