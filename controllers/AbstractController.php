<?php

namespace testS\controllers;

use testS\applications\App;
use testS\components\exceptions\ContentException;
use testS\components\exceptions\ModelException;
use testS\models\AbstractModel;
use testS\models\GridLineModel;
use testS\models\GridModel;

/**
 * Abstract class for working with controllers
 *
 * @package testS\controllers
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
	 * @return AbstractController
	 */
	protected function setFormsForJson($model, $fields)
	{
		$forms = $this->_getForms($model, $fields);

		if ($forms) {
			$this->json["forms"] = $forms;
		}

		return $this;
	}

	/**
	 * Gets forms
	 *
	 * @param AbstractModel $model
	 * @param array         $fields
	 *
	 * @return array
	 */
	private function _getForms(AbstractModel $model, array $fields)
	{
		$forms = [];

		foreach ($fields as $key => $value) {
			if (is_array($value)) {
				/**
				 * @var AbstractModel $model
				 */
				$model = $model->$key;
				if (!$model instanceof AbstractModel) {
					$relationId = $model->getRelationKey($key);
					$relationClassName = $model->getRelationClass($key);
					$model = new $relationClassName;
					$model = $model->byId($relationId)->find();
				}

				$forms[$key] = $this->_getForms($model, $value);
			} else {
				$forms[$value] = [
					"rules" => $model->getRulesForField($value),
					"type"  => $model->getFormType($value),
					"value" => $model->$value
				];;
			}
		}

		return $forms;
	}

	/**
	 * Gets model
	 *
	 * @param string[] $width      Relations
	 * @param bool     $allowEmpty Allows empty ID
	 *
	 * @return AbstractModel
	 *
	 * @throws ModelException
	 */
	protected function getModel($width = [], $allowEmpty = false)
	{
		$className = "\\models\\" . $this->getModelName();
		if (!class_exists($className)) {
			throw new ModelException(
				"Unable to find class: {class}",
				[
					"class" => $className
				]
			);
		}

		/**
		 * @var AbstractModel $model
		 */
		$model = new $className;

		$id = 0;
		if (!empty($this->data["id"])) {
			$id = intval($this->data["id"]);
		}

		if ($id === 0 && !$allowEmpty) {
			throw new ModelException("ID can not be null");
		}

		if (!$id) {
			return $model;
		}

		$model = $model->byId($id)->with($width)->find();
		if (!$model) {
			throw new ModelException(
				"Unable to find model for class: {class} by ID = {id}",
				[
					"class" => $className,
					"id"    => $id
				]
			);
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
		$model = $this->getModel("*")->duplicate();
		if (!$model instanceof AbstractModel) {
			throw new ContentException("Incorrect duplicate data");
		}

		$this->json = ["result" => $model->id];
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

	/**
	 * Compresses HTML
	 *
	 * @param string $code
	 *
	 * @return string
	 */
	protected function compressHtml($code)
	{
		for ($i = 10; $i > 1; $i--) {
			$code = str_replace(str_repeat(" ", $i), " ", $code);
		}
		return trim(str_replace("\n", "", $code));
	}

	/**
	 * Returns a flag of displaying from the page
	 *
	 * @return bool
	 */
	protected function isDisplayFromPage()
	{
		$isDisplayFromPage = false;

		if (isset($_SESSION["__isDisplayFromPage"])) {
			$isDisplayFromPage = $_SESSION["__isDisplayFromPage"];
		} else if (isset($_COOKIE["__isDisplayFromPage"])) {
			$isDisplayFromPage = $_COOKIE["__isDisplayFromPage"];
		}

		return boolval($isDisplayFromPage);
	}

	/**
	 * Sets the flag of displaying from the page
	 * 
	 * @return AbstractController
	 */
	protected function setIsDisplayFromPage()
	{
		if (array_key_exists("isDisplayFromPage", $this->data)) {
			if ($this->data["isDisplayFromPage"] === true) {
				$isDisplayFromPage = true;
			} else {
				$isDisplayFromPage = false;
			}

			setcookie("__isDisplayFromPage", $isDisplayFromPage, 0x6FFFFFFF);
			$_SESSION["__isDisplayFromPage"] = $isDisplayFromPage;
		}
		
		return $this;
	}

	/**
	 * Filters a list of models
	 *
	 * @param models/AbstractModel[] $models Array of models for filtering
	 * @param int                    $type   Type
	 *
	 * @return array
	 */
	protected function filterList($models, $type)
	{
		$isDisplayFromPage = $this->setIsDisplayFromPage()->isDisplayFromPage();

		if ($isDisplayFromPage === false) {
			return $models;
		}

		$list = [];
		$gridModels = GridModel::model()->bySectionId($this->data["sectionId"])->findAll();

		foreach ($models as $model) {
			foreach ($gridModels as $gridModel) {
				if ($gridModel->contentId === $model->id && $gridModel->contentType === $type) {
					$list[] = $model;
				}
			}
		}

		return $list;
	}
}