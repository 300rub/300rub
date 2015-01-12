<?php

namespace controllers;

use system\web\Controller;
use models\SectionModel;
use system\base\Exception;
use system\web\Language;

/**
 * Файл класса SectionController
 *
 * @package controllers
 */
class SectionController extends Controller
{

	/**
	 * Макет
	 *
	 * @var string
	 */
	public $layout = "page";

	/**
	 * Название директории для представлений
	 *
	 * @return string
	 */
	protected function getViewsDir()
	{
		return "section";
	}

	/**
	 * Выводит раздел на экран
	 *
	 * @param string $section абривиатура раздела
	 * @param string $param1 параметр 1
	 * @param string $param2 параметр 2
	 *
	 * @throws Exception
	 *
	 * @return void
	 */
	public function actionIndex($section = null, $param1 = null, $param2 = null)
	{
		$model = SectionModel::model()->byUrl($section)->find();
		if (!$model) {
			throw new Exception(Language::t("default", "Раздел не найден"), 404);
		}

		//$grids = GridModel::model()->bySectionId($model->id)->withContent()->findAll();
		//if (!$grids) {
		//	throw new Exception(Language::t("default", "Не определена структура для раздела"));
		//}

		$this->render("index", array("model" => $model, "grids" => null));
	}
}