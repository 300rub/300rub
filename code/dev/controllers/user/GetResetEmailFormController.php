<?php

namespace ss\controllers\user;

use ss\application\App;
use ss\application\exceptions\AccessException;
use ss\controllers\_abstract\AbstractController;
use ss\models\user\UserModel;

/**
 * Gets email form to reset password
 */
class GetResetEmailFormController extends AbstractController
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
                'email'       => [
                    'name'       => 'email',
                    'label'
                        => $language->getMessage('common', 'email'),
                    'validation'
                        => $model->getValidationRulesForField('email')
                ],
                'button'     => [
                    'label'
                        => $language->getMessage('user', 'sendCode'),
                ]
            ]
        ];
    }
}
