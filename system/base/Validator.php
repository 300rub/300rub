<?php

namespace system\base;

use system\web\Language;

/**
 * Class for validation model's fields
 *
 * @package system.base
 */
class Validator
{

	/**
	 * Model
	 *
	 * @var Model
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
	 * @param Model  $model      Model
	 * @param string $objectName Object name
	 */
	public function __construct($model, $objectName = Model::OBJECT_NAME)
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
					"method" => $value,
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
				case "url":
					$this->_url($item["field"]);
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
		$this->_errors[$this->_objectName . Model::DEFAULT_SEPARATOR . $field] = $value;
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
		if (!array_key_exists($field, $this->_errors) && !$this->_model->$field) {
			$this->_addError($field, "required");
		}
	}

	/**
	 * Verifies max string
	 *
	 * @param string $field Fields name
	 * @param int    $max   Max value
	 *
	 * @return void
	 */
	private function _max($field, $max)
	{
		if (!array_key_exists($field, $this->_errors) && strlen($this->_model->$field) > $max) {
			$this->_addError($field, "max");
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
			!array_key_exists($field, $this->_errors)
			&& $this->_model->$field
			&& !preg_match("/^[0-9a-z-]+$/i", $this->_model->$field)
		) {
			$this->_addError($field, "url");
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
			"required"           => Language::t("default", "Поле должно быть заполнено"),
			"max"                => Language::t("default", "Поле слишком длинное"),
			"url"                => Language::t(
					"default",
					"Поле должно состоять из латинских символов, чисел и тире"
			),
			"system"             => Language::t(
					"common",
					"Случилось страшное, но мы уже знаем об этом. Проблема уже находится на стадии решения.
				Приносим свои извинения. Попробуйте данную операцию чуть позже."
			),
			"login-not-exist"    => Language::t("default", "Пользователя с таким логином не существует"),
			"password-incorrect" => Language::t("default", "Некорректный пароль"),
		];
	}
}