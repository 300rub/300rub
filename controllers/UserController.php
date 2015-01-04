<?php

namespace controllers;

use system\base\Controller;
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
						"attributes" => array(
							"type" => "text",
							"name" => "t.login",
						),
					),
					array(
						"form"       => "input",
						"label"      => Language::t("common", "Пароль"),
						"attributes" => array(
							"type" => "text",
							"name" => "t.password",
						),
					),
					array(
						"form"       => "input",
						"label"      => Language::t("common", "Запомнить"),
						"attributes" => array(
							"type" => "checkbox",
							"name" => "t.remember",
						),
					),
				),
			)
		);
	}
}