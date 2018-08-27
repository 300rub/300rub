<?php

namespace ss\controllers\user;

use ss\application\App;
use ss\application\components\user\Operation;
use ss\application\exceptions\BadRequestException;
use ss\controllers\_abstract\AbstractController;
use ss\models\user\UserModel;

/**
 * Adds user
 */
class CreateUserController extends AbstractController
{

    /**
     * Runs controller
     *
     * @return array
     *
     * @throws BadRequestException
     */
    public function run()
    {
        $this->checkSettingsOperation(Operation::SETTINGS_USER_ADD);

        $this->checkData(
            [
                'name'            => [self::TYPE_STRING, self::NOT_EMPTY],
                'login'           => [self::TYPE_STRING, self::NOT_EMPTY],
                'email'           => [self::TYPE_STRING, self::NOT_EMPTY],
                'type'            => [],
                'password'        => [self::TYPE_STRING, self::NOT_EMPTY],
                'passwordConfirm' => [self::TYPE_STRING, self::NOT_EMPTY],
                'operations'      => [self::TYPE_ARRAY],
            ]
        );

        if ($this->get('password') !== $this->get('passwordConfirm')) {
            return [
                'errors' => [
                    'passwordConfirm' => App::getInstance()
                        ->getLanguage()
                        ->getMessage('user', 'passwordsMatch')
                ]
            ];
        }

        $userModel = new UserModel();
        $userModel->set(
            [
                'login'    => $this->get('login'),
                'password' => $userModel->getPasswordHash(
                    $this->get('password')
                ),
                'type'     => $this->get('type'),
                'name'     => $this->get('name'),
                'email'    => $this->get('email'),
            ]
        );
        $userModel->save();

        $errors = $userModel->getParsedErrors();
        if (count($errors) > 0) {
            return [
                'errors' => $errors
            ];
        }

        $userModel->addOperations($this->get('operations'));

        $getUsersController = new GetUsersController();

        return [
            'result' => true,
            'users'  => $getUsersController->run()
        ];
    }
}
