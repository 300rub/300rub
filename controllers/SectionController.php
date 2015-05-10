<?php

namespace controllers;

use models\SeoModel;
use system\web\Controller;
use models\SectionModel;
use system\base\Exception;
use system\web\Language;
use system\App;

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

	public function actionPanelList()
	{
		$items = array();
		$models = SectionModel::model()->ordered()->findAll();

		foreach ($models as $model) {
			$items[] = array(
				"label" => $model->seoModel->name,
				"id"    => $model->id
			);
		}

		$this->json = array(
			"title"       => Language::t("common", "Разделы"),
			"description" => Language::t("common", "Чтобы добавить раздел, нажмите плюсик. Чтобы изменить структуру раздела нажмите на его название. Отредактировать СЕО - нажмите на шестеренку."),
			"list"        => array(
				"class" => "grid",
				"items" => $items,
				"icons" => array(
					"big"      => false,
					"design"   => false,
					"settings" => "section/settings",
				),
			),
			"errors"      => array(),
		);

		$this->renderJson();
	}

	/**
	 * Настройки раздела
	 *
	 * @param int $id идентификатор раздела
	 *
	 * @throws Exception
	 *
	 * @return void
	 */
	public function actionSettings($id = 0)
	{
		if ($id) {
			$model = SectionModel::model()->byId($id)->with(array("seoModel"))->find();
		} else {
			$model = new SectionModel;
		}

		if (!$model) {
			throw new Exception(Language::t("default", "Раздел не найден"), 404);
		}

		$this->json = array(
			"title"       => Language::t("common", "Настройки раздела"),
			"description" => Language::t("common", "Здесь вы можете редактировать название и СЕО"),
			"button"      => array(
				"label"  => Language::t("common", "Сохранить"),
				"action" => "section/saveSettings/{$model->id}"
			),
		);
		$this->setFormsForJson(
			$model,
			array("seoModel.name", "seoModel.url", "seoModel.title", "seoModel.keywords", "seoModel.description")
		);

		$this->renderJson();
	}

	public function actionSaveSettings($id = 0)
	{
		$post = App::getPost();
		if (
			!$post
			|| !isset($post["seoModel.name"])
			|| !isset($post["seoModel.url"])
			|| !isset($post["seoModel.title"])
			|| !isset($post["seoModel.keywords"])
			|| !isset($post["seoModel.description"])
		) {
			throw new Exception(Language::t("common", "Некорректрый url"), 404);
		}

		if ($id) {
			$model = SectionModel::model()->byId($id)->with(array("seoModel"))->find();
		} else {
			$model = new SectionModel;
			$model->seoModel = new SeoModel();
		}

		$model->setAttributes($post);
		$model->validate(false);

		$success = false;

		if (!$model->errors && $model->save()) {
			$success = true;
		}

		$this->json = array(
			"success" => $success,
			"errors"  => $model->errors,
			"content" => "section/panelList",
		);

		$this->renderJson();
	}
}