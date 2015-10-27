<?php

namespace controllers;

use models\BlockModel;
use models\GridLineModel;
use models\GridModel;
use models\SeoModel;
use system\db\Db;
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
		$model = SectionModel::model()->byUrl($section)->with(["designBlockModel"])->find();
		if (!$model) {
			$this->render("empty");
		} else {
			$this->render(
				"index",
				["model" => $model, "structure" => GridModel::model()->getStructure($model)]
			);
		}
	}

	public function actionPanelList()
	{
		$items = [];
		$models = SectionModel::model()->ordered()->findAll();

		foreach ($models as $model) {
			$item = [
				"label" => $model->seoModel->name,
				"id"    => $model->id
			];
			if ($model->is_main) {
				$item["icon"] = "section-main";
			}
			$items[] = $item;
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
					"design"   => "section/design",
					"settings" => "section/settings",
				],
			],
			"add"         => [
				"label"   => Language::t("common", "Добавить"),
				"content" => "section/settings",
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
			$model->width = SectionModel::DEFAULT_WIDTH;
			$model->seoModel = new SeoModel();
		}

		if (!$model) {
			throw new Exception(Language::t("default", "Раздел не найден"), 404);
		}

		$this->json = [
			"back"        => "section/panelList",
			"title"       => Language::t("common", "Настройки раздела"),
			"description" => Language::t("common", "Здесь вы можете редактировать название и СЕО"),
			"button"      => [
				"label"  => Language::t("common", "Сохранить"),
				"action" => "section/saveSettings/{$model->id}"
			],
		];

		if ($id) {
			$this->json["duplicate"] = [
				"label"   => Language::t("common", "Дублировать"),
				"action"  => "section/duplicate/{$model->id}",
				"content" => "section/settings",
			];
			$this->json["delete"] = [
				"label"    => Language::t("common", "Удалить"),
				"action"   => "section/delete/{$model->id}",
				"confirm"  => Language::t("common", "Вы действительно хотите удалить раздел?"),
				"cssClass" => "section-{$id}",
				"content"  => "section/panelList",
			];
		}

		if ($model->is_main) {
			$forms =
				[
					"seoModel.name",
					"seoModel.url",
					"t.width",
					"seoModel.title",
					"seoModel.keywords",
					"seoModel.description"
				];
		} else {
			$forms =
				[
					"seoModel.name",
					"seoModel.url",
					"t.is_main",
					"t.width",
					"seoModel.title",
					"seoModel.keywords",
					"seoModel.description"
				];
		}
		$this->setFormsForJson($model, $forms);

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
			$model->language = Language::$activeId;
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

		$this->json = [
			"title"  => $model->seoModel->name,
			"button" => [
				"label"  => Language::t("common", "Сохранить"),
				"action" => "section/saveGrid/{$model->id}"
			],
			"blocks" => GridModel::model()->getAllBlocksForGridWindow(),
			"grid"   => GridModel::model()->getAllGridsForGridWindow($model->id)
		];

		$this->renderJson();
	}

	/**
	 * Сохраняет сетку
	 *
	 * @param int $id идентификатор раздела
	 *
	 * @throws Exception
	 */
	public function actionSaveGrid($id)
	{
		$this->json = false;

		if (!$id) {
			throw new Exception(Language::t("common", "Некорректный идентификатор"), 404);
		}

		$model = SectionModel::model()->byId($id)->find();
		if (!$model) {
			throw new Exception(Language::t("default", "Раздел не найден"), 404);
		}

		$data = App::getPost("data");
		$this->json = GridModel::model()->updateGridForSection($model->id, $data);
		$this->renderJson();
	}

	public function actionDelete($id)
	{
		if (!$id) {
			throw new Exception(Language::t("common", "Некорректный идентификатор"), 404);
		}

		$model = SectionModel::model()->byId($id)->with(["seoModel"])->find();
		if (!$model) {
			throw new Exception(Language::t("default", "Раздел не найден"), 404);
		}

		$this->json = $model->delete();
		$this->renderJson();
	}

	public function actionDuplicate($id)
	{
		if (!$id) {
			throw new Exception(Language::t("common", "Некорректный идентификатор"), 404);
		}

		$model = SectionModel::model()->byId($id)->with(["seoModel"])->find();
		if (!$model) {
			throw new Exception(Language::t("default", "Раздел не найден"), 404);
		}

		$this->json = $model->duplicate();
		$this->renderJson();
	}

	/**
	 * @param int $id
	 *
	 * @throws Exception
	 *
	 * @return void
	 */
	public function actionDesign($id = 0)
	{
		if ($id) {
			$model = SectionModel::model()->byId($id)->with(["designBlockModel"])->find();
		} else {
			$model = new SectionModel;
		}

		if (!$model) {
			throw new Exception(Language::t("default", "Модель не найдена"), 404);
		}

		$this->json = [
			"back"        => "section/panelList",
			"title"       => Language::t("common", "Дизайн раздела"),
			"description" => Language::t("common", "123"),
			"button"      => [
				"label"  => Language::t("common", "Сохранить"),
				"action" => "section/saveDesign/{$model->id}"
			],
			"design"      => $model->getDesignForms()
		];

		$this->renderJson();
	}

	/**
	 * @param int $id
	 *
	 * @throws Exception
	 *
	 * @return void
	 */
	public function actionSaveDesign($id = 0)
	{
		$post = App::getPost();

		$model = SectionModel::model()->byId($id)->with(["designBlockModel"])->find();

		if (!$model) {
			throw new Exception(Language::t("default", "Модель не найдена"), 404);
		}

		$this->json = [
			"success" => $model->saveDesign($post),
			"errors"  => $model->errors,
			"content" => "section/panelList",
		];

		$this->renderJson();
	}
}