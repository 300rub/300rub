<?php

namespace ss\controllers\user;

use ss\application\App;
use ss\application\exceptions\AccessException;
use ss\application\exceptions\NotFoundException;
use ss\controllers\_abstract\AbstractController;
use ss\models\user\UserModel;

/**
 * Checks code and resets password
 */
class CreateResetCodeController extends AbstractController
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
                'id'   => [self::NOT_EMPTY],
                'code' => [self::TYPE_STRING, self::NOT_EMPTY],
            ]
        );

        if ($this->isUser() === true) {
            throw new AccessException(
                'Unable to get login forms ' .
                'because user is already in context'
            );
        }

        $language = App::getInstance()->getLanguage();

        $userModel = $this->_getUserModel();
        if ($userModel->get('code') !== $this->get('code')) {
            return [
                'errors' => [
                    'code' => $language->getMessage(
                        'user',
                        'incorrectCode'
                    )
                ]
            ];
        }

        $newPassword = substr(
            md5(uniqid()),
            0,
            8
        );

        $body = sprintf(
            '<strong>%s:</strong> %s <br><strong>%s:</strong> %s',
            $language->getMessage('user', 'login'),
            $userModel->get('login'),
            $language->getMessage('user', 'password'),
            $newPassword
        );

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

        $passwordHash = $userModel->getPasswordHash($newPassword);
        $userModel
            ->set(
                [
                    'password' => $passwordHash,
                    'code'     => ''
                ]
            )
            ->save();

        return $this->getSimpleSuccessResult();
    }

    /**
     * Gets user model
     *
     * @throws NotFoundException
     *
     * @return UserModel
     */
    private function _getUserModel()
    {
        $userModel = UserModel::model()
            ->byId($this->get('id'))
            ->find();
        if ($userModel === null) {
            throw new NotFoundException(
                'Unable to find user with id: {id}',
                [
                    'id' => $this->get('id')
                ]
            );
        }

        return $userModel;
    }
}
