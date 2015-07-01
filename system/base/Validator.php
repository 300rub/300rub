<?php

namespace system\base;

use system\web\Language;

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
	private $_errors = [];

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
			$errors = [];

			foreach ($this->_errors as $key => $value) {
				$errors[$this->_relation . "__" . $key] = $value;
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
		if (!array_key_exists($field, $this->_errors) && !$this->_model->$field) {
			$this->_errors[$field] = "required";
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
		if (!array_key_exists($field, $this->_errors) && strlen($this->_model->$field) > $max) {
			$this->_errors[$field] = "max";
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
		if (
			!array_key_exists($field, $this->_errors)
			&& $this->_model->$field
			&& !preg_match("/^[0-9a-z-]+$/i", $this->_model->$field)
		) {
			$this->_errors[$field] = "url";
		}
	}

	/**
	 * Получает сообщения об ошибках
	 *
	 * @return array
	 */
	public static function getErrorMessages()
	{
		return [
			"required"        => Language::t("default", "Поле должно быть заполнено"),
			"max"             => Language::t("default", "Поле слишком длинное"),
			"url"             => Language::t("default", "Поле должно состоять из латинских символов, чисел и тире"),
			"system"          => Language::t(
				"common",
				"Случилось страшное, но мы уже знаем об этом. Проблема уже находится на стадии решения.
					Приносим свои извинения. Попробуйте данную операцию чуть позже."
			),
			"login-not-exist" => Language::t("default", "Пользователя с таким логином не существует"),
			"password-incorrect" => Language::t("default", "Некорректный пароль"),
		];
	}
}