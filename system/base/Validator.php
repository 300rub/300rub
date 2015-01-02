<?php

namespace system\base;

class Validator
{

	/**
	 * Модель
	 *
	 * @var Model
	 */
	private $_model = null;

	/**
	 * Ошибки
	 *
	 * @var array
	 */
	private $_errors = array();

	/**
	 * Название связи
	 *
	 * @var string
	 */
	private $_relation = "t";

	/**
	 * Конструктор
	 *
	 * @param Model  $model    модель
	 * @param string $relation название связи
	 */
	public function __construct($model, $relation = "t")
	{
		$this->_model = $model;
		$this->_relation = $relation;
	}

	/**
	 * Валидация
	 *
	 * @return array
	 */
	public function validate()
	{
		foreach ($this->_model->rules() as $field => $types) {
			foreach ($types as $key => $value) {
				if (is_int($key)) {
					$value = "_" . $value;
					$this->$value($field);
				} else {
					$key = "_" . $key;
					$this->$key($field, $value);
				}
			}
		}

		if ($this->_errors) {
			$errors = array();

			foreach ($this->_errors as $key => $value) {
				$errors[$this->_relation . "." . $key] = $value;
			}

			return $errors;
		}

		return $this->_errors;
	}

	/**
	 * Делает проверку на обязательное заполнение
	 *
	 * @param string $field название поля
	 *
	 * @return void
	 */
	private function _required($field)
	{
		if (!$this->_model->$field) {
			$this->_errors[$field]["required"] =
				Language::t("default", "{field} обязательно для заполнения", array("field" => $field));
		}
	}

	/**
	 * Делает проверку на максимальную длину строки
	 *
	 * @param string $field название поля
	 * @param int    $max   максимальная длина
	 *
	 * @return void
	 */
	private function _max($field, $max)
	{
		if (strlen($this->_model->$field) > $max) {
			$this->_errors[$field]["max"] =
				Language::t(
					"default",
					"{field} слишком длинное, (максимальное значение: {max}).",
					array("field" => $field, "max" => $max)
				);
		}
	}

	/**
	 * Делает проверку на корректность url
	 *
	 * @param string $field название поля
	 *
	 * @return void
	 */
	private function _url($field)
	{
		if ($this->_model->$field && !preg_match("/^[0-9a-z-]+$/i", $this->_model->$field)) {

			$this->_errors[$field]["url"] =
				Language::t(
					"default",
					"{field} должно состоять из латинских символов, чисел и тире",
					array("field" => $field)
				);
		}
	}
}