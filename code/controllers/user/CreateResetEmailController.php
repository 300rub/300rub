<?php

namespace ss\controllers\user;

use ss\application\App;
use ss\application\exceptions\AccessException;
use ss\controllers\_abstract\AbstractController;
use ss\models\user\UserModel;

/**
 * Checks email and sends code
 */
class CreateResetEmailController extends AbstractController
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
        $this->checkData(
            [
                'email' => [self::TYPE_STRING, self::NOT_EMPTY],
            ]
        );

        if ($this->isUser() === true) {
            throw new AccessException(
                'Unable to get login forms ' .
                'because user is already in context'
            );
        }

        $language = App::getInstance()->getLanguage();

        $userModel = UserModel::model()
            ->byEmail($this->get('email'))
            ->find();
        if ($userModel === null) {
            return [
                'errors' => [
                    'email' => $language->getMessage(
                        'user',
                        'emailNotFound'
                    )
                ]
            ];
        }

        $code = rand(100000, 999999);

        $body = sprintf(
            '%s <br><strong>%s</strong>',
            $language->getMessage('user', 'enterCode'),
            $code
        );

        $userModel
            ->set(['code' => $code])
            ->save();

        App::getInstance()->getEmail()
            ->addRecipient(
                $userModel->get('email'),
                $userModel->get('name')
            )
            ->setSubject(
                $language->getMessage('user', 'passwordRecovery')
            )
            ->setBody($body)
            ->send();

        return [
            'id' => $userModel->getId()
        ];
    }
}
