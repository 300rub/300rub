<?php

namespace testS\models;

use testS\components\Db;
use testS\components\exceptions\DbException;
use testS\components\exceptions\ModelException;
use testS\components\Validator;
use \Exception;

/**
 * Abstract class for working with models
 *
 * @package models
 * 
 * @method AbstractModel duplicate
 */
abstract class AbstractModel
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
	 * Form type field
	 */
	const FORM_TYPE_FIELD = "field";

	/**
	 * Form type checkbox
	 */
	const FORM_TYPE_CHECKBOX = "checkbox";

	/**
	 * Form type select
	 */
	const FORM_TYPE_SELECT = "select";

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
	 * Flag for checking parent before saving
	 *
	 * @var bool
	 */
	public $checkParentBeforeSave = true;

	/**
	 * Form types
	 *
	 * @var array
	 */
	protected $formTypes = [];

	/**
	 * Relations
	 *
	 * @var array
	 */
	protected $relations = [];

	/**
	 * Gets table name
	 *
	 * @return string
	 */
	abstract public function getTableName();

	/**
	 * Gets rules
	 *
	 * @return array
	 */
	abstract public function getRules();

	/**
	 * Sets values
	 */
	abstract protected function setValues();

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->db = new Db;
		$this->db->tableName = $this->getTableName();
		$this->db->relations = $this->relations;
		$this->db->fields = $this->getFieldNames();
	}

	/**
	 * Gets field names
	 *
	 * @return string[]
	 */
	public function getFieldNames()
	{
		return array_keys($this->getRules());
	}

	/**
	 * Adds ID condition to SQL request
	 *
	 * @param int $id ID
	 *
	 * @return AbstractModel
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
	 * @return AbstractModel
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
	 * @return AbstractModel
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
	 * @return AbstractModel
	 */
	public function ordered()
	{
		$this->db->order = "t.name";

		return $this;
	}

	/**
	 * Adds select all relations table to SQL request
	 *
	 * @return AbstractModel
	 */
	public function withAll()
	{
		$relationKeys = $this->getRelationKeys();
		foreach ($relationKeys as $relation) {
			$this->db->with[] = $relation;
		}

		return $this;
	}

	/**
	 * Adds select some relations table to SQL request
	 *
	 * @param array|string $relations Relations
	 *
	 * @return AbstractModel
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
	 * @return null|AbstractModel
	 */
	public function find()
	{
		$this->db->limit = 1;

		$result = $this->db->find();
		if (!$result) {
			return null;
		}

		/**
		 * @var AbstractModel $model
		 */
		$model = new $this;
		$model->setAttributes($this->_parseAttributes($result))->afterFind();

		return $model;
	}

	/**
	 * Runs after finding model
	 *
	 * @return AbstractModel
	 */
	protected function afterFind()
	{
		$this->setValues();

		$relationKeys = $this->getRelationKeys();
		foreach ($relationKeys as $relation) {
			if ($this->$relation instanceof AbstractModel) {
				$this->$relation->afterFind();
			}
		}
	}

	/**
	 * Models search in DB
	 *
	 * @return null|AbstractModel[]
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
			 * @var AbstractModel $model
			 */
			$model = new $this;
			$model->setAttributes($this->_parseAttributes($values))->afterFind();
			if ($model) {
				$list[] = $model;
			}
		}

		return $list;
	}

	/**
	 * Parses attributes from sql response
	 *
	 * @param array $values
	 *
	 * @return array
	 */
	private function _parseAttributes(array $values)
	{
		$attributes = [];
		
		foreach ($values as $key => $val) {
			list($k, $v) = explode(Db::SEPARATOR, $key);

			if ($k === self::OBJECT_NAME) {
				$attributes[$v] = $val;
			} else {
				if (!isset($attributes[$k])) {
					$attributes[$k] = [];
				}
				$attributes[$k][$v] = $val;
			}
		}

		return $attributes;
	}

	/**
	 * Sets model's attributes
	 *
	 * @param array $values attribute values
	 *
	 * @return AbstractModel
	 */
	public final function setAttributes($values)
	{
		if (!is_array($values)) {
			return $this;
		}

		foreach ($values as $name => $value) {
			if (!property_exists($this, $name)) {
				continue;
			}

			if (is_array($value)) {
				if ($this->$name) {
					$model = $this->$name;
				} else {
					$relation = $this->relations[$name][0];
					$model = new $relation;
				}

				foreach ($value as $key => $val) {
					if (property_exists($model, $key)) {
						$model->$key = $val;
					}
				}

				$this->$name = $model;
			} else  {
				$this->$name = $value;
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
		foreach ($this->relations as $relation => $options) {
			if ($this->$relation) {
				if ($isBeforeValidate) {
					$this->$relation->beforeValidate();
				}
				$validator = new Validator($this->$relation, $relation);
				$this->errors = array_merge($this->errors, $validator->validate());
			} else if (!empty($options[1])) {
				$field = $options[1];
				if (!$this->$field) {
					$this->$relation = new $options[0];
					$validator = new Validator($this->$relation, $relation);
					$this->errors = array_merge($this->errors, $validator->validate());
				}
			}
		}

		return !$this->errors;
	}

	/**
	 * Saves model in DB
	 *
	 * @throws ModelException
	 */
	public final function save()
	{
		if (!$this->validate()) {
			return false;
		}

		try {
			$this->setValues();
			$this->beforeSave();

			if ($this->id) {
				Db::update($this);
			} else {
				$this->id = Db::insert($this);
			}
			
			$this->afterSave();
			
			return true;
		} catch (Exception $e) {
			$fields = "";
			foreach ($this->getFieldNames() as $fieldName) {
				$fields .= " {$fieldName}: " . $this->$fieldName;
			}
			throw new ModelException(
				"{e}. Unable to save the model {class} with fields: {fields}",
				[
					"e"      => $e->getMessage(),
					"class"  => get_class($this),
					"fields" => $fields
				]
			);
		}
	}

	/**
	 * Deletes model from DB
	 *
	 * @return bool
	 */
	public final function delete()
	{
		try {
			if (!$this->id) {
				throw new ModelException("Unable to delete the record with null ID");
			}

			$this->beforeDelete();
			Db::delete($this);
			$this->afterDelete();
		} catch (Exception $e) {
			return false;
		}

		return true;
	}

	/**
	 * Runs before validation
	 */
	protected function beforeValidate()
	{
	}

	/**
	 * Runs before saving
	 */
	protected function beforeSave()
	{
		foreach ($this->relations as $relation => $options) {
			if ($this->$relation instanceof $options[0]) {
				$field = $options[1];
				if (!$this->$relation->save()) {
					throw new ModelException(
						"Unable to save relation: {relation}", 
						[
							"relation" => $relation
						]
					);
				}
				$this->$field = $this->$relation->id;
			}
		}
	}

	/**
	 * Runs after saving
	 */
	protected function afterSave()
	{
	}

	/**
	 * Runs before deleting
	 */
	protected function beforeDelete()
	{
	}

	/**
	 * Runs after deleting
	 */
	protected function afterDelete()
	{
	}

	/**
	 * Updates value for all fields
	 *
	 * @param array $params Field => value
	 * 
	 * @throws
	 */
	protected final function updateForAll(array $params)
	{
		$sets = [];
		$values = [];

		foreach ($params as $key => $value) {
			$sets[] = "$key = ?";
			$values[] = $value;
		}

		$tableName = $this->getTableName();
		$set = implode(",", $sets);
		
		$query = "UPDATE " . $tableName . " SET " . $set;

		if (!Db::execute($query, $values)) {
			throw new DbException(
				"Unable to update all records from the table: {table} with set: {set} and values: {values}",
				[
					"table"  => $tableName,
					"set"    => $set,
					"values" => $values
				]
			);
		}
	}

	/**
	 * Gets field's rules
	 *
	 * @param string $field Field
	 *
	 * @return string[]
	 */
	public final function getRulesForField($field)
	{
		$rules = $this->getRules();
		if (array_key_exists($field, $rules)) {
			return $rules[$field];
		}

		return [];
	}

	/**
	 * Gets field's form type
	 *
	 * @param string $field Field
	 *
	 * @return string
	 */
	public final function getFormType($field)
	{
		if (array_key_exists($field, $this->formTypes)) {
			return $this->formTypes[$field];
		}

		return self::FORM_TYPE_FIELD;
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

		$relations = $this->relations;
		if (!array_key_exists($relation, $relations)) {
			return null;
		}

		return $relations[$relation][0];
	}

	/**
	 * Gets relation key
	 *
	 * @param string $relation Relation name
	 *
	 * @return string
	 */
	public function getRelationKey($relation)
	{
		if (!property_exists($this, $relation)) {
			return null;
		}

		$relations = $this->relations;
		if (!array_key_exists($relation, $relations)) {
			return null;
		}

		return $relations[$relation][1];
	}

	/**
	 * Gets relation keys
	 *
	 * @return string[]
	 */
	public function getRelationKeys()
	{
		return array_keys($this->relations);
	}

	/**
	 * Gets relations
	 *
	 * @return array
	 */
	public function getRelations()
	{
		return $this->relations;
	}

	/**
	 * Gets tiny int value
	 *
	 * @param bool|int $value Value
	 *
	 * @return int
	 */
	protected function getTinyIntVal($value)
	{
		$value = intval($value, 0);
		if ($value >= 1) {
			return 1;
		} else {
			return 0;
		}
	}

	/**
	 * Gets int val
	 *
	 * @param int $value  Value
	 * @param int $maxVal Max value
	 * @param int $minVal Min value
	 *
	 * @return int
	 */
	protected function getIntVal($value, $maxVal = 99999, $minVal = 0)
	{
		$value = intval($value);

		if ($value < $minVal) {
			$value = $minVal;
		} elseif ($value > $maxVal) {
			$value = $maxVal;
		}

		return $value;
	}

	/**
	 * Gets relation model
	 *
	 * @param AbstractModel|null $model     Object
	 * @param int                $id        ID
	 * @param string             $className Class name of instance
	 *
	 * @return AbstractModel
	 */
	protected function getRelationModel($model, $id, $className)
	{
		$className = "\\testS\\models\\{$className}";

		if ($model instanceof $className) {
			return $model;
		}

		/**
		 * @var AbstractModel $class
		 */
		$class = new $className;

		if ($id === 0) {
			$model = $class;
		} else {
			$model = $class->byId($id)->find();
			if ($model === null) {
				$model = $class;
			}
		}

		return $model;
	}

	/**
	 * Deletes relation
	 *
	 * @param AbstractModel $model     Model object
	 * @param int           $id        ID
	 * @param string        $className Class Name
	 *
	 * @throws ModelException
	 *
	 * @return AbstractModel
	 */
	protected function deleteRelation($model, $id, $className)
	{
		if ($model === null) {
			/**
			 * @var AbstractModel $class
			 */
			$class = new $className;

			$model = $class->byId($id)->find();
		}

		if (!$model instanceof $className ||!$model->delete()) {
			throw new ModelException(
				"Unable to delete {className} model with ID = {id}",
				[
					"className" => $className,
					"id"        => $id
				]
			);
		}

		return $this;
	}
}