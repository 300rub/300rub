<?php

namespace controllers;

use application\App;
use components\ErrorHandler;
use components\Exception;
use models\AbstractModel;

/**
 * Abstract class for working with controllers
 *
 * @package controllers
 */
abstract class AbstractController
{

	/**
	 * Action separator
	 */
	const ACTION_SEPARATOR = ".";

	/**
	 * Data from AJAX
	 *
	 * @var array
	 */
	public $data = [];

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
	public $json = [];

	/**
	 * Gets model name
	 *
	 * @return string
	 */
	abstract protected function getModelName();

	/**
	 * Gets guest actions
	 *
	 * @return string[]
	 */
	abstract protected function getGuestActions();

	/**
	 * Checks access for action
	 *
	 * @param string $action Action name
	 *
	 * @return bool
	 */
	public function hasAccess($action)
	{
		if (App::web()->user !== null) {
			return true;
		}

		if (
			App::web()->user === null
			&& in_array($action, $this->getGuestActions())
		) {
			return true;
		}

		return false;
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
	protected function render($viewFile, $data = [], $isReturn = false)
	{
		$path = $this->getViewsRootDir() . str_replace(".", "/", $this->layout) .".php";

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
		$path = $this->getViewsRootDir() . str_replace(".", "/", $viewFile) . ".php";

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
		return __DIR__ . "/../views/";
	}

	/**
	 * Adds forms into JSON
	 *
	 * @param AbstractModel $model  Model
	 * @param string[]      $fields Fields
	 *
	 * @throws Exception
	 *
	 * @return AbstractController
	 */
	protected function setFormsForJson($model, $fields)
	{
		$forms = [];

		foreach ($fields as $field) {
			list($objectName, $field) = explode(AbstractModel::DEFAULT_SEPARATOR, $field, 2);

			$m = null;
			if ($objectName === AbstractModel::OBJECT_NAME) {
				$m = $model;
			} else if (property_exists($model, $objectName)) {
				$m = $model->$objectName;
				if (!$m) {
					$className = $model->getRelationClass($objectName);
					$m = new $className;
				}
			}

			if ($m && property_exists($m, $field)) {
				$forms[] = [
					"name"  => $objectName . AbstractModel::DEFAULT_SEPARATOR . $field,
					"rules" => $m->getRulesForField($field),
					"type"  => $m->getFormType($field),
					"value" => $m->$field
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
	 * @return AbstractModel
	 *
	 * @throws Exception
	 */
	protected function getModel($width = [], $allowEmpty = false)
	{
		$modelName = $this->getModelName();
		if (!$modelName) {
			throw new Exception("Model not found", ErrorHandler::STATUS_NOT_FOUND);
		}

		$className = "\\models\\{$modelName}";
		if (!class_exists($className)) {
			throw new Exception("Class \"$className\" doesn't exists");
		}

		/**
		 * @var AbstractModel $model
		 */
		$model = new $className;

		$id = 0;
		if (!empty($this->data["id"])) {
			$id = intval($this->data["id"]);
		}

		if (!$id && !$allowEmpty) {
			throw new Exception("Incorrect ID", ErrorHandler::STATUS_NOT_FOUND);
		}

		if (!$id) {
			return $model;
		}

		$model = $model->byId($id)->with($width)->find();
		if (!$model) {
			throw new Exception("Model not found", ErrorHandler::STATUS_NOT_FOUND);
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

	/**
	 * Sets checkbox value for data
	 * 
	 * @param string $value Field name
	 * 
	 * @return AbstractController
	 */
	protected function setCheckboxValue($value)
	{
		if (!isset($this->data[$value])) {
			$this->data[$value] = 0;
		} else {
			$this->data[$value] = 1;
		}

		return $this;
	}
}