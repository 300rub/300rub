<?php

namespace controllers;

use models\BlockModel;
use models\GridModel;
use models\SeoModel;
use models\TextModel;
use system\db\Db;
use system\web\Controller;
use models\SectionModel;
use system\base\Exception;
use system\web\Language;
use system\App;

/**
 * @package controllers
 */
class TextController extends Controller
{

	public function actionPanelList()
	{
		$items = [];
		$models = TextModel::model()->findAll();

		foreach ($models as $model) {
			$items[] = [
				"label" => $model->name,
				"id"    => $model->id
			];
		}

		$this->json = [
			"title"       => Language::t("common", "Тексты"),
			"description" => Language::t(
				"common",
				"Выберите текст для редактирования"
			),
			"list"        => [
				"class"   => "panel",
				"items"   => $items,
				"content" => "text/edit",
				"icons"   => [
					"big"      => true,
					"design"   => "text/design",
					"settings" => "text/settings",
				],
			],
			"errors"      => [],
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
	public function actionDesign($id = 0)
	{
		if ($id) {
			$model = TextModel::model()->byId($id)->withAll()->find();
		} else {
			$model = new TextModel;
		}

		if (!$model) {
			throw new Exception(Language::t("default", "Модель не найдена"), 404);
		}

		$this->json = [
			"title"       => Language::t("common", "Дизайн текстового блока"),
			"description" => Language::t("common", "123"),
			"button"      => [
				"label"  => Language::t("common", "Сохранить"),
				"action" => "text/saveDesign/{$model->id}"
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

		$model = TextModel::model()->byId($id)->withAll()->find();

		if (!$model) {
			throw new Exception(Language::t("default", "Модель не найдена"), 404);
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
			"content" => "text/panelList",
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
	public function actionSettings($id = 0)
	{
		if ($id) {
			$model = TextModel::model()->byId($id)->find();
		} else {
			$model = new SectionModel;
		}

		if (!$model) {
			throw new Exception(Language::t("default", "Модель не найдена"), 404);
		}

		$this->json = [
			"title"       => Language::t("common", "Настройки текста"),
			"description" => Language::t("common", "333"),
			"button"      => [
				"label"  => Language::t("common", "Сохранить"),
				"action" => "text/saveSettings/{$model->id}"
			],
		];
		$this->setFormsForJson(
			$model,
			["t.name"]
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
			|| !isset($post["t.name"])
		) {
			throw new Exception(Language::t("common", "Некорректрый url"), 404);
		}

		if ($id) {
			$model = TextModel::model()->byId($id)->find();
		} else {
			$model = new TextModel;
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
			"content" => "text/panelList",
		];

		$this->renderJson();
	}
}