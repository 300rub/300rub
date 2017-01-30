<?php

namespace testS\models;

use testS\components\Db;
use testS\components\exceptions\ModelException;
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
                $relationField = substr($field, 0, -2) . "Model";
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
                && $this->_fields[$field] instanceof $relationModelName
            ) {
                $relationModel = $this->_fields[$field];
            } elseif (array_key_exists($relationIdField, $this->_fields)
                && $this->_fields[$relationIdField]
            ) {
                //TODO
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

    public final function find()
    {
        $this->setDbBeforeFind();
        var_dump($this->getDb()->getJoin());
        return null;
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

                $relationField = substr($field, 0, -2) . "Model";
                $relationModel->setDb($this->getDb());
                $relationAlias = $alias . Db::SEPARATOR . $relationField;
                $relationModel->setDbBeforeFind($relationAlias);

                $db->addJoin($relationModel->getTableName(), $relationAlias, $alias, $field);
            }
        }

        return $this;
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
}