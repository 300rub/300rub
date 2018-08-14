<?php

namespace ss\controllers\user;

use ss\application\App;
use ss\application\exceptions\AccessException;
use ss\controllers\_abstract\AbstractController;
use ss\models\user\UserModel;

/**
 * Gets login forms
 */
class GetLoginFormsController extends AbstractController
{

    /**
     * Runs controller
     *
     * @throws AccessException
     *
     * @return array
     */
    public function run()
    {
        if ($this->isUser() === true) {
            throw new AccessException(
                'Unable to get login forms ' .
                'because user is already in context'
            );
        }

        $model = new UserModel();
        $language = App::getInstance()->getLanguage();

        return [
            'title'
                => $language->getMessage('user', 'loginTitle'),
            'forms' => [
                'user'       => [
                    'name'       => 'user',
                    'label'
                        => $language->getMessage('user', 'user'),
                    'validation'
                        => $model->getValidationRulesForField('login')
                ],
                'password'   => [
                    'name'       => 'password',
                    'label'
                        => $language->getMessage('user', 'password'),
                    'validation' => array_merge(
                        $model->getValidationRulesForField('password'),
                        [
                            'minLength' => 3
                        ]
                    )
                ],
                'isRemember' => [
                    'name'  => 'isRemember',
                    'label'
                        => $language->getMessage('user', 'isRemember'),
                ],
                'button'     => [
                    'label'
                        => $language->getMessage('user', 'loginButton'),
                ]
            ]
        ];
    }
}
