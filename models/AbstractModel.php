<?php

namespace testS\models;

use testS\components\Db;
use testS\components\exceptions\ModelException;
use testS\components\Language;
use testS\components\Validator;
use Exception;

/**
 * Abstract class for working with models
 *
 * @package testS\models
 * 
 * @method AbstractModel duplicate
 */
abstract class AbstractModel
{

    /**
     * Keys for fields
     */
    const FIELD_VALIDATION = "validation";
    const FIELD_SET = "set";
    const FIELD_SKIP_DUPLICATION = "skipDuplication";
    const FIELD_CHANGE_ON_DUPLICATE = "changeOnDuplicate";
    const FIELD_TYPE = "type";
    const FIELD_TYPE_STRING = "string";
    const FIELD_TYPE_INT = "int";

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
    private $_db;

    /**
     * Errors
     *
     * @var array
     */
    private $_errors = [];

    /**
     * Gets table name
     *
     * @return string
     */
    abstract public function getTableName();

    /**
     * Gets fields info
     *
     * @return array
     */
    abstract protected function getFieldsInfo();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_createFields()->setDb();
    }

    /**
     * Creates fields
     *
     * @return AbstractModel
     */
    private function _createFields()
    {
        foreach (array_keys($this->getFieldsInfo()) as $field) {
            $this->$field = null;
        }

        return $this;
    }

    /**
     * Sets Db
     */
    protected function setDb()
    {
        $this->getDb()->setTable($this->getTableName());

        return $this;
    }

    /**
     * Gets errors
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->_errors;
    }

    /**
     * Adds errors
     *
     * @param string $field
     * @param array  $errors
     *
     * @return AbstractModel
     */
    public function addErrors($field, array $errors)
    {
        if (count($errors) === 0) {
            return $this;
        }

        if (array_key_exists($field, $this->_errors)) {
            $this->_errors[$field] = array_merge($this->_errors[$field], $errors);
        } else {
            $this->_errors[$field] = $errors;
        }

        return $this;
    }

    /**
     * Gets DB object
     *
     * @return Db
     */
    protected function getDb()
    {
        if (!$this->_db instanceof Db) {
            $this->_db = new Db();
        }

        return $this->_db;
    }

    /**
     * Clears strip tags
     *
     * @param string $value
     *
     * @return string
     */
    protected function clearStripTags($value)
    {
        return trim(strip_tags($value));
    }

    /**
     * Gets copy name
     *
     * @param string $value
     *
     * @return string
     */
    protected function getCopyName($value)
    {
        return Language::t("common", "copy") . " " . $value;
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
        $this->getDb()->addWhere(sprintf("%s.id = :id", $this->getTableName()));
        $this->getDb()->addParameter("id", $id);

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
        $this->getDb()->addWhere(sprintf("%s.id != :id", $this->getTableName()));
        $this->getDb()->addParameter("id", $id);

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
        $this->getDb()->addWhere(
            sprintf(
                "%s IN (%s)",
                $field,
                implode(",", $values)
            )
        );

        return $this;
    }

    /**
     * Adds ORDER BY to SQL request
     *
     * @param string $value
     *
     * @return AbstractModel
     */
    public function ordered($value = "name")
    {
        $this->getDb()->setOrder($value);
        return $this;
    }

    /**
     * Model search in DB
     *
     * @return null|AbstractModel
     */
    public function find()
    {
        $result = $this->_setDbRequestDataBeforeFind()->getDb()->find();
        if (!$result) {
            return null;
        }

        /**
         * @var AbstractModel $model
         */
        $model = new $this;
        $model->setFields($this->_parseDbResponse($result));

        return $model;
    }

    /**
     * Models search in DB
     *
     * @return null|AbstractModel[]
     */
    public function findAll()
    {
        $results = $this->_setDbRequestDataBeforeFind()->getDb()->findAll();
        if (!$results) {
            return [];
        }

        $list = [];
        foreach ($results as $result) {
            /**
             * @var AbstractModel $model
             */
            $model = new $this;
            $model->setFields($this->_parseDbResponse($result));
            if ($model) {
                $list[] = $model;
            }
        }

        return $list;
    }

    /**
     * Parses DB response
     *
     * @param array $response
     *
     * @return array
     */
    private function _parseDbResponse(array $response)
    {
        $fields = [];

        foreach ($response as $key => $value) {
            if (stripos($key, Db::SEPARATOR) !== false) {
                list($relationModelKey, $relationKey) = explode(Db::SEPARATOR, $key, 2);
                if (!isset($fields[$relationModelKey])) {
                    $fields[$relationModelKey] = [];
                }
                $fields[$relationModelKey][$relationKey] = $value;
            } else {
                $fields[$key] = $value;
            }
        }

        return $fields;
    }

    /**
     * Sets fields
     *
     * @param array $fields
     *
     * @return AbstractModel
     */
    public function setFields(array $fields)
    {
        $info = $this->getFieldsInfo();

        foreach ($fields as $field => $value) {
            if (!array_key_exists($field, $info)) {
                continue;
            }

            if (is_array($field)) {

            } else {
                $this->$field = $value;
            }
        }

        foreach ($info as $field => $parameters) {
            if (array_key_exists(self::FIELD_TYPE, $parameters)) {
                $method = sprintf("get%s", ucfirst($parameters[self::FIELD_TYPE]));
                if (method_exists($this, $method)) {
                    $this->$field = $this->$method($this->$field);
                }
            }
        }

        return $this;
    }

    /**
     * Deletes model from DB
     *
     * @param string $where
     * @param array  $parameters
     *
     * @throws ModelException
     */
    public final function delete($where = null, array $parameters = [])
    {
        if ($where === null) {
            if (!$this->id) {
                throw new ModelException("Unable to delete the record with null ID");
            }

            $this->getDb()->setWhere("id = :id");
            $this->getDb()->setParameters(["id" => $this->id]);
        } else {
            $this->getDb()->setWhere($where);

            if (count($parameters) > 0) {
                $this->getDb()->setParameters($parameters);
            }
        }

        $this->beforeDelete();
        $this->getDb()->delete();
        $this->afterDelete();
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
     * Validates model's fields
     *
     * @return AbstractModel
     */
    public final function validate()
    {
        foreach ($this->getFieldsInfo() as $field => $info) {
            if (array_key_exists(self::FIELD_VALIDATION, $info)) {
                if (property_exists($this, $field)) {
                    $value = $this->$field;
                } else {
                    $value = null;
                }
                $validator = new Validator($value, $info[self::FIELD_VALIDATION]);
                $this->addErrors($field, $validator->validate()->getErrors());
            }
        }

        return $this;
    }

    /**
     * Saves model in DB
     *
     * @param string $where
     * @param array  $parameters
     *
     * @throws ModelException
     *
     * @return AbstractModel
     */
    public final function save($where = null, array $parameters = [])
    {
        $this->_setFieldsAndDbRequestDataBeforeSave();

        if (count($this->validate()->getErrors()) > 0) {
            return $this;
        }

        try {
            $this->beforeSave();

            if ($this->id) {
                if ($where === null) {
                    $this->getDb()->setWhere("id = :id");
                    $this->getDb()->addParameter("id", $this->id);
                } else {
                    $this->getDb()->setWhere($where);

                    if (count($parameters) > 0) {
                        foreach ($parameters as $parameterKey => $parameterValue) {
                            $this->getDb()->addParameter($parameterKey, $parameterValue);
                        }
                    }
                }

                $this->getDb()->update();
            } else {
                $this->id = $this->getDb()->insert();
            }

            $this->afterSave();

            return $this;
        } catch (Exception $e) {
            $fields = [];
            foreach ($this->getFieldsInfo() as $field => $info) {
                if (!is_object($this->$field)) {
                    $fields[] = sprintf("%s: %s", $field, $this->$field);
                }

            }
            throw new ModelException(
                "{e}. Unable to save the model {class} with the fields: {fields}",
                [
                    "e"      => $e->getMessage(),
                    "class"  => get_class($this),
                    "fields" => implode(", ", $fields)
                ]
            );
        }
    }

    /**
     * Sets fields and Db request data before saving
     *
     * @return AbstractModel
     */
    private function _setFieldsAndDbRequestDataBeforeSave()
    {
        $fields = [];
        $parameters = [];

        foreach ($this->getFieldsInfo() as $field => $info) {
            if (array_key_exists(self::FIELD_TYPE, $info)) {
                $method = sprintf("get%sForDb", ucfirst($info[self::FIELD_TYPE]));
                if (method_exists($this, $method)) {
                    $this->$field = $this->$method($this->$field);
                }
            }

            if (array_key_exists(self::FIELD_SET, $info)) {
                foreach ($info[self::FIELD_SET] as $key => $val) {
                    if (is_string($key)) {
                        $method = $key;
                        if (method_exists($this, $method)) {
                            $this->$field = $this->$method($this->$field, $val);
                        }
                    } else {
                        $method = $val;
                        if (method_exists($this, $method)) {
                            $this->$field = $this->$method($this->$field);
                        }
                    }
                }
            }

            $parameters[$field] = $this->$field;
            $fields[] = $field;
        }

        $this->getDb()->setFields($fields);
        $this->getDb()->setParameters($parameters);

        return $this;
    }

    /**
     * Sets Db request data before find
     *
     * @return AbstractModel
     */
    private function _setDbRequestDataBeforeFind()
    {
        $select = [];

        foreach ($this->getFieldsInfo() as $field => $info) {
            $select[] = $this->getTableName() . Db::SEPARATOR . $field;
        }

        $this->getDb()->setSelect($select);

        return $this;
    }

    /**
     * Runs before saving
     */
    protected function beforeSave()
    {
    }

    /**
     * Runs after saving
     */
    protected function afterSave()
    {
    }

    /**
     * With all relations
     *
     * @return AbstractModel
     */
    public function withAll()
    {
        return $this;
    }

    /**
     * Gets string type
     *
     * @param mixed|string $value
     *
     * @return string
     */
    protected function getString($value)
    {
        return (string) $value;
    }

    /**
     * Gets string type for DB
     *
     * @param mixed|string $value
     *
     * @return string
     */
    protected function getStringForDb($value)
    {
        return $this->getString($value);
    }

    /**
     * Gets string type
     *
     * @param mixed|string $value
     *
     * @return string
     */
    protected function getInt($value)
    {
        return (int) $value;
    }

    /**
     * Gets string type for DB
     *
     * @param mixed|string $value
     *
     * @return string
     */
    protected function getIntForDb($value)
    {
        return $this->getInt($value);
    }

    /**
     * Parses color
     *
     * @param string $value Color value
     *
     * @return string
     */
    protected function parseColor($value)
    {
        if (preg_match('/(.*?)(rgb|rgba)\((\d+),\s*(\d+),\s*(\d+)(?:,\s*(\d+(?:\.\d+)?))?\)/i', $value)) {
            return $value;
        }

        return "";
    }

    /**
     * Sets min value
     *
     * @param int $value
     * @param int $min
     *
     * @return int
     */
    protected function setMin($value, $min)
    {
        if ($value < $min) {
            $value = $min;
        }

        return $value;
    }
}