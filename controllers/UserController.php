<?php

namespace controllers;

use models\UserModel;
use system\App;
use system\base\Controller;
use system\base\Exception;
use system\base\Language;

/**
 * Файл класса SectionController
 *
 * @package controllers
 */
class UserController extends Controller
{

	protected function getViewsDir()
	{
		return "user";
	}

	public function actionForm()
	{
		$this->renderJson(
			array(
				"title" => Language::t("common", "Вход"),
				"button" => Language::t("common", "Войти"),
				"forms" => array(
					array(
						"form"       => "input",
						"label"      => Language::t("common", "Логин"),
						"name"       => "t.login",
						"attributes" => array(
							"type" => "text",
						),
					),
					array(
						"form"       => "input",
						"label"      => Language::t("common", "Пароль"),
						"name"       => "t.password",
						"attributes" => array(
							"type" => "text",
						),
					),
					array(
						"form"       => "input",
						"label"      => Language::t("common", "Запомнить"),
						"name"       => "t.remember",
						"attributes" => array(
							"type" => "checkbox",
						),
					),
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
			"errors" => $model->errors,
		);

		$this->renderJson($json);

		//$model = UserModel::model()->byLogin($post["t.login"])->find();
		//if (!$model) {
			//$errors["t.login"] = array("required" => )
		//}
	}
}