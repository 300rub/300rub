<?php

namespace controllers;

use models\DesignBlockModel;
use models\GridModel;
use models\SeoModel;
use models\SectionModel;
use system\web\Controller;
use system\base\Exception;
use system\web\Language;

/**
 * Section's controller
 *
 * @package controllers
 */
class SectionController extends Controller
{

	/**
	 * List of sections in panel
	 */
	public function actionPanelList()
	{
		$list = [];
		$models = SectionModel::model()->ordered()->findAll();

		foreach ($models as $model) {
			$item = [
				"label" => $model->seoModel->name,
				"id"    => $model->id
			];
			if ($model->is_main) {
				$item["icon"] = "main";
			}
			$list[] = $item;
		}

		$this->json = [
			"title"       => Language::t("section", "Sections"),
			"description" => Language::t("section", "Sections panel description"),
			"list"        => $list,
			"content"     => "section.grid",
			"design"      => "section.design",
			"settings"    => "section.settings",
			"add"         => Language::t("common", "Add"),
		];
	}

	/**
	 * Section's settings
	 *
	 * @param array $data Data from POST
	 *
	 * @throws Exception
	 *
	 * @return void
	 */
	public function actionSettings($data)
	{
		$id = !empty($id) ? intval($id) : 0;

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
			"back"        => "section.panelList",
			"title"       => Language::t("common", "Настройки раздела"),
			"description" => Language::t("common", "Здесь вы можете редактировать название и СЕО"),
			"save"        => [
				"label"  => Language::t("common", "Сохранить"),
				"action" => "section.saveSettings",
				"id"     => $model->id
			],
		];

		if ($id) {
			$this->json["duplicate"] = [
				"label"   => Language::t("common", "Дублировать"),
				"action"  => "section.duplicate",
				"id"      => $model->id,
				"content" => "section.settings",
			];
			$this->json["delete"] = [
				"label"    => Language::t("common", "Удалить"),
				"action"   => "section.delete",
				"id"       => $model->id,
				"confirm"  => Language::t("common", "Вы действительно хотите удалить раздел?"),
				"content"  => "section.panelList",
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
	}

	/**
	 * Сохраняет настройки раздела
	 *
	 * @throws Exception
	 *
	 * @return void
	 */
	public function actionSaveSettings()
	{
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
			$designBlockModel = new DesignBlockModel();
			if (!$designBlockModel->save()) {
				throw new Exception(Language::t("common", "Не удалось создать дизайн"), 404);
			}
			$model = new SectionModel;
			$model->language = Language::$activeId;
			$model->seoModel = new SeoModel();
			$model->design_block_id = $designBlockModel->id;
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
	}

	/**
	 * Сетка
	 *
	 * @throws Exception
	 *
	 * @return void
	 */
	public function actionWindow()
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
	}

	/**
	 * Сохраняет сетку
	 *
	 * @throws Exception
	 */
	public function actionSaveWindow()
	{
		$this->json = false;

		if (!$id) {
			throw new Exception(Language::t("common", "Некорректный идентификатор"), 404);
		}

		$model = SectionModel::model()->byId($id)->find();
		if (!$model) {
			throw new Exception(Language::t("default", "Раздел не найден"), 404);
		}

		$this->json = GridModel::model()->updateGridForSection($model->id, $data);
	}

	public function actionDelete()
	{
		if (!$id) {
			throw new Exception(Language::t("common", "Некорректный идентификатор"), 404);
		}

		$model = SectionModel::model()->byId($id)->withAll()->find();
		if (!$model) {
			throw new Exception(Language::t("default", "Раздел не найден"), 404);
		}

		$this->json = $model->delete();
	}

	/**
	 * @throws Exception
	 */
	public function actionDuplicate()
	{
		if (!$id) {
			throw new Exception(Language::t("common", "Некорректный идентификатор"), 404);
		}

		$model = SectionModel::model()->byId($id)->withAll()->find();
		if (!$model) {
			throw new Exception(Language::t("default", "Раздел не найден"), 404);
		}

		$this->json = $model->duplicate();
	}

	/**
	 * @throws Exception
	 *
	 * @return void
	 */
	public function actionDesign()
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
	}

	/**
	 * @throws Exception
	 *
	 * @return void
	 */
	public function actionSaveDesign()
	{
		$model = SectionModel::model()->byId($id)->with(["designBlockModel"])->find();

		if (!$model) {
			throw new Exception(Language::t("default", "Модель не найдена"), 404);
		}

		$this->json = [
			"success" => $model->saveDesign($post),
			"errors"  => $model->errors,
			"content" => "section/panelList",
		];
	}
}