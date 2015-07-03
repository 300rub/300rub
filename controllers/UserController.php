<?php

namespace controllers;

use models\UserModel;
use system\App;
use system\web\Controller;
use system\base\Exception;
use system\web\Language;

/**
 * Файл класса SectionController
 *
 * @package controllers
 */
class UserController extends Controller
{

	/**
	 * Выводит на экран JSON с формами для авторизации
	 *
	 * @return void
	 */
	public function actionForm()
	{
		$this->json = [
			"name" => "login",
			"title" => Language::t("common", "Вход"),
			"button"      => [
				"label"  => Language::t("common", "Войти"),
				"action" => "user/login"
			],
		];
		$this->setFormsForJson(new UserModel, ["t.login", "t.password", "t.remember"])->renderJson();
	}

	/**
	 * Выполняется вход
	 *
	 * @throws Exception
	 *
	 * @return void
	 */
	public function actionLogin()
	{
		$post = App::getPost();
		if (!$post || !isset($post["t.login"]) || !isset($post["t.password"])) {
			throw new Exception(Language::t("common", "Некорректрый url"), 404);
		}

		$model = new UserModel;
		$model->setAttributes($post);
		$model->validate(false);

		$success = false;

		if (!$model->errors) {
			$checkModel = UserModel::model()->byLogin($post["t.login"])->find();
			if (!$checkModel) {
				$model->errors["t__login"] = "login-not-exist";
			} else if ($checkModel->getPassword($post["t.password"]) !== $checkModel->password) {
				$model->errors["t__password"] = "password-incorrect";
			} else {
				if (!empty($post["t.remember"])) {
					setcookie("__lp", "{$model->login}|p{$checkModel->password}", 0x6FFFFFFF);
					$_SESSION["__u"] = $checkModel;
				} else {
					$_SESSION["__u"] = $checkModel;
				}
				$success = true;
			}
		}

		$this->json = [
			"success"  => $success,
			"errors"   => $model->errors,
			"redirect" => "",
		];

		$this->renderJson();
	}

	/**
	 * Выход
	 *
	 * @return void
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