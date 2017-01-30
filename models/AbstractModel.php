<?php

namespace testS\models;

use testS\components\Db;
use testS\components\exceptions\ModelException;
use testS\components\Validator;
use testS\components\ValueGenerator;
use Exception;

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
    const FIELD_ALLOW_NULL = "allowNull";

    /**
     * PK fields name
     */
    const PK_FIELD = "id";

    /**
     * Model fields
     *
     * @var array
     */
    private $_fields = [
        self::PK_FIELD => null
    ];

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
     */
    public function __construct()
    {
        $this->_createNullFields();
    }

    /**
     * Creates null fields
     *
     * @return AbstractModel
     */
    private function _createNullFields()
    {
        foreach ($this->getFieldsInfo() as $field => $info) {
            $this->_fields[$field] = null;

            if (array_key_exists(self::FIELD_RELATION, $info)) {
                $relationField = $this->_getRelationName($field);
                $this->_fields[$relationField] = null;
            }
        }

        return $this;
    }

    /**
     * Gets DB object
     *
     * @return Db
     */
    protected final function getDb()
    {
        if (!$this->_db instanceof Db) {
            $this->setDb(new Db(), true);
        }

        return $this->_db;
    }

    /**
     * Sets Db
     *
     * @param Db   $db
     * @param bool $isSetTable
     *
     * @return AbstractModel
     */
    protected final function setDb(Db $db, $isSetTable = false)
    {
        $this->_db = $db;

        if ($isSetTable === true) {
            $this->_db->setTable($this->getTableName());
        }

        return $this;
    }

    /**
     * Gets errors
     *
     * @return array
     */
    public final function getErrors()
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
    private function _addErrors($field, array $errors)
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
     * Sets field values
     *
     * @param array $fields
     *
     * @return AbstractModel
     */
    public final function set(array $fields)
    {
        return $this
            ->_setRelations($fields)
            ->_setRelationsToParent($fields)
            ->_setTypes($fields)
            ->_setValues($fields)
            ->_setNulls($fields);
    }

    /**
     * Sets relations
     *
     * @param array $fields
     *
     * @return AbstractModel
     *
     * @throws ModelException
     */
    private function _setRelations(array $fields)
    {
        $info = $this->getFieldsInfo();

        foreach ($fields as $field => $value) {
            $relationIdField = substr($field, 0, -5) . "Id";
            if (!array_key_exists($field, $this->_fields)
                || !is_array($value)
                || !array_key_exists($relationIdField, $info)
                || !array_key_exists(self::FIELD_RELATION, $info[$relationIdField])
            ) {
                continue;
            }

            /**
             * @var AbstractModel $relationModel
             */
            $relationModelName = "\\testS\\models\\" . $info[$relationIdField][self::FIELD_RELATION];
            $relationModel = new $relationModelName;
            if (array_key_exists($field, $this->_fields)
                && $this->get($field) instanceof $relationModelName
            ) {
                $relationModel = $this->_fields[$field];
            } elseif (array_key_exists($relationIdField, $this->_fields)
                && $this->get($relationIdField)
            ) {
                $relationModel = $relationModel->byId($this->get($relationIdField))->find();
                if (!$relationModel instanceof $relationModelName) {
                    throw new ModelException(
                        "Unable to get model {model} by ID: {id}",
                        [
                            "model" => $relationModelName,
                            "id"    => $this->get($relationIdField)
                        ]
                    );
                }
            }

            $relationModel->set($value);
            $this->_fields[$field] = $relationModel;
            $this->_fields[$relationIdField] = $relationModel->get("id");
        }

        return $this;
    }

    /**
     * Sets relations to parent
     *
     * @param array $fields
     *
     * @return AbstractModel
     */
    private function _setRelationsToParent(array $fields)
    {
        $info = $this->getFieldsInfo();

        foreach ($fields as $field => $value) {
            if (!array_key_exists($field, $this->_fields)
                || !array_key_exists($field, $info)
                || !array_key_exists(self::FIELD_RELATION_TO_PARENT, $info[$field])
            ) {
                continue;
            }

            $this->_fields[$field] = ValueGenerator::generate(ValueGenerator::INT, $value);
        }

        return $this;
    }

    /**
     * Sets types
     *
     * @param array $fields
     *
     * @return AbstractModel
     */
    private function _setTypes(array $fields)
    {
        $info = $this->getFieldsInfo();

        foreach ($fields as $field => $value) {
            var_dump($field, $value);

            if (!array_key_exists($field, $this->_fields)
                || !array_key_exists($field, $info)
                || !array_key_exists(self::FIELD_TYPE, $info[$field])
            ) {
                continue;
            }

            switch ($info[$field][self::FIELD_TYPE]) {
                case self::FIELD_TYPE_STRING:
                    $this->_fields[$field] = ValueGenerator::generate(ValueGenerator::STRING, $value);
                    break;
                case self::FIELD_TYPE_INT:
                    $this->_fields[$field] = ValueGenerator::generate(ValueGenerator::INT, $value);
                    break;
                case self::FIELD_TYPE_BOOL:
                    $this->_fields[$field] = ValueGenerator::generate(ValueGenerator::BOOL, $value);
                    break;
                default:
                    break;
            }
        }

        return $this;
    }

    /**
     * Sets values
     *
     * @param array $fields
     *
     * @return AbstractModel
     */
    private function _setValues(array $fields)
    {
        $info = $this->getFieldsInfo();

        foreach ($fields as $field => $value) {
            if (!array_key_exists($field, $this->_fields)
                || !array_key_exists($field, $info)
                || !array_key_exists(self::FIELD_VALUE, $info[$field])
            ) {
                continue;
            }

            foreach ($info[$field][self::FIELD_VALUE] as $valueGeneratorKey => $valueGeneratorValue) {
                if (!is_string($valueGeneratorKey)) {
                    $this->_fields[$field] = ValueGenerator::generate(
                        $valueGeneratorKey,
                        $this->get($field),
                        $valueGeneratorValue
                    );
                    continue;
                }

                if (is_string($valueGeneratorValue)
                    && stripos($valueGeneratorValue, "{") === 0
                ) {
                    $valueGeneratorValue = $this->get(
                        str_replace(["{", "}"], "", $valueGeneratorValue)
                    );
                } elseif (is_array($valueGeneratorValue)) {
                    foreach ($valueGeneratorValue as &$valueGeneratorVal) {
                        if (is_string($valueGeneratorVal)
                            && stripos($valueGeneratorVal, "{") === 0
                        ) {
                            $valueGeneratorVal = $this->get(
                                str_replace(["{", "}"], "", $valueGeneratorVal)
                            );
                        }
                    }
                }

                $this->_fields[$field] = ValueGenerator::generate(
                    $valueGeneratorKey,
                    $this->get($field),
                    $valueGeneratorValue
                );
            }
        }

        return $this;
    }

    /**
     * Sets null values
     *
     * @param array $fields
     *
     * @return AbstractModel
     */
    private function _setNulls(array $fields)
    {
        $info = $this->getFieldsInfo();

        foreach ($fields as $field => $value) {
            if (!array_key_exists($field, $this->_fields)
                || !array_key_exists($field, $info)
                || !array_key_exists(self::FIELD_ALLOW_NULL, $info[$field])
                || $info[$field][self::FIELD_ALLOW_NULL] !== true
                || $this->get($field)
            ) {
                continue;
            }

            $this->_fields[$field] = null;
        }

        return $this;
    }

    /**
     * Gets one or more fields
     *
     * @param string|string[] $param
     *
     * @return mixed
     *
     * @throws ModelException
     */
    public final function get($param = null)
    {
        if ($param === null) {
            return $this->_fields;
        }

        if (is_array($param)) {
            $list = [];
            foreach ($param as $field) {
                if (!array_key_exists($field, $this->_fields)) {
                    throw new ModelException(
                        "Unable to find the field {field} from the model {model}",
                        [
                            "field" => $field,
                            "model" => get_class($this)
                        ]
                    );
                }

                $list[$field] = $this->_fields[$field];
            }

            return $list;
        }

        if (!array_key_exists($param, $this->_fields)) {
            throw new ModelException(
                "Unable to find field {field} for model {model}",
                [
                    "field" => $param,
                    "model" => get_class($this)
                ]
            );
        }
        return $this->_fields[$param];
    }

    /**
     * Model search in DB
     *
     * @return null|AbstractModel
     */
    public final function find()
    {
        $result = $this->setDbBeforeFind()->getDb()->find();

        if (!$result) {
            return null;
        }

        /**
         * @var AbstractModel $model
         */
//@TODO        $model = new $this;
//        $model->setFields($this->_parseDbResponse($result));
//        $model->afterFind();
//
//        return $model;
    }

    /**
     * Sets DB before find
     *
     * @param string $alias
     *
     * @return AbstractModel
     */
    public final function setDbBeforeFind($alias = Db::DEFAULT_ALIAS)
    {
        $info = $this->getFieldsInfo();
        $db = $this->getDb();

        foreach ($info as $field => $value) {
            $db->addSelect($field, $alias);

            if ($this->_withRelations === true
                && array_key_exists(self::FIELD_RELATION, $info[$field])
            ) {
                $relationModel = $this->_getRelationModelByFieldName($field);
                if (!$relationModel instanceof AbstractModel) {
                    continue;
                }

                $relationField = $this->_getRelationName($field);
                $relationModel->setDb($this->getDb());
                $relationAlias = $alias . Db::SEPARATOR . $relationField;
                $relationModel->setDbBeforeFind($relationAlias);

                $db->addJoin($relationModel->getTableName(), $relationAlias, $alias, $field);
            }
        }

        return $this;
    }

    /**
     * Gets relation name
     *
     * @param string $fieldName
     *
     * @return string
     */
    private function _getRelationName($fieldName)
    {
        return substr($fieldName, 0, -2) . "Model";
    }

    /**
     * Gets relation model
     *
     * @param string $fieldName
     *
     * @return AbstractModel
     */
    private function _getRelationModelByFieldName($fieldName)
    {
        $info = $this->getFieldsInfo();
        if (!array_key_exists($fieldName, $info)
            || !array_key_exists(self::FIELD_RELATION, $info[$fieldName])
        ) {
            return null;
        }

        $relationField = substr($fieldName, 0, -2) . "Model";
        $relationModelName = "\\testS\\models\\" . $info[$fieldName][self::FIELD_RELATION];
        if ($this->get($relationField) instanceof $relationModelName) {
            return $this->get($relationField);
        }

        return new $relationModelName;
    }

    /**
     * With all relations
     *
     * @param bool $withRelations
     *
     * @return AbstractModel
     */
    public final function withRelations($withRelations = true)
    {
        $this->_withRelations = $withRelations;
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
        $this->getDb()->addWhere(sprintf("%s.id = :id", Db::DEFAULT_ALIAS));
        $this->getDb()->addParameter("id", $id);

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

            $this->_setFieldsForDbBeforeSave();

            if ($this->get(self::PK_FIELD)) {
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
     * Creates a new record in DB
     */
    private function _create()
    {
        $this->_fields[self::PK_FIELD] = $this->getDb()->insert();
    }

    /**
     * Updates the record in DB
     *
     * @param string $where
     * @param array  $parameters
     */
    private function _update($where, array $parameters)
    {
        $db = $this->getDb();

        if ($where === null) {
            $db
                ->setWhere("id = :id")
                ->addParameter("id", $this->get(self::PK_FIELD));
        } else {
            $db->setWhere($where);

            if (count($parameters) > 0) {
                foreach ($parameters as $parameterKey => $parameterValue) {
                    $db->addParameter($parameterKey, $parameterValue);
                }
            }
        }

        $this->getDb()->update();
    }

    /**
     * Sets fields for DB
     *
     * @return AbstractModel
     */
    private function _setFieldsForDbBeforeSave()
    {
        $info = $this->getFieldsInfo();
        $db = $this->getDb();

        foreach ($info as $field => $fieldInfo) {
            $db->addField($field);

            if (!array_key_exists(self::FIELD_TYPE, $fieldInfo)) {
                $db->addParameter($field, $this->get($field));
                continue;
            }

            switch ($fieldInfo[self::FIELD_TYPE]) {
                case self::FIELD_TYPE_BOOL:
                    $db->addParameter($field, ValueGenerator::generate(ValueGenerator::BOOL_INT, $this->get($field)));
                    break;
                default:
                    break;
            }
        }

        return $this;
    }

    /**
     * Runs after saving
     */
    protected function afterSave()
    {
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
        $info = $this->getFieldsInfo();
        $fields = [];

        foreach ($info as $field => $fieldInfo) {
            if (!is_object($this->get($field))) {
                $fields[] = sprintf("%s: %s", $field, $this->get($field));
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
     * Validates model's fields
     *
     * @return AbstractModel
     */
    public final function validate()
    {
        $info = $this->getFieldsInfo();

        foreach ($info as $field => $fieldInfo) {
            if (array_key_exists(self::FIELD_VALIDATION, $fieldInfo)) {
                $validator = new Validator($this->get($field), $fieldInfo[self::FIELD_VALIDATION]);
                $this->_addErrors($field, $validator->validate()->getErrors());
            }
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
            ->_checkParentsBeforeSave();
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
                        $this->_fields[$field] = $this->$method($this->get($field), $value);
                    }
                } else {
                    $method = $value;
                    if (method_exists($this, $method)) {
                        $this->_fields[$field] = $this->$method($this->get($field));
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
        $info = $this->getFieldsInfo();

        foreach ($info as $field => $relationInfo) {
            if (!array_key_exists(self::FIELD_RELATION, $relationInfo)) {
                continue;
            }

            /**
             * @var AbstractModel $relationModel
             */
            $relationName = $this->_getRelationName($field);
            $relationModelName = "\\testS\\models\\" . $relationInfo[self::FIELD_RELATION];

            if (!$this->get($relationName) instanceof $relationModelName) {
                $relationModel = new $relationModelName;

                if ($this->get($field) !== 0) {
                    $relationModel = $relationModel->byId($this->get($field))->find();
                    if (!$relationModel instanceof $relationModelName) {
                        throw new ModelException(
                            "Unable to find relation with name: {name} by id: {id}",
                            [
                                "name" => $relationName,
                                "id"   => $this->get($field)
                            ]
                        );
                    }
                }
            } else {
                $relationModel = $this->get($relationName);
            }

            $relationModel->save();
            if (count($relationModel->getErrors()) > 0) {
                $this->_addErrors($relationName, $relationModel->getErrors());
            }

            $this->set([$field => $relationModel->get(self::PK_FIELD)]);
        }

        return $this;
    }

    /**
     * Checks parents before save
     *
     * @throws ModelException
     *
     * @return AbstractModel
     */
    private function _checkParentsBeforeSave()
    {
        $info = $this->getFieldsInfo();

        foreach ($info as $field => $fieldInfo) {
            if (!array_key_exists(self::FIELD_RELATION_TO_PARENT, $fieldInfo)) {
                continue;
            }

            $value = $this->get($field);

            if ($value === 0) {
                throw new ModelException(
                    "Unable to save {className} because {field} is 0",
                    [
                        "className" => get_class($this),
                        "field"     => $field
                    ]
                );
            }

            $modelName = "\\testS\\models\\" . $fieldInfo[self::FIELD_RELATION_TO_PARENT];
            $model = new $modelName;
            if (!$model instanceof AbstractModel
                || !$model->byId($value)->find() instanceof AbstractModel
            ) {
                throw new ModelException(
                    "Unable to find model: {model} with ID = {id}",
                    [
                        "model" => $modelName,
                        "id"    => $value
                    ]
                );
            }
        }

        return $this;
    }
}