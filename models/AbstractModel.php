<?php

namespace testS\models;

use testS\components\Db;
use testS\components\exceptions\ModelException;
use testS\components\Validator;
use Exception;
use testS\components\ValueGenerator;

/**
 * Abstract class for working with models
 *
 * @package testS\models
 */
abstract class AbstractModel
{

    /**
     * Keys for fields
     */
    const FIELD_VALIDATION = "validation";
    const FIELD_VALUE = "value";
    const FIELD_SKIP_DUPLICATION = "skipDuplication";
    const FIELD_CHANGE_ON_DUPLICATE = "changeOnDuplicate";
    const FIELD_RELATION = "relation";
    const FIELD_RELATION_TO_PARENT = "relationToParent";
    const FIELD_TYPE = "type";
    const FIELD_TYPE_STRING = "string";
    const FIELD_TYPE_DATETIME = "datetime";
    const FIELD_TYPE_INT = "int";
    const FIELD_TYPE_FLOAT = "float";
    const FIELD_TYPE_BOOL = "bool";
    const FIELD_BEFORE_SAVE = "beforeSave";

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
     * Flag of selecting relations
     *
     * @var string[]
     */
    private $_withRelations = false;

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
    abstract public function getFieldsInfo();

    /**
     * Constructor
     *
     * @param Db $db
     */
    public function __construct($db = null)
    {
        $this->_createNullFields();

        if ($db !== null) {
            $this->_setDb($db);
        } else {
            $this->getDb()->setTable($this->getTableName());
        }
    }

    /**
     * Creates null fields
     *
     * @return AbstractModel
     */
    private function _createNullFields()
    {
        foreach ($this->getFieldsInfo() as $field => $info) {
            $this->$field = null;

            if (array_key_exists(self::FIELD_RELATION, $info)) {
                $f = substr($field, 0, -2) . "Model";
                $this->$f = null;
            }
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
            $this->_setDb(new Db());
        }

        return $this->_db;
    }

    /**
     * Sets Db
     *
     * @param Db $db
     *
     * @return AbstractModel
     */
    private function _setDb(Db $db)
    {
        $this->_db = $db;
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
     * With all relations
     *
     * @return AbstractModel
     */
    public function withRelations()
    {
        $this->_withRelations = true;
        return $this;
    }

    /**
     * Gets relation fields info
     *
     * @return array
     */
    public function getRelationsFieldsInfo()
    {
        $info = [];

        foreach ($this->getFieldsInfo() as $field => $parameters) {
            if (array_key_exists(self::FIELD_RELATION, $parameters)) {
                $info[$field] = $parameters[self::FIELD_RELATION];
            }
        }

        return $info;
    }

    /**
     * Sets Db request data before find
     *
     * @param string $changedTableName
     *
     * @return AbstractModel
     */
    public function setDbRequestDataBeforeFind($changedTableName = "")
    {
        $isAs = true;
        if ($changedTableName === "") {
            $changedTableName = $this->getTableName();
            $isAs = false;
        }

        $this->getDb()->addSelect(
            $changedTableName,
            "id",
            $isAs
        );

        foreach (array_keys($this->getFieldsInfo()) as $field) {
            $this->getDb()->addSelect(
                $changedTableName,
                $field,
                $isAs
            );
        }

        if ($this->_withRelations === false) {
            return $this;
        }

        $this->_setDbRequestRelationsDataBeforeFind($changedTableName, $isAs);

        return $this;
    }

    /**
     * Sets Db relations request data before find
     *
     * @param string $changedTableName
     * @param bool   $isAs
     */
    private function _setDbRequestRelationsDataBeforeFind($changedTableName, $isAs)
    {
        /**
         * @var AbstractModel $relationModel
         */
        foreach ($this->getRelationsFieldsInfo() as $field => $parameters) {
            $relationName = $parameters[1];
            $relationModel = "\\testS\\models\\" . $parameters[0];
            $relationModel = new $relationModel($this->getDb());

            if ($isAs === true) {
                $joinAsName = $changedTableName . Db::SEPARATOR . $relationName;
            } else {
                $joinAsName = $relationName;
            }

            $this->getDb()->addJoin(
                $relationModel->getTableName(),
                $joinAsName,
                $field,
                $changedTableName
            );

            $relationModel->setDbRequestDataBeforeFind($joinAsName);
        }
    }

    /**
     * Model search in DB
     *
     * @return null|AbstractModel
     */
    public function find()
    {
        $result = $this->setDbRequestDataBeforeFind()->getDb()->find();

        if (!$result) {
            return null;
        }

        /**
         * @var AbstractModel $model
         */
        $model = new $this;
        $model->setFields($this->_parseDbResponse($result));
        $model->afterFind();

        return $model;
    }

    /**
     * Models search in DB
     *
     * @return null|AbstractModel[]
     */
    public function findAll()
    {
        $results = $this->setDbRequestDataBeforeFind()->getDb()->findAll();
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
            $model->afterFind();
            $list[] = $model;
        }

        return $list;
    }

