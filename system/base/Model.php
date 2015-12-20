<?php

namespace system\base;

use system\db\Db;

/**
 * Abstract class for working with models
 *
 * @package system.base
 */
abstract class Model
{

	/**
	 * Default separator
	 */
	const DEFAULT_SEPARATOR = ".";

	/**
	 * Object name
	 */
	const OBJECT_NAME = "t";

	/**
	 * ID
	 *
	 * @var integer
	 */
	public $id = 0;

	/**
	 * DB object
	 *
	 * @var Db
	 */
	protected $db;

	/**
	 * Errors
	 *
	 * @var array
	 */
	public $errors = [];

	/**
	 * Gets table name
	 *
	 * @return string
	 */
	abstract public function tableName();

	/**
	 * Relations
	 *
	 * @return array
	 */
	abstract public function relations();

	/**
	 * Rules
	 *
	 * @return array
	 */
	abstract public function rules();

	/**
	 * Label names
	 *
	 * @return array
	 */
	abstract public function labels();

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->db = new Db;
		$this->db->tableName = $this->tableName();
		$this->db->relations = $this->relations();
		$this->db->fields = array_keys($this->rules());
	}

	/**
	 * Adds ID condition to SQL request
	 *
	 * @param int $id ID
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
	 * Adds in condition to SQL request
	 *
	 * @param string $field  Field name
	 * @param array  $values Values
	 *
	 * @return Model
	 */
	public function in($field, $values)
	{
		$this->db->addCondition("{$field} IN (" . implode(",", $values) . ")");

		return $this;
	}

	/**
	 * Adds except ID condition to SQL request
	 *
	 * @param int $id ID
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
	 * Adds sort by name to SQL request
	 *
	 * @return Model
	 */
	public function ordered()
	{
		$this->db->order = "t.name";

		return $this;
	}

	/**
	 * Adds select all relations table to SQL request
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
	 * Adds select some relations table to SQL request
	 *
	 * @param array $relations Relations
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
	 * Model search in DB
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
	 * Runs after finding model
	 *
	 * @return Model
	 */
	protected function afterFind()
	{
	}

	/**
	 * Models search in DB
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
			$model->setAttributes($values, "__")->afterFind();
			if ($model) {
				$list[] = $model;
			}
		}

		return $list;
	}

	/**
	 * Sets model's attributes
	 *
	 * @param array  $values    attribute values
	 * @param string $separator separator
	 *
	 * @return Model
	 */
	public final function setAttributes($values, $separator = self::DEFAULT_SEPARATOR)
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
	 * Validates model's fields
	 *
	 * @param bool $isBeforeValidate Is run beforeValidate method
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
	 * Saves model in DB
	 *
	 * @param bool $useTransaction Is transaction used
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
	 * Deletes model from DB
	 *
	 * @param bool $useTransaction Is transaction used
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

	/**
	 * Duplicates model
	 *
	 * @return bool
	 */
	public function duplicate()
	{
		return true;
	}

	/**
	 * Runs before validation
	 *
	 * @return void
	 */
	protected function beforeValidate()
	{
	}

	/**
	 * Runs before saving
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
	 * Runs after saving
	 *
	 * @return bool
	 */
	protected function afterSave()
	{
		return true;
	}

	/**
	 * Runs before deleting
	 *
	 * @return bool
	 */
	protected function beforeDelete()
	{
		return true;
	}

	/**
	 * Runs after deleting
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
	 * Updates value for all fields
	 *
	 * @param array $params Field => value
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
	 * Gets field's rules
	 *
	 * @param string $field Field
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
	 * Get's fields name
	 *
	 * @param string $field Field
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
	 * Gets relation class
	 *
	 * @param string $relation Relation name
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