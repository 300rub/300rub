<?php

namespace ss\controllers\user;

use ss\application\App;
use ss\application\components\user\Operation;
use ss\application\components\user\User;
use ss\application\exceptions\AccessException;
use ss\application\exceptions\BadRequestException;
use ss\application\exceptions\NotFoundException;
use ss\controllers\_abstract\AbstractController;
use ss\models\_abstract\AbstractModel;
use ss\models\user\UserModel;

/**
 * Updates user
 */
class UpdateUserController extends AbstractController
{

    /**
     * User
     *
     * @var User
     */
    private $_user = null;

    /**
     * User model
     *
     * @var UserModel
     */
    private $_userModel = null;

    /**
     * Runs controller
     *
     * @return array
     *
     * @throws BadRequestException
     */
    public function run()
    {
        $this->checkSettingsOperation(Operation::SETTINGS_USER_UPDATE);

        $this->checkData(
            [
                'id'               => [self::TYPE_INT, self::NOT_EMPTY],
                'name'             => [self::TYPE_STRING, self::NOT_EMPTY],
                'login'            => [self::TYPE_STRING, self::NOT_EMPTY],
                'email'            => [self::TYPE_STRING, self::NOT_EMPTY],
                'isChangePassword' => [self::TYPE_BOOL],
            ]
        );

        $this->_user = App::getInstance()->getUser();
        $this->_userModel = $this->_getUserModel();

        $this->_checkAccess();

        if ($this->get('isChangePassword') === true) {
            if ($this->_isCorrectPassword() === true) {
                throw new BadRequestException(
                    'Incorrect passwords. Password: {password}, ' .
                    'passwordConfirm: {passwordConfirm}',
                    [
                        'password'        => $this->get('password'),
                        'passwordConfirm' => $this->get('passwordConfirm'),
                    ]
                );
            }

            if ($this->get('password') !== $this->get('passwordConfirm')) {
                return [
                    'errors' => [
                        'passwordConfirm' => App::getInstance()
                            ->getLanguage()
                            ->getMessage('user', 'passwordsMatch')
                    ]
                ];
            }

            $this->_userModel->set(
                [
                    'password' => $this->_userModel->getPasswordHash(
                        $this->get('password')
                    )
                ]
            );
        }

        $this->_userModel->set(
            [
                'login' => $this->get('login'),
                'name'  => $this->get('name'),
                'email' => $this->get('email'),
            ]
        );

        if ($this->get('type') > 0
            && $this->_user->getId() !== $this->_userModel->getId()
        ) {
            $this->_userModel->set(
                [
                    'type'  => $this->get('type'),
                ]
            );
        }

        $this->_userModel->save();

        $errors = $this->_userModel->getParsedErrors();
        if (count($errors) > 0) {
            return [
                'errors' => $errors
            ];
        }

        if ($this->_hasOperations() === true) {
            $this->_userModel->updateOperations($this->get('operations'));
        }

        return $this->getSimpleSuccessResult();
    }

    /**
     * Checks access
     *
     * @throws AccessException
     *
     * @return void
     */
    private function _checkAccess()
    {
        if ($this->_userModel->isOwner() === true
            && $this->_user->getType() !== UserModel::TYPE_OWNER
        ) {
            throw new AccessException(
                'Unable to update owner'
            );
        }
    }

    /**
     * Gets operations flag
     *
     * @return bool
     */
    private function _hasOperations()
    {
        $operations = $this->get('operations');
        if (empty($operations) === false
            && is_array($this->get('operations')) === true
        ) {
            return true;
        }

        return false;
    }

    /**
     * Checks correct password
     *
     * @return bool
     */
    private function _isCorrectPassword()
    {
        if (is_string($this->get('password')) === false
            || is_string($this->get('passwordConfirm')) === false
            || strlen($this->get('password')) !== 32
            || strlen($this->get('passwordConfirm')) !== 32
        ) {
            return true;
        }

        return false;
    }

    /**
     * Gets user model
     *
     * @return AbstractModel|UserModel
     *
     * @throws NotFoundException
     */
    private function _getUserModel()
    {
        $userModel = new UserModel();
        $userModel->byId($this->get('id'));
        $userModel = $userModel->find();
        if ($userModel === null) {
            throw new NotFoundException(
                'Unable to find user by ID: {id}',
                [
                    'id' => $this->get('id')
                ]
            );
        }

        return $userModel;
    }
}
