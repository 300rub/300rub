<?php

namespace system\web;

use system\base\Exception;
use system\base\Model;

/**
 * Abstract class for working with controllers
 *
 * @package system.web
 */
abstract class Controller
{

	/**
	 * Data from $_POST
	 *
	 * @var array
	 */
	public $data = [];

	/**
	 * Model ID
	 *
	 * @var int
	 */
	protected $id = 0;

	/**
	 * Layout
	 *
	 * @var string
	 */
	protected $layout = "";

	/**
	 * JSON
	 *
	 * @var array
	 */
	protected $json = [];

	/**
	 * Gets model name
	 *
	 * @return string
	 */
	abstract protected function getModelName();

	/**
	 * Display content with layout
	 *
	 * @param string $viewFile View file
	 * @param array  $data     Data
	 * @param bool   $isReturn Is return result
	 *
	 * @return string|void
	 */
	protected function render($viewFile, $data = [], $isReturn = false)
	{
		$path = $this->getViewsRootDir() . "{$this->layout}.php";

		$content = $this->renderPartial($viewFile, $data, true);

		if (!$isReturn) {
			require($path);
		}

		ob_start();
		ob_implicit_flush(false);
		require($path);
		return ob_get_clean();
	}

	/**
	 * Display content with layout
	 *
	 * @param string $viewFile View file
	 * @param array  $data     Data
	 * @param bool   $isReturn Is return result
	 *
	 * @return string|void
	 */
	protected function renderPartial($viewFile, $data = [], $isReturn = false)
	{
		$path = $this->getViewsRootDir() . $viewFile . ".php";

		extract($data, EXTR_OVERWRITE);

		if (!$isReturn) {
			require($path);
		}

		ob_start();
		ob_implicit_flush(false);
		require($path);
		return ob_get_clean();
	}

	/**
	 * Gets path to views root dir
	 *
	 * @return string
	 */
	protected function getViewsRootDir()
	{
		return __DIR__ . "/../../views/";
	}

	/**
	 * Adds forms into JSON
	 *
	 * @param Model    $model  Model
	 * @param string[] $fields Fields
	 *
	 * @throws Exception
	 *
	 * @return Controller
	 */
	protected function setFormsForJson($model, $fields)
	{
		if (!$model) {
			throw new Exception("Не удалось получить модель");
		}

		if (!$fields) {
			throw new Exception("Не указаны формы");
		}

		$forms = [];

		foreach ($fields as $field) {
			list($objectName, $field) = explode(".", $field, 2);

			$m = null;
			if ($objectName === Model::OBJECT_NAME) {
				$m = $model;
			} else {
				if (property_exists($model, $objectName)) {
					$m = $model->$objectName;
					if (!$m) {
						$className = $model->getRelationClass($objectName);
						$m = new $className;
					}
				}
			}

			if ($m && property_exists($m, $field)) {
				$forms[$objectName . Model::DEFAULT_SEPARATOR . $field] = [
					"rules"  => $m->getRules($field),
					"label"  => $m->getLabel($field),
					"value"  => $m->$field,
				];
			}
		}

		if ($forms) {
			$this->json["forms"] = $forms;
		}

		return $this;
	}

	/**
	 * Gets model
	 *
	 * @param string[] $width      Relations
	 * @param bool     $allowEmpty Allows empty ID
	 *
	 * @return \system\base\Model
	 *
	 * @throws Exception
	 */
	protected function getModel($width = [], $allowEmpty = false)
	{
		$modelName = $this->getModelName();
		if (!$modelName) {
			throw new Exception(Language::t("common", "bla bla bla"), 500);
		}

		/**
		 * @var \system\base\Model $model
		 */
		$model = new $modelName;
		if (!$model) {
			throw new Exception(Language::t("common", "bla bla bla"), 500);
		}

		if (!$this->id && !$allowEmpty) {
			throw new Exception(Language::t("common", "Некорректный идентификатор"), 404);
		}

		if (!$this->id) {
			return $model;
		}

		$model = $model->byId($this->id)->with($width)->find();
		if (!$model) {
			throw new Exception(Language::t("default", "Модель не найдена"), 404);
		}

		return $model;
	}

	/**
	 * Panel. Deletes model
	 */
	public function actionDelete()
	{
		$this->json = ["result" => $this->getModel("*")->delete()];
	}

	/**
	 * Panel. Duplicates model
	 */
	public function actionDuplicate()
	{
		$this->json = ["result" => $this->getModel("*")->duplicate()];
	}
}