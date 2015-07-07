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
	 * @param string $param1  параметр 1
	 * @param string $param2  параметр 2
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

		$this->render("index", ["model" => $model, "grids" => null]);
	}

	public function actionPanelList()
	{
		$items = [];
		$models = SectionModel::model()->ordered()->findAll();

		foreach ($models as $model) {
			$items[] = [
				"label" => $model->seoModel->name,
				"id"    => $model->id
			];
		}

		$this->json = [
			"title"       => Language::t("common", "Разделы"),
			"description" => Language::t(
				"common",
				"Чтобы добавить раздел, нажмите плюсик. Чтобы изменить структуру раздела нажмите на его название. Отредактировать СЕО - нажмите на шестеренку."
			),
			"list"        => [
				"class"   => "grid",
				"items"   => $items,
				"content" => "section/grid",
				"icons"   => [
					"big"      => false,
					"design"   => false,
					"settings" => "section/settings",
				],
			],
			"errors"      => [],
		];

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
			$model = SectionModel::model()->byId($id)->with(["seoModel"])->find();
		} else {
			$model = new SectionModel;
		}

		if (!$model) {
			throw new Exception(Language::t("default", "Раздел не найден"), 404);
		}

		$this->json = [
			"title"       => Language::t("common", "Настройки раздела"),
			"description" => Language::t("common", "Здесь вы можете редактировать название и СЕО"),
			"button"      => [
				"label"  => Language::t("common", "Сохранить"),
				"action" => "section/saveSettings/{$model->id}"
			],
		];
		$this->setFormsForJson(
			$model,
			["seoModel.name", "seoModel.url", "seoModel.title", "seoModel.keywords", "seoModel.description"]
		);

		$this->renderJson();
	}

	/**
	 * Сохраняет настройки раздела
	 *
	 * @param int $id идентификатор раздела
	 *
	 * @throws Exception
	 *
	 * @return void
	 */
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
			$model = SectionModel::model()->byId($id)->with(["seoModel"])->find();
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

		$this->json = [
			"success" => $success,
			"errors"  => $model->errors,
			"content" => "section/panelList",
		];

		$this->renderJson();
	}

	/**
	 * Сетка
	 *
	 * @param int $id идентификатор раздела
	 *
	 * @throws Exception
	 *
	 * @return void
	 */
	public function actionGrid($id = 0)
	{
		if (!$id) {
			throw new Exception(Language::t("common", "Некорректный идентификатор"), 404);
		}

		$model = SectionModel::model()->byId($id)->with(["seoModel"])->find();
		if (!$model) {
			throw new Exception(Language::t("default", "Раздел не найден"), 404);
		}

		$blocks = [
			1 => [
				"name"   => "Текст",
				"class"  => "text",
				"blocks" => [
					1 => "Блок 1",
					2 => "Блок 2",
				]
			],
			2 => [
				"name"   => "Изображения",
				"class"  => "image",
				"blocks" => [
					3 => "Блок 3",
					4 => "Блок 4",
					5 => "Блок 5",
					6 => "Блок 6",
					7 => "Блок 7",
					8 => "Блок 8",
				]
			]
		];

		$grid = [
			[
				[
					"id"       => 1,
					"x"        => 0,
					"y"        => 0,
					"width"    => 4,
					"cssClass" => "text",
					"name"     => "Блок 1",
				],
				[
					"id"       => 2,
					"x"        => 8,
					"y"        => 0,
					"width"    => 4,
					"cssClass" => "text",
					"name"     => "Блок 2",
				]
			],
			[
				[
					"id"       => 3,
					"x"        => 0,
					"y"        => 0,
					"width"    => 3,
					"cssClass" => "image",
					"name"     => "Блок 3",
				],
				[
					"id"       => 4,
					"x"        => 1,
					"y"        => 1,
					"width"    => 5,
					"cssClass" => "image",
					"name"     => "Блок 4",
				]
			]
		];

		$this->json = [
			"title"  => $model->seoModel->name,
			"button" => [
				"label"  => Language::t("common", "Сохранить"),
				"action" => "section/saveGrid/{$model->id}"
			],
			"blocks" => $blocks,
			"grid"   => $grid
		];

		$this->renderJson();
	}

	/**
	 * Сохраняет сетку
	 *
	 * @param int $id идентификатор раздела
	 */
	public function actionSaveGrid($id)
	{
		var_dump($id);
		var_dump(App::getPost("data"));
	}
}