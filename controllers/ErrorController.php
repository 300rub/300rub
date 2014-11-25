<?php

namespace controllers;

use system\base\Controller;

/**
 * Файл класса ErrorController
 *
 * @package controllers
 */
class ErrorController extends Controller
{

	/**
	 * Шаблон
	 *
	 * @var string
	 */
	public $layout = "error";

	/**
	 * Название директории для представлений
	 *
	 * @return string
	 */
	protected function getViewsDir()
	{
		return "error";
	}

	/**
	 * Выводит страницу ошибки
	 *
	 * @param string $message    сообщение
	 * @param int    $statusCode статус
	 * @param string $trace      уровки
	 */
	public function actionError($message, $statusCode = 500, $trace = "")
	{
		header("HTTP/1.0 {$statusCode}");

		$this->render(
			"error",
			array(
				"statusCode" => $statusCode,
				"message"    => str_replace("\n", "<br />", $message),
				"trace"      => str_replace("\n", "<br />", $trace)
			)
		);
	}
}