    /**
     * Executes after finding
     */
    protected function afterFind()
    {
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

        foreach ($response as $field => $value) {
            if (strripos($field, Db::SEPARATOR)) {
                list($table, $field) = explode(Db::SEPARATOR, $field, 2);

                if (!isset($fields[$table])) {
                    $fields[$table] = [];
                }
                $fields[$table][$field] = $value;
            } else {
                $fields[$field] = $value;
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

        if (!empty($fields["id"])) {
            $this->id = (int)$fields["id"];
        }

        foreach ($fields as $field => $value) {
            if (!array_key_exists($field, $info)) {
                continue;
            }

            if (property_exists($this, $field)) {
                $this->$field = $value;
            }
        }

        foreach ($info as $field => $parameters) {
            $this
                ->_setFieldTypes($field, $parameters)
                ->_setFieldValues($field, $parameters);

            if (array_key_exists(self::FIELD_RELATION, $parameters)) {
                $this->$field = $this->getInt($this->$field);

                $relationModel = $parameters[self::FIELD_RELATION];
                $relationName = substr($field, 0, -2) . "Model";

                if (array_key_exists($relationName, $fields)) {
                    $relationModelName = "\\testS\\models\\" . $relationModel;
                    if (!$this->$relationName instanceof $relationModelName) {
                        $this->$relationName = new $relationModelName;
                    }

                    $this->$relationName->setFields($fields[$relationName]);
                }
            }
        }

        return $this;
    }

    /**
     * Sets field types
     *
     * @param string $field
     * @param array  $parameters
     *
     * @return AbstractModel
     */
    private function _setFieldTypes($field, array $parameters)
    {
        if (!array_key_exists(self::FIELD_TYPE, $parameters)) {
            return $this;
        }

        $method = sprintf("get%s", ucfirst($parameters[self::FIELD_TYPE]));
        if (method_exists($this, $method)) {
            $this->$field = $this->$method($this->$field);
        }

        return $this;
    }

    /**
     * Generates field value
     *
     * @param string $fieldValue
     * @param array  $generateInfo
     *
     * @return mixed
     */
    private function _generateFieldValue($fieldValue, array $generateInfo)
    {
        foreach ($generateInfo as $key => $value) {
            if (is_string($key)) {
                if (is_string($value)) {
                    if (stripos($value, "{") === 0) {
                        $value = str_replace(["{", "}"], "", $value);
                        $value = $this->$value;
                    }
                }

                if (is_array($value)) {
                    foreach ($value as &$val) {
                        if (is_string($val)) {
                            if (stripos($val, "{") === 0) {
                                $val = str_replace(["{", "}"], "", $val);
                                $val = $this->$val;
                            }
                        }
                    }
                }

                $fieldValue = ValueGenerator::$key($fieldValue, $value);
            } else {
                $fieldValue = ValueGenerator::$value($fieldValue);
            }
        }

        return $fieldValue;
    }

    /**
     * Sets field values
     *
     * @param string $field
     * @param array  $parameters
     *
     * @return AbstractModel
     */
    private function _setFieldValues($field, array $parameters)
    {
        if (!array_key_exists(self::FIELD_VALUE, $parameters)) {
            return $this;
        }

        $this->$field = $this->_generateFieldValue($this->$field, $parameters[self::FIELD_VALUE]);

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
        foreach ($this->getFieldsInfo() as $field => $parameters) {
            if (!array_key_exists(self::FIELD_RELATION, $parameters)) {
                continue;
            }

            $relationModel = $parameters[self::FIELD_RELATION];
            $relationName = substr($field, 0, -2) . "Model";
            $relationModelName = "\\testS\\models\\" . $relationModel;

            /**
             * @var AbstractModel $relationModel
             */
            if (!$this->$relationName instanceof $relationModelName
                || !$this->$relationName->id
            ) {
                $relationModel = new $relationModelName;
                $relationModel = $relationModel->byId($this->$field)->find();
            } else {
                $relationModel = $this->$relationName;
            }

            $relationModel->delete();
        }
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
                $validator = new Validator($this->$field, $info[self::FIELD_VALIDATION]);
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
        if (count($this->validate()->getErrors()) > 0) {
            return $this;
        }

        try {
            $this->beforeSave();
            if (count($this->getErrors()) > 0) {
                return $this;
            }

            if ($this->id) {
                $this->_update($where, $parameters);
            } else {
                $this->_create();
            }

            $this->afterSave();
        } catch (Exception $e) {
            $this->_onSaveFailure($e);
        }

        return $this;
    }

    /**
     * Runs before saving
     */
    protected function beforeSave()
    {
        $this
            ->_setFieldsBeforeSave()
            ->_setRelationsBeforeSave()
            ->checkParentsBeforeSave()
            ->_setFieldsAndDbRequestDataBeforeSave();
    }

    /**
     * Checks parents before save
     *
     * @return AbstractModel
     */
    protected function checkParentsBeforeSave()
    {
        foreach ($this->getFieldsInfo() as $field => $info) {
            if (!array_key_exists(self::FIELD_RELATION_TO_PARENT, $info)) {
                continue;
            }

            $this->checkParentBeforeSave($field, $this->$field, $info[self::FIELD_RELATION_TO_PARENT]);
        }

        return $this;
    }

    /**
     * Checks parent before save
     *
     * @param string $field
     * @param int    $value
     * @param string $parentModelName
     *
     * @throws ModelException
     */
    protected function checkParentBeforeSave($field, $value, $parentModelName)
    {
        $value = (int) $value;

        if ($value <= 0) {
            throw new ModelException(
                "Unable to save {className} because {field} is null",
                [
                    "className" => get_class($this),
                    "field"     => $field
                ]
            );
        }

        $className = "\\testS\\models\\" . $parentModelName;
        $model = new $className;
        if (!$model instanceof AbstractModel
            || !$model->byId($value)->find() instanceof AbstractModel
        ) {
            throw new ModelException(
                "Unable to find model: {model} with ID = {id}",
                [
                    "model" => $parentModelName,
                    "id"    => $value
                ]
            );
        }
    }

    /**
     * Runs after saving
     */
    protected function afterSave()
    {
    }

    /**
     * Creates a new record in DB
     */
    private function _create()
    {
        $this->id = $this->getDb()->insert();
    }

    /**
     * Updates the record in DB
     *
     * @param string $where
     * @param array  $parameters
     */
    private function _update($where, array $parameters)
    {
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
    }

    /**
     * On save failure
     *
     * @param Exception $e
     *
     * @throws ModelException
     */
    private function _onSaveFailure(Exception $e)
    {
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

            $parameters[$field] = $this->$field;
            $fields[] = $field;
        }

        $this->getDb()->setFields($fields);
        $this->getDb()->setParameters($parameters);

        return $this;
    }

    /**
     * Sets fields before save
     *
     * @return AbstractModel
     */
    private function _setFieldsBeforeSave()
    {
        foreach ($this->getFieldsInfo() as $field => $parameters) {
            if (!array_key_exists(self::FIELD_BEFORE_SAVE, $parameters)) {
                continue;
            }

            foreach ($parameters[self::FIELD_BEFORE_SAVE] as $key => $value) {
                if (is_string($key)) {
                    $method = $key;
                    if (method_exists($this, $method)) {
                        $this->$field = $this->$method($this->$field, $value);
                    }
                } else {
                    $method = $value;
                    if (method_exists($this, $method)) {
                        $this->$field = $this->$method($this->$field);
                    }
                }
            }
        }

        return $this;
    }

    /**
     * Sets relation fields before save
     *
     * @return AbstractModel
     *
     * @throws ModelException
     */
    private function _setRelationsBeforeSave()
    {
        foreach ($this->getRelationsFieldsInfo() as $field => $relationInfo) {
            /**
             * @var AbstractModel $relationModel
             */
            $relationName = $relationInfo[1];
            $relationModelName = "\\testS\\models\\" . $relationInfo[0];

            if (!$this->$relationName instanceof $relationModelName) {
                $relationModel = new $relationModelName;

                if ($this->$field !== 0) {
                    $relationModel = $relationModel->byId($this->$field)->find();
                    if (!$relationModel instanceof $relationModelName) {
                        throw new ModelException(
                            "Unable to find relation with name: {name} by id: {id}",
                            [
                                "name" => $relationName,
                                "id"   => $this->$field
                            ]
                        );
                    }
                }
            } else {
                $relationModel = $this->$relationName;
            }

            $relationModel->save();
            if (count($relationModel->getErrors()) > 0) {
                $this->addErrors($relationName, $relationModel->getErrors());
            }
            $this->$field = $relationModel->id;
        }

        return $this;
    }

    /**
     * Duplicates the model
     *
     * @return AbstractModel
     */
    public function duplicate()
    {
        /**
         * @var AbstractModel $duplicateModel
         */
        $duplicateModel = new $this;

        foreach ($this->getFieldsInfo() as $field => $info) {
            if (array_key_exists(self::FIELD_RELATION, $info)) {
                $relationName = substr($field, 0, -2) . "Model";
                $duplicateRelationModel = $this->$relationName->duplicate();
                $duplicateModel->$relationName = $duplicateRelationModel;
                $duplicateModel->$field = $duplicateRelationModel->id;
                continue;
            }

            if (array_key_exists(self::FIELD_SKIP_DUPLICATION, $info)) {
                $duplicateModel->$field = null;
                continue;
            }

            $duplicateModel->$field = $this->$field;

            if (array_key_exists(self::FIELD_CHANGE_ON_DUPLICATE, $info)) {
                $duplicateModel->$field = $this->_generateFieldValue(
                    $duplicateModel->$field,
                    $info[self::FIELD_CHANGE_ON_DUPLICATE]
                );
            }
        }

        $duplicateModel->save();

        return $duplicateModel;
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
        return trim((string)$value);
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
     * Gets int type
     *
     * @param mixed|string $value
     *
     * @return string
     */
    protected function getInt($value)
    {
        return (int)$value;
    }

    /**
     * Gets int type for DB
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
     * Gets bool type
     *
     * @param mixed|string $value
     *
     * @return string
     */
    protected function getBool($value)
    {
        return (bool)$value;
    }

    /**
     * Gets bool type
     *
     * @param mixed|string $value
     *
     * @return string
     */
    protected function getBoolForDb($value)
    {
        $value = (int)$value;
        if ($value >= 1) {
            return 1;
        }

        return 0;
    }
}