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
	 */
	public function actionSettings()
	{
		$model = $this->_getModel(["seoModel"]);

		$this->json = [
			"back"        => "section.panelList",
			"title"       => Language::t("common", "Настройки раздела"),
			"description" => Language::t("common", "Здесь вы можете редактировать название и СЕО"),
			"save"        => [
				"label"  => Language::t("common", "Сохранить"),
				"action" => "section.saveSettings",
				"id"     => intval($model->id)
			],
		];

		if ($model->id) {
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

		$forms = [
				"seoModel.name",
				"seoModel.url",
				"t.width",
				"seoModel.title",
				"seoModel.keywords",
				"seoModel.description"
		];
		if (!$model->is_main) {
			$forms[] = "t.is_main";
		}

		$this->setFormsForJson($model, $forms);
	}

	/**
	 * Saves settings
	 *
	 * @param array $data Data from POST
	 *
	 * @throws Exception
	 *
	 * @return void
	 */
	public function actionSaveSettings($data)
	{
		$model = $this->_getModel(["seoModel"]);
		$model->setAttributes($data)->save();

		$this->json = [
				"errors" => $model->errors,
				"data"   => [
						"content" => "section.panelList",
				]
		];
	}

	/**
	 * Window for grid editing
	 *
	 * @throws Exception
	 */
	public function actionWindow()
	{
		$model = $this->_getModel(["seoModel"]);

		if (!$model->id) {
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

	private function _getModel($width = [])
	{
		if (!$this->id) {
			return new SectionModel();
		}

		$model = SectionModel::model()->byId($this->id)->with($width)->find();
		if (!$model) {
			throw new Exception(Language::t("default", "Модель не найдена"), 404);
		}

		return $model;
	}
}