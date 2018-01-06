<?php

namespace testS\controllers;

use testS\application\App;
use testS\components\Db;
use testS\components\exceptions\AccessException;
use testS\components\exceptions\BadRequestException;
use testS\components\exceptions\NotFoundException;
use testS\components\Language;
use testS\components\Operation;
use testS\components\ValueGenerator;
use testS\models\BlockModel;
use testS\models\SectionModel;
use testS\models\UserModel;
use testS\models\UserSessionModel;
use testS\components\User;

/**
 * UserController
 *
 * @package testS\controllers
 */
class UserController extends AbstractController
{

    /**
     * Adds user
     *
     * @throws BadRequestException
     *
     * @return array
     */
    public function createUser()
    {
        $this->checkSettingsOperation(Operation::SETTINGS_USER_ADD);

        $this->checkData(
            [
                "name"            => [self::TYPE_STRING, self::NOT_EMPTY],
                "login"           => [self::TYPE_STRING, self::NOT_EMPTY],
                "email"           => [self::TYPE_STRING, self::NOT_EMPTY],
                "type"            => [self::TYPE_INT],
                "password"        => [self::TYPE_STRING, self::NOT_EMPTY],
                "passwordConfirm" => [self::TYPE_STRING, self::NOT_EMPTY],
                "operations"      => [self::TYPE_ARRAY],
            ]
        );

        if ($this->get("password") !== $this->get("passwordConfirm")) {
            return [
                "errors" => [
                    "passwordConfirm" => Language::t("user", "passwordsMatch")
                ]
            ];
        }

        $userModel = new UserModel();
        $userModel->set(
            [
                "login"    => $this->get("login"),
                "password" => UserModel::getPasswordHash($this->get("password")),
                "type"     => $this->get("type"),
                "name"     => $this->get("name"),
                "email"    => $this->get("email"),
            ]
        );
        $userModel->save();

        $errors = $userModel->getParsedErrors();
        if (count($errors) > 0) {
            return [
                "errors" => $errors
            ];
        }

        $userModel->addOperations($this->get("operations"));

        return [
            "result" => true,
            "users"  => $this->getUsers()
        ];
    }

    /**
     * Updates user
     *
     * @throws BadRequestException
     * @throws NotFoundException
     * @throws AccessException
     *
     * @return array
     */
    public function updateUser()
    {
        $this->checkSettingsOperation(Operation::SETTINGS_USER_UPDATE);

        $this->checkData(
            [
                "id"               => [self::TYPE_INT, self::NOT_EMPTY],
                "name"             => [self::TYPE_STRING, self::NOT_EMPTY],
                "login"            => [self::TYPE_STRING, self::NOT_EMPTY],
                "email"            => [self::TYPE_STRING, self::NOT_EMPTY],
                "isChangePassword" => [self::TYPE_BOOL],
            ]
        );

        $user = App::web()->getUser();

        $userModel = (new UserModel())->byId($this->get("id"))->find();
        if ($userModel === null) {
            throw new NotFoundException(
                "Unable to find user by ID: {id}",
                [
                    "id" => $this->get("id")
                ]
            );
        }

        if ($userModel->isOwner()
            && $user->getType() !== UserModel::TYPE_OWNER
        ) {
            throw new AccessException(
                "Unable to update owner"
            );
        }

        if ($this->get("isChangePassword") === true) {
            if (!$this->get("password")
                || !$this->get("passwordConfirm")
                || strlen($this->get("password")) !== 32
                || strlen($this->get("passwordConfirm")) !== 32
            ) {
                throw new BadRequestException(
                    "Incorrect passwords. Password: {password}, passwordConfirm: {passwordConfirm}",
                    [
                        "password"        => $this->get("password"),
                        "passwordConfirm" => $this->get("passwordConfirm"),
                    ]
                );
            }

            if ($this->get("password") !== $this->get("passwordConfirm")) {
                return [
                    "errors" => [
                        "passwordConfirm" => Language::t("user", "passwordsMatch")
                    ]
                ];
            }

            $userModel->set(
                [
                    "password" => UserModel::getPasswordHash($this->get("password"))
                ]
            );
        }

        $userModel->set(
            [
                "login" => $this->get("login"),
                "name"  => $this->get("name"),
                "email" => $this->get("email"),
            ]
        );
        if ($this->get("type")
            && $user->getId() !== $userModel->getId()
        ) {
            $userModel->set(
                [
                    "type"  => $this->get("type"),
                ]
            );
        }
        $userModel->save();

        $errors = $userModel->getParsedErrors();
        if (count($errors) > 0) {
            return [
                "errors" => $errors
            ];
        }

        if ($this->get("operations")
            && is_array($this->get("operations"))
        ) {
            $userModel->updateOperations($this->get("operations"));
        }

        return $this->getSimpleSuccessResult();
    }

    /**
     * Deletes user
     */
    public function deleteUser()
    {
        $this->checkSettingsOperation(Operation::SETTINGS_USER_DELETE);

        $this->checkData(
            [
                "id" => [self::TYPE_INT, self::NOT_EMPTY],
            ]
        );

        $userModel = (new UserModel())->byId($this->get("id"))->find();
        if ($userModel === null) {
            throw new NotFoundException(
                "Unable to find user by ID: {id}",
                [
                    "id" => $this->get("id")
                ]
            );
        }

        if ($userModel->get("type") === UserModel::TYPE_OWNER) {
            throw new AccessException("Unable to delete owner");
        }

        $userModel->delete();

        return $this->getSimpleSuccessResult();
    }
}