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
		$this->setFormsForJson(new UserModel, array("t.login", "t.password", "t.remember"))->renderJson();
	}

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
				$success = true;
			}
		}

		$this->json = array(
			"success" => $success,
			"errors"  => $model->errors,
		);

		$this->renderJson();
	}
}