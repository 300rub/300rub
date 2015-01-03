<?php

namespace system\base;

use system\db\Db;

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
	 * @return Model
	 */
	public function byId($id)
	{
		$this->db->addCondition("t.id = :id");
		$this->db->params["id"] = $id;

		return $this;
	}

	/**
	 * Добавляет в выборку все связи
	 *
	 * @return Model
	 */
	public function withAll()
	{
		foreach ($this->relations() as $key => $value) {
			$this->db->with[] = $key;
		}

		return $this;
	}

	/**
	 * Добавляет в выборку определенные связи
	 *
	 * @param array $relations связи
	 *
	 * @return Model
	 */
	public function with($relations) {
		foreach ($relations as $relation) {
			$this->db->with[] = $relation;
		}

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

		$result = $this->db->find();
		if (!$result) {
			return null;
		}

		/**
		 * @var Model $model
		 */
		$model = new $this;
		if (!$model->setAttributes($result, "__")) {
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
		$result = $this->db->findAll();
		if (!$result) {
			return null;
		}

		$list = array();

		foreach ($result as $values) {
			/**
			 * @var Model $model
			 */
			$model = new $this;
			$model->setAttributes($values, "__");
			if ($model) {
				$list[] = $model;
			}
		}

		return $list;
	}

	/**
	 * Устанавливает атрибуты модели
	 *
	 * @param array  $values    значения атрибутов
	 * @param string $separator разделитель
	 *
	 * @return bool
	 */
	public function setAttributes($values, $separator = ".")
	{
		if (!is_array($values)) {
			return false;
		}

		$attributes = array();

		foreach ($values as $key => $val) {
			$explode = explode($separator, $key, 2);
			if (!empty($explode[1])) {
				$attributes[$explode[0]][$explode[1]] = $val;
			}
		}

		if (!$attributes) {
			return false;
		}

		$relations = $this->relations();
		foreach ($attributes as $key => $fields) {
			if ($key == "t") {
				foreach ($fields as $name => $value) {
					if (property_exists($this, $name)) {
						$this->$name = $value;
					}
				}
			} else if (property_exists($this, $key)) {
				if ($this->$key) {
					$model = $this->$key;
				} else {
					$model = new $relations[$key][0];
				}
				foreach ($fields as $name => $value) {
					if (property_exists($model, $name)) {
						$model->$name = $value;
					}
				}
				$this->$key = $model;
			}
		}

		return true;
	}

	/**
	 * Валидация модели
	 *
	 * @param bool $isBeforeValidate Выполнять ли действия перед валидацией
	 *
	 * @return bool
	 */
	public function validate($isBeforeValidate = true)
	{
		if ($isBeforeValidate) {
			$this->beforeValidate();
		}

		$validator = new Validator($this);
		$this->errors = array_merge($this->errors, $validator->validate());
		foreach ($this->relations() as $relation => $options) {
			if ($this->$relation) {
				if ($isBeforeValidate) {
					$this->$relation->beforeValidate();
				}
				$validator = new Validator($this->$relation, $relation);
				$this->errors = array_merge($this->errors, $validator->validate());
			} else if (!$this->$options[1]) {
				$this->$relation = new $options[0];
				$validator = new Validator($this->$relation, $relation);
				$this->errors = array_merge($this->errors, $validator->validate());
			}
		}

		return !$this->errors;
	}

	/**
	 * Сохранение модели
	 *
	 * @param bool $useTransaction использовать ли транзакцию
	 *
	 * @return bool
	 */
	public function save($useTransaction = true)
	{
		if (!$this->validate()) {
			return false;
		}

		if ($useTransaction) {
			Db::startTransaction();
		}

		if ($this->beforeSave() === false) {
			if ($useTransaction) {
				Db::rollbackTransaction();
			}
			return false;
		}

		$data = array();
		foreach ($this->rules() as $field => $value) {
			$data[$field] = $this->$field;
		}

		if ($this->id) {
			if (!Db::update($this)) {
				if ($useTransaction) {
					Db::rollbackTransaction();
				}
				return false;
			}
		} else {
			$this->id = Db::insert($this);
			if (!$this->id) {
				if ($useTransaction) {
					Db::rollbackTransaction();
				}
				return false;
			}
		}

		if ($this->afterSave() === false) {
			if ($useTransaction) {
				Db::rollbackTransaction();
			}
			return false;
		}

		if ($useTransaction) {
			Db::commitTransaction();
		}
		return true;
	}

	/**
	 * Удаление модели
	 *
	 * @param bool $useTransaction использовать ли транзакцию
	 *
	 * @return bool
	 */
	public function delete($useTransaction = true)
	{
		if (!$this->id) {
			return false;
		}

		if ($useTransaction) {
			Db::startTransaction();
		}

		if ($this->beforeDelete() === false) {
			if ($useTransaction) {
				Db::rollbackTransaction();
			}
			return false;
		}

		if (!Db::delete($this)) {
			if ($useTransaction) {
				Db::rollbackTransaction();
			}
			return false;
		}

		if ($this->afterDelete() === false) {
			if ($useTransaction) {
				Db::rollbackTransaction();
			}
			return false;
		}

		if ($useTransaction) {
			Db::commitTransaction();
		}
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
	 * @return bool
	 */
	protected function beforeSave()
	{
		foreach ($this->relations() as $relation => $options) {
			if ($this->$relation) {
				$field = $options[1];
				if (!$this->$relation->save(false)) {
					return false;
				}
				$this->$field = $this->$relation->id;
			}
		}

		return true;
	}

	/**
	 * Выполняется после сохранения модели
	 *
	 * @return bool
	 */
	protected function afterSave()
	{
		return true;
	}

	/**
	 * Выполняется перед удалением модели
	 *
	 * @return bool
	 */
	protected function beforeDelete()
	{
		return true;
	}

	/**
	 * Выполняется после удаления модели
	 *
	 * @return bool
	 */
	protected function afterDelete()
	{
		foreach ($this->relations() as $relation => $options) {
			if ($this->$relation && !$this->$relation->delete(false)) {
				return false;
			}
		}

		return true;
	}
}