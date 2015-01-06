<?php

namespace controllers;

use models\UserModel;
use system\App;
use system\base\Controller;
use system\base\Language;

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
		$this->renderJson(
			array(
				"t.login"    => array(
					"form"  => "field",
					"label" => Language::t("common", "Логин"),
				),
				"t.password" => array(
					"form"  => "field",
					"label" => Language::t("common", "Пароль"),
				),
				"t.remember" => array(
					"form"  => "checkbox",
					"label" => Language::t("common", "Запомнить"),
				),
			)
		);
	}

	public function actionLogin()
	{
		$post = App::getPost();
		if (!$post || !isset($post["t.login"]) || !isset($post["t.password"])) {
			//throw new Exception(Language::t("common", "Некорректрый url"), 404);
		}

		$model = new UserModel;
		$model->setAttributes($post);
		$model->validate(false);

		$json = array(
			"success" => false,
			"errors"  => $model->errors,
		);

		$this->renderJson($json);

		//$model = UserModel::model()->byLogin($post["t.login"])->find();
		//if (!$model) {
		//$errors["t.login"] = array("required" => )
		//}
	}
}