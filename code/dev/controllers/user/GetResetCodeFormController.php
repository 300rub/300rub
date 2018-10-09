<?php

namespace ss\controllers\user;

use ss\application\App;
use ss\application\exceptions\AccessException;
use ss\controllers\_abstract\AbstractController;
use ss\models\user\UserModel;

/**
 * Gets code form to reset password
 */
class GetResetCodeFormController extends AbstractController
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
                => $language->getMessage('user', 'passwordRecovery'),
            'forms' => [
                'code'       => [
                    'name'       => 'code',
                    'label'
                        => $language->getMessage('user', 'code'),
                    'validation'
                        => $model->getValidationRulesForField('code')
                ],
            ],
            'labels' => [
                'button' => $language->getMessage('user', 'verifyCode'),
            ]
        ];
    }
}
