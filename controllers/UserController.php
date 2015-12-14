<?php

namespace controllers;

use models\UserModel;
use system\web\Controller;
use system\base\Exception;
use system\web\Language;

/**
 * Users's controller
 *
 * @package controllers
 */
class UserController extends Controller
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
     * Window. Login forms
     */
    public function actionWindow()
    {
        $this->json = [
            "title"       => Language::t("common", "Вход"),
            "action"      => "user.login",
            "buttonLabel" => Language::t("common", "Войти")
        ];

        $this->setFormsForJson(new UserModel, ["t.login", "t.password", "t.remember"]);
    }

    /**
     * Login
     */
    public function actionLogin()
    {
        if (!$this->data || !isset($this->data["t.login"]) || !isset($this->data["t.password"])) {
            throw new Exception(Language::t("common", "Некорректрый url"), 404);
        }

        $model = new UserModel;
        $model->setAttributes($this->data)->validate(false);

        if (!$model->errors) {
            $checkModel = UserModel::model()->byLogin($this->data["t.login"])->find();
            if (!$checkModel) {
                $model->errors["t__login"] = "login-not-exist";
            } else {
                if ($checkModel->getPassword($this->data["t.password"]) !== $checkModel->password) {
                    $model->errors["t__password"] = "password-incorrect";
                } else {
                    if (!empty($post["t.remember"])) {
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