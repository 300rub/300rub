<?php

namespace system\base;

use system\db\Db;
use system\base\Validator;

/**
 * Файл класса Model.
 *
 * Базовый абстрактный класс для работы с моделями
 *
 * @package system.base
 */
abstract class Model
{

	/**
	 * Идентификатор
	 *
	 * @var integer
	 */
	public $id = 0;

	/**
	 * Параметры для выборки из БД
	 *
	 * @var Db
	 */
	protected $db;

	/**
	 * Ошибки
	 *
	 * @var array
	 */
	public $errors = array();

	/**
	 * Получает название связной таблицы
	 *
	 * @return string
	 */
	abstract public function tableName();

	/**
	 * Возвращает связи между объектами
	 *
	 * @return array
	 */
	abstract public function relations();

	/**
	 * Возвращает правила проверки для атрибутов модели
	 *
	 * @return array
	 */
	abstract public function rules();

	/**
	 * Конструктор
	 */
	public function __construct()
	{
		$this->db = new Db;
		$this->db->tableName = $this->tableName();
		$this->db->relations = $this->relations();
		$this->db->fields = array_keys($this->rules());
	}

	/**
	 * Выборка по идентификатору
	 *
	 * @param int $id идентификатор
	 *
	 * @return $this
	 */
	public function byId($id)
	{
		$this->db->addCondition("t.id = :id");
		$this->db->params["id"] = $id;

		return $this;
	}

	/**
	 * Поиск модели
	 *
	 * @return null|Model
	 */
	public function find()
	{
		$this->db->limit = 1;

		$result = $this->db->getResult();
		if (!$result) {
			return null;
		}

		/**
		 * @var Model $model
		 */
		$model = new $this;
		if (!$model->setAttributes($result[0])) {
			return null;
		}

		return $model;
	}

	/**
	 * Поиск моделей
	 *
	 * @return null|Model[]
	 */
	public function findAll()
	{
		$result = $this->db->getResult();
		if (!$result) {
			return null;
		}

		$list = array();

		foreach ($result as $values) {
			/**
			 * @var Model $model
			 */
			$model = new $this;
			$model->setAttributes($values);
			if ($model) {
				$list[] = $model;
			}
		}

		return $list;
	}

	/**
	 * Устанавливает атрибуты модели
	 *
	 * @param array $values значения атрибутов
	 *
	 * @return bool
	 */
	public function setAttributes($values = array())
	{
		if (!is_array($values)) {
			return false;
		}

		$attributes = array();

		foreach ($values as $key => $val) {
			$explode = explode("__", $key, 2);
			$attributes[$explode[0]][$explode[1]] = $val;
		}

		if (!$attributes) {
			return false;
		}

		$relations = $this->relations();
		foreach ($attributes as $key => $fields) {
			if ($key == "t") {
				foreach ($fields as $name => $value) {
					$this->$name = $value;
				}
			} else {
				$model = new $relations[$key][0];
				foreach ($fields as $name => $value) {
					$model->$name = $value;
				}
				$this->$key = $model;
			}
		}

		return true;
	}

	/**
	 * Сохранение модели
	 *
	 * @return bool
	 */
	public function save()
	{
		$this->beforeValidate();

		$validator = new Validator($this);
		$this->errors = array_merge($this->errors, $validator->validate());
		foreach ($this->relations() as $key => $value) {
			if ($this->$key) {
				$validator = new Validator($this->$key, $key);
				$this->errors = array_merge($this->errors, $validator->validate());
			}
		}

		if ($this->errors) {
			return false;
		}

		$this->beforeSave();

		$data = array();
		foreach ($this->rules() as $field => $value) {
			$data[$field] = $this->$field;
		}

		if ($this->id) {

		} else {
			$this->id = Db::insert($this);
			if (!$this->id) {
				return false;
			}
		}


		$this->afterSave();

		return true;
	}

	/**
	 * Выполняется перед валидацией модели
	 *
	 * @return void
	 */
	protected function beforeValidate()
	{
	}

	/**
	 * Выполняется перед сохранением модели
	 *
	 * @return void
	 */
	protected function beforeSave()
	{
	}

	/**
	 * Выполняется после сохранения модели
	 *
	 * @return void
	 */
	protected function afterSave()
	{
	}
}