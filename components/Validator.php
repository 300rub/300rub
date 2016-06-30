<?php

namespace components;

use models\AbstractModel;

/**
 * Class for validation model's fields
 *
 * @package components
 */
class Validator
{

	/**
	 * Model
	 *
	 * @var AbstractModel
	 */
	private $_model = null;

	/**
	 * Errors
	 *
	 * @var array
	 */
	private $_errors = [];

	/**
	 * Object name
	 *
	 * @var string
	 */
	private $_objectName = "";

	/**
	 * Map for verification
	 *
	 * @var array
	 */
	private $_mapForVerification = [];

	/**
	 * Constructor
	 *
	 * @param AbstractModel  $model      Model
	 * @param string         $objectName Object name
	 */
	public function __construct($model, $objectName = AbstractModel::OBJECT_NAME)
	{
		$this->_model = $model;
		$this->_objectName = $objectName;
	}

	/**
	 * Validation
	 *
	 * @return array
	 */
	public function validate()
	{
		return $this->_setMap()->_parseMap()->_getErrors();
	}

	/**
	 * Sets map
	 *
	 * @return Validator
	 */
	private function _setMap()
	{
		foreach ($this->_model->getRules() as $field => $types) {
			foreach ($types as $key => $value) {
				$this->_mapForVerification[] = [
					"method" => is_string($key) ? $key : $value,
					"field"  => $field,
					"value"  => $value
				];
			}
		}

		return $this;
	}

	/**
	 * Parses map
	 *
	 * @return Validator
	 */
	private function _parseMap()
	{
		foreach ($this->_mapForVerification as $item) {
			switch ($item["method"]) {
				case "required":
					$this->_required($item["field"]);
					break;
				case "max":
					$this->_max($item["field"], $item["value"]);
					break;
				case "relation":
					$this->_relation($item["field"], $item["value"]);
					break;
				case "min":
					$this->_min($item["field"], $item["value"]);
					break;
				case "url":
					$this->_url($item["field"]);
					break;
				case "latinDigitUnderscoreHyphen":
					$this->_latinDigitUnderscoreHyphen($item["field"]);
					break;
				default:
					break;
			}
		}

		return $this;
	}

	/**
	 * Gets errors
	 *
	 * @return array
	 */
	private function _getErrors()
	{
		return $this->_errors;
	}

	/**
	 * Adds error
	 *
	 * @param string $field Field
	 * @param string $value Value
	 *
	 * @return Validator
	 */
	private function _addError($field, $value)
	{
		$fieldsName = $this->_objectName . AbstractModel::DEFAULT_SEPARATOR . $field;
		if (!array_key_exists($fieldsName, $this->_errors)) {
			$this->_errors[$fieldsName] = $value;
		}

		return $this;
	}

	/**
	 * Verifies required
	 *
	 * @param string $field Field name
	 *
	 * @return void
	 */
	private function _required($field)
	{
		if ($this->_model->$field === "") {
			$this->_addError($field, "required");
		}
	}

	/**
	 * Verifies string length for max value
	 *
	 * @param string $field Field's name
	 * @param int    $max   Max value
	 *
	 * @return void
	 */
	private function _max($field, $max)
	{
		if (mb_strlen($this->_model->$field) > $max) {
			$this->_addError($field, "max");
		}
	}

	/**
	 * Verifies relation
	 *
	 * @param string $field             Field's name
	 * @param string $relationClassName Relation Class Name
	 *
	 * @return void
	 */
	private function _relation($field, $relationClassName)
	{
		if ($this->_model->$field === 0) {
			$this->_addError($field, "relation");
		} else {
			/**
			 * @var \models\AbstractModel $model;
			 */
			$model = new $relationClassName;
			if ($model->byId($this->_model->$field)->find() === null) {
				$this->_addError($field, "relation");
			}
		}
	}

	/**
	 * Verifies string length for min value
	 *
	 * @param string $field Field's name
	 * @param int    $min   Min value
	 *
	 * @return void
	 */
	private function _min($field, $min)
	{
		if (mb_strlen($this->_model->$field) < $min) {
			$this->_addError($field, "min");
		}
	}

	/**
	 * Verifies URL
	 *
	 * @param string $field Field name
	 *
	 * @return void
	 */
	private function _url($field)
	{
		if (
			$this->_model->$field
			&& !preg_match("/^[0-9a-z-]+$/i", $this->_model->$field)
		) {
			$this->_addError($field, "url");
		}
	}

	/**
	 * Verifies regex: latin, digit, underscore, hyphen
	 *
	 * @param string $field Field name
	 *
	 * @return void
	 */
	private function _latinDigitUnderscoreHyphen($field)
	{
		if (
			$this->_model->$field
			&& !preg_match("/^[0-9a-z-_]+$/i", $this->_model->$field)
		) {
			$this->_addError($field, "latinDigitUnderscoreHyphen");
		}
	}

	/**
	 * Gets all error messages
	 *
	 * @return array
	 */
	public static function getErrorMessages()
	{
		return [
			"required"                   => Language::t("validation", "required"),
			"max"                        => Language::t("validation", "max"),
			"min"                        => Language::t("validation", "min"),
			"url"                        => Language::t("validation", "url"),
			"system"                     => Language::t("validation", "system"),
			"login-not-exist"            => Language::t("validation", "loginNotExist"),
			"password-incorrect"         => Language::t("validation", "passwordIncorrect"),
			"latinDigitUnderscoreHyphen" => Language::t("validation", "latinDigitUnderscoreHyphen"),
		];
	}
}