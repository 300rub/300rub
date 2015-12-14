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
	public $errors = [];

	/**
	 * Типы форм для полей
	 *
	 * @var array
	 */
	 public $formTypes = [];

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
	 * Возвращает названия полей
	 *
	 * @return array
	 */
	abstract public function labels();

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
	 * @param string $field
	 * @param array $values
	 *
	 * @return Model
	 */
	public function in($field, $values)
	{
		$this->db->addCondition("{$field} IN (" . implode(",", $values) . ")");

		return $this;
	}

	/**
	 * @param int $id идентификатор
	 *
	 * @return Model
	 */
	public function exceptId($id)
	{
		$this->db->addCondition("t.id != :id");
		$this->db->params["id"] = $id;

		return $this;
	}

	/**
	 * @param string $order
	 *
	 * @return Model
	 */
	public function ordered()
	{
		$this->db->order = "t.name";

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
		if ($relations === "*") {
			$this->withAll();
			return $this;
		}

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
		$model->setAttributes($result, "__")->afterFind();

		return $model;
	}

	/**
	 * @return Model
	 */
	protected function afterFind()
	{
		return $this;
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
			return [];
		}

		$list = [];

		foreach ($result as $values) {
			/**
			 * @var Model $model
			 */
			$model = new $this;
			$model->setAttributes($result, "__")->afterFind();
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
	 * @return Model
	 */
	public final function setAttributes($values, $separator = ".")
	{
		if (!is_array($values)) {
			return $this;
		}

		$attributes = [];

		foreach ($values as $key => $val) {
			$explode = explode($separator, $key, 2);
			if (!empty($explode[1])) {
				$attributes[$explode[0]][$explode[1]] = $val;
			}
		}

		if (!$attributes) {
			return $this;
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

		return $this;
	}

	/**
	 * Валидация модели
	 *
	 * @param bool $isBeforeValidate Выполнять ли действия перед валидацией
	 *
	 * @return bool
	 */
	public final function validate($isBeforeValidate = true)
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
	public final function save($useTransaction = true)
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
	public final function delete($useTransaction = true)
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

	public function duplicate()
	{
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

	/**
	 * Производит обновление для всех полей
	 *
	 * @param array $params поле => значение
	 *
	 * @return bool
	 */
	protected final function updateForAll($params)
	{
		if (!is_array($params)) {
			return false;
		}

		$sets = [];
		$values = [];

		foreach ($params as $key => $value) {
			$sets[] = "$key = ?";
			$values[] = $value;
		}

		$query = "UPDATE " . $this->tableName() . " SET " . implode(",", $sets);

		return Db::execute($query, $values);
	}

	/**
	 * Получает правила для поля
	 *
	 * @param string $field поле
	 *
	 * @return string[]
	 */
	public final function getRules($field)
	{
		$rules = $this->rules();
		if (array_key_exists($field, $rules)) {
			return $rules[$field];
		}

		return [];
	}

	/**
	 * Получает название поля
	 *
	 * @param string $field поле
	 *
	 * @return string
	 */
	public final function getLabel($field)
	{
		$labels = $this->labels();
		if (array_key_exists($field, $labels)) {
			return $labels[$field];
		}

		return "";
	}

	/**
	 * Получает тип формы
	 *
	 * @param string $field поле
	 *
	 * @return string
	 */
	public function getFormType($field)
	{
		if (array_key_exists($field, $this->formTypes)) {
			return $this->formTypes[$field];
		}

		return "";
	}

	/**
	 * Получает название класса для связи
	 *
	 * @param string $relation нзвание связи
	 *
	 * @return string
	 */
	public function getRelationClass($relation)
	{
		if (!property_exists($this, $relation)) {
			return null;
		}

		$relations = $this->relations();
		if (array_key_exists($relation, $relations)) {
			return null;
		}

		return $relations[$relation][0];
	}
}