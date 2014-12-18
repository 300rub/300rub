<?php

namespace controllers;

use models\GridModel;
use system\base\Controller;
use models\SectionModel;
use system\base\Exception;
use system\base\Language;

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
	 * @throws Exception
	 *
	 * @return void
	 */
	public function actionIndex()
	{
		$model = SectionModel::model()->byUrl($this->section)->find();
		if (!$model) {
			throw new Exception(Language::t("default", "Раздел не найден"), 404);
		}

		$grids = GridModel::model()->bySectionId($model->id)->withContent()->findAll();
		if (!$grids) {
			throw new Exception(Language::t("default", "Не определена структура для раздела"));
		}

		$this->render("index", array("model" => $model, "grids" => $grids));
	}
}