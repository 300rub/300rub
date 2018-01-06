<?php

namespace testS\controllers\user;

use testS\application\App;
use testS\application\components\Operation;
use testS\application\exceptions\BadRequestException;
use testS\controllers\_abstract\AbstractController;
use testS\models\user\UserModel;

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
                'type'            => [self::TYPE_INT],
                'password'        => [self::TYPE_STRING, self::NOT_EMPTY],
                'passwordConfirm' => [self::TYPE_STRING, self::NOT_EMPTY],
                'operations'      => [self::TYPE_ARRAY],
            ]
        );

        if ($this->get('password') !== $this->get('passwordConfirm')) {
            return [
                'errors' => [
                    'passwordConfirm' => App::web()
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
                    $this->get('password'),
                    false
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
