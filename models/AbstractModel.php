<?php

namespace testS\models;

use testS\components\Db;
use testS\components\exceptions\CommonException;
use testS\components\exceptions\ModelException;
use testS\components\Language;
use testS\components\Validator;
use testS\components\ValueGenerator;
use Exception;
use DateTime;
use testS\components\View;

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
    const FIELD_BEFORE_DUPLICATE = "beforeDuplicate";
    const FIELD_ALLOW_NULL = "allowNull";
    const FIELD_NOT_CHANGE_ON_UPDATE = "notChangeOnUpdate";
    const FIELD_CURRENT_DATE_TIME = "currentDateTime";
    const FIELD_UNIQUE = "unique";

    /**
     * PK fields name
     */
    const PK_FIELD = "id";

    /**
     * CSS
     *
     * @var array
     */
    private static $_css = [];

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
     * Relations to except
     *
     * @var array
     */
    private $_exceptRelations = [];

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
        $this->_setDefaultValues();
    }

    /**
     * Sets default values
     *
     * @return AbstractModel
     */
    private function _setDefaultValues()
    {
        foreach ($this->getFieldsInfo() as $field => $info) {
            if (array_key_exists(self::FIELD_ALLOW_NULL, $info)) {
                $this->_fields[$field] = null;
                continue;
            }

            if (array_key_exists(self::FIELD_TYPE, $info)) {
                switch ($info[self::FIELD_TYPE]) {
                    case self::FIELD_TYPE_INT:
                        $this->_fields[$field] = 0;
                        break;
                    case self::FIELD_TYPE_FLOAT:
                        $this->_fields[$field] = 0.0;
                        break;
                    case self::FIELD_TYPE_STRING:
                        $this->_fields[$field] = "";
                        break;
                    case self::FIELD_TYPE_BOOL:
                        $this->_fields[$field] = false;
                        break;
                    case self::FIELD_TYPE_DATETIME:
                        $this->_fields[$field] = new DateTime();
                        break;
                    default:
                        $this->_fields[$field] = null;
                        break;
                }

                continue;
            }

            if (array_key_exists(self::FIELD_RELATION, $info)) {
                $relationField = $this->_getRelationName($field);
                $this->_fields[$relationField] = null;
                $this->_fields[$field] = 0;
                continue;
            }

            if (array_key_exists(self::FIELD_RELATION_TO_PARENT, $info)) {
                $this->_fields[$field] = 0;
                continue;
            }

            $this->_fields[$field] = null;
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
     * Clears errors
     *
     * @return AbstractModel
     */
    private function _clearErrors()
    {
        $this->_errors = [];
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
    protected function addErrors($field, array $errors)
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
     * Clears ID
     *
     * @return AbstractModel
     */
    public function clearId()
    {
        $this->_fields[self::PK_FIELD] = 0;
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
            ->_setValues()
            ->_setNulls($fields)
            ->_setId($fields);
    }

    /**
     * Sets ID
     *
     * @param array $fields
     *
     * @return AbstractModel
     */
    private function _setId(array $fields)
    {
        if (array_key_exists(self::PK_FIELD, $fields)) {
            $this->_fields[self::PK_FIELD] = (int) $fields[self::PK_FIELD];
        }

        return $this;
    }

    /**
     * Flag is new model
     *
     * @return bool
     */
    protected function isNew()
    {
        return $this->getId() === 0;
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

        // Sets from model arrays
        foreach ($fields as $field => $value) {
            $relationIdField = $this->_getRelationIdFields($field);
            if (!array_key_exists($field, $this->_fields)
                || !is_array($value)
                || !array_key_exists($relationIdField, $info)
                || !array_key_exists(self::FIELD_RELATION, $info[$relationIdField])
            ) {
                continue;
            }

            if (!$this->isNew()
                && array_key_exists(self::FIELD_NOT_CHANGE_ON_UPDATE, $info[$relationIdField])
            ) {
                continue;
            }

            $relationModel = $this->_getRelationModelByFieldName($relationIdField, !$this->isNew());
            $relationModel->set($value);

            $this->_fields[$field] = $relationModel;
            $this->_fields[$relationIdField] = $relationModel->getId();
        }

        // Sets relation IDs
        foreach ($fields as $field => $value) {
            if (!array_key_exists($field, $info)
                || !array_key_exists(self::FIELD_RELATION, $info[$field])
                || (int) $value === 0
            ) {
                continue;
            }

            $this->_fields[$field] = (int) $value;
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

            if (!$this->isNew()
                && array_key_exists(self::FIELD_NOT_CHANGE_ON_UPDATE, $info[$field])
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
            if (!array_key_exists($field, $this->_fields)
                || !array_key_exists($field, $info)
                || !array_key_exists(self::FIELD_TYPE, $info[$field])
            ) {
                continue;
            }

            if (!$this->isNew()
                && array_key_exists(self::FIELD_NOT_CHANGE_ON_UPDATE, $info[$field])
            ) {
                continue;
            }

            if (is_array($value) || is_object($value)) {
                $value = null;
            }

            switch ($info[$field][self::FIELD_TYPE]) {
                case self::FIELD_TYPE_STRING:
                    $this->_fields[$field] = ValueGenerator::generate(ValueGenerator::STRING, $value);
                    break;
                case self::FIELD_TYPE_INT:
                    $this->_fields[$field] = ValueGenerator::generate(ValueGenerator::INT, $value);
                    break;
                case self::FIELD_TYPE_FLOAT:
                    $this->_fields[$field] = ValueGenerator::generate(ValueGenerator::FLOAT, $value);
                    break;
                case self::FIELD_TYPE_BOOL:
                    $this->_fields[$field] = ValueGenerator::generate(ValueGenerator::BOOL, $value);
                    break;
                case self::FIELD_TYPE_DATETIME:
                    if (array_key_exists(self::FIELD_CURRENT_DATE_TIME, $info[$field])) {
                        $value = "now";
                    }
                    $this->_fields[$field] = ValueGenerator::generate(ValueGenerator::DATETIME, $value);
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
     * @return AbstractModel
     */
    private function _setValues()
    {
        $info = $this->getFieldsInfo();

        foreach ($info as $field => $fieldInfo) {
            if (!array_key_exists(self::FIELD_VALUE, $fieldInfo)) {
                continue;
            }

            if (!$this->isNew()
                && array_key_exists(self::FIELD_NOT_CHANGE_ON_UPDATE, $info[$field])
            ) {
                continue;
            }

            foreach ($fieldInfo[self::FIELD_VALUE] as $valueGeneratorKey => $valueGeneratorValue) {
                if (!is_string($valueGeneratorKey)) {
                    $this->_fields[$field] = ValueGenerator::generate(
                        $valueGeneratorValue,
                        $this->get($field)
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
     * @param string|string[] $except
     *
     * @return mixed
     *
     * @throws ModelException
     */
    public final function get($param = null, $except = null)
    {
        if ($param === null) {
            if (is_array($except)) {
                $list = [];
                foreach ($this->_fields as $key => $value) {
                    if (!in_array($key, $except)) {
                        $list[$key] = $value;
                    }
                }
                return $list;
            }

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
     * Gets ID
     *
     * @return int
     */
    public function getId()
    {
        return (int) $this->get(self::PK_FIELD);
    }

    /**
     * Model search in DB
     *
     * @return AbstractModel|null
     */
    public function find()
    {
        $result = $this->setDbBeforeFind()->getDb()->find();
        $this->getDb()->reset();

        if (!$result) {
            return null;
        }

        /**
         * @var AbstractModel $model
         */
        $model = new $this;
        $model->set($this->_parseDbResponse($result));
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
        $results = $this->setDbBeforeFind()->getDb()->findAll();
        $this->getDb()->reset();

        if (!$results) {
            return [];
        }

        $list = [];
        foreach ($results as $result) {
            /**
             * @var AbstractModel $model
             */
            $model = new $this;
            $model->set($this->_parseDbResponse($result));
            $model->afterFind();
            $list[] = $model;
        }

        return $list;
    }

    /**
     * Count of records
     *
     * @return int
     */
    public function getCount()
    {
        $results = $this->setDbBeforeFind()->getDb()->findAll();
        $this->getDb()->reset();

        return count($results);
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
        $helpList = [];
        $list = [];

        foreach ($response as $fullFieldName => $value) {
            if (strripos($fullFieldName, Db::SEPARATOR)) {
                list($alias, $field) = explode(Db::SEPARATOR, $fullFieldName, 2);
                if (!array_key_exists($alias, $helpList)) {
                    $helpList[$alias] = [];
                }
                $helpList[$alias][$field] = $value;
            } else {
                $list[$fullFieldName] = $value;
            }
        }

        foreach ($helpList as $key => $response) {
            if ($key === Db::DEFAULT_ALIAS) {
                foreach ($response as $k => $value) {
                    $list[$k] = $value;
                }
            } else {
                $list[$key] = $this->_parseDbResponse($response);
            }
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

        $db->addSelect(self::PK_FIELD, $alias);

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

                if ($alias === Db::DEFAULT_ALIAS) {
                    $relationAlias = $relationField;
                } else {
                    $relationAlias = $alias . Db::SEPARATOR . $relationField;
                }

                if (in_array($relationAlias, $this->_exceptRelations)) {
                    continue;
                }

                $relationModel->withRelations()->exceptRelations($this->_exceptRelations);
                $relationModel->setDb($this->getDb());

                $db->addJoin($relationModel->getTableName(), $relationAlias, $alias, $field);

                $relationModel->setDbBeforeFind($relationAlias);
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
     * Gets relation Id field
     *
     * @param string $relationName
     *
     * @return string
     */
    private function _getRelationIdFields($relationName)
    {
        return substr($relationName, 0, -5) . "Id";
    }

    /**
     * Gets relation model
     *
     * @param string $fieldName
     * @param bool   $isFind
     *
     * @return AbstractModel
     *
     * @throws ModelException
     */
    private function _getRelationModelByFieldName($fieldName, $isFind = false)
    {
        $info = $this->getFieldsInfo();
        if (!array_key_exists($fieldName, $info)
            || !array_key_exists(self::FIELD_RELATION, $info[$fieldName])
        ) {
            return null;
        }

        $relationField = $this->_getRelationName($fieldName);
        $relationModelName = "\\testS\\models\\" . $info[$fieldName][self::FIELD_RELATION];
        if ($this->get($relationField) instanceof $relationModelName) {
            return $this->get($relationField);
        }

        if ($isFind === false) {
            return new $relationModelName;
        }

        /**
         * @var AbstractModel $model;
         */
        $model = new $relationModelName;
        $model = $model->byId($this->get($fieldName))->find();
        if ($model === null) {
            throw new ModelException(
                "Unable to find model: {model} by ID: {id}",
                [
                    "model" => $relationModelName,
                    "id"    => $this->get($fieldName)
                ]
            );
        }

        return $model;
    }

    /**
     * With all relations
     *
     * @param bool $withRelations
     *
     * @return AbstractModel
     */
    public function withRelations($withRelations = true)
    {
        $this->_withRelations = $withRelations;
        return $this;
    }

    /**
     * Except relations
     *
     * @param string[] $aliases
     *
     * @return AbstractModel
     */
    public function exceptRelations(array $aliases)
    {
        $this->_exceptRelations = $aliases;
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
        $this->getDb()->addParameter("id", (int) $id);

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
        $this->getDb()->addWhere(sprintf("%s.id != :id", Db::DEFAULT_ALIAS));
        $this->getDb()->addParameter("id", (int) $id);

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
        $this->_clearErrors();
        if (count($this->validate()->getErrors()) > 0) {
            return $this;
        }

        try {
            $this->beforeSave();
            if (count($this->getErrors()) > 0) {
                return $this;
            }

            $this->_setFieldsForDbBeforeSave();

            if ($this->getId()) {
                $this->_update($where, $parameters);
            } else {
                $this->_create();
            }

            $this->getDb()->reset();

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
        $this->set([self::PK_FIELD => (int) $this->getDb()->insert()]);
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
                ->addParameter("id", $this->getId());
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
                case self::FIELD_TYPE_STRING:
                    $db->addParameter($field, ValueGenerator::generate(ValueGenerator::STRING, $this->get($field)));
                    break;
                case self::FIELD_TYPE_DATETIME:
                    $db->addParameter(
                        $field,
                        ValueGenerator::generate(ValueGenerator::DATETIME_AS_STRING, $this->get($field))
                    );
                    break;
                default:
                    $db->addParameter($field, $this->get($field));
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
            $value = $this->get($field);

            if (is_object($value)) {
                continue;
            }

            if (is_bool($value)) {
                $value = (int) $value;
            }

            $fields[] = sprintf("%s: %s", $field, $value);

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

        foreach (array_keys($info) as $field) {
            $rules = $this->getValidationRulesForField($field);
            if (count($rules) === 0) {
                continue;
            }

            $validator = new Validator($this->get($field), $rules);
            $this->addErrors($field, $validator->validate()->getErrors());
        }

        return $this;
    }

    /**
     * Gets parsed errors
     *
     * @return array
     */
    public function getParsedErrors()
    {
        $parsedErrors = [];

        $errors = $this->getErrors();
        foreach ($errors as $key => $values) {
            if (count($values) > 0) {
                $parsedErrors[$key] = Language::t("validation", $values[0]);
            }
        }

        return $parsedErrors;
    }

    /**
     * Gets validation rules for field
     *
     * @param string $field
     *
     * @return array
     *
     * @throws ModelException
     */
    public final function getValidationRulesForField($field)
    {
        $info = $this->getFieldsInfo();
        if (!array_key_exists($field, $info)) {
            throw new ModelException(
                "Unable to find field: {field} for model: {model}",
                [
                    "field" => $field,
                    "model" => get_class($this)
                ]
            );
        }

        if (!array_key_exists(self::FIELD_VALIDATION, $info[$field])) {
            return [];
        }

        $rules = [];
        foreach ($info[$field][self::FIELD_VALIDATION] as $key => $value) {
            if (!is_string($key)) {
                $key = $value;
            }

            $rules[$key] = $value;
        }

        return $rules;
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
            if (array_key_exists(self::FIELD_BEFORE_SAVE, $parameters)) {
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

            if (array_key_exists(self::FIELD_UNIQUE, $parameters)) {
                $model = $this->exceptId($this->getId())->_checkUnique($field)->find();
                if ($model !== null) {
                    $this->addErrors($field, [Validator::TYPE_UNIQUE]);
                }
            }
        }

        return $this;
    }

    /**
     * Adds condition to check unique value
     *
     * @param string $field
     *
     * @return AbstractModel
     */
    private function _checkUnique($field)
    {
        $this->getDb()->addWhere(sprintf("%s.%s = :field", Db::DEFAULT_ALIAS, $field));
        $this->getDb()->addParameter("field", $this->get($field));

        return $this;
    }

    /**
     * Adds condition to select latest model
     *
     * @return AbstractModel
     */
    public function latest()
    {
        $this->getDb()->setOrder(sprintf("%s.id DESC", Db::DEFAULT_ALIAS));

        return $this;
    }

    /**
     * Adds ORDER BY to SQL request
     *
     * @param string|array $value
     * @param string       $alias
     * @param bool         $isDesc
     *
     * @return AbstractModel
     */
    public function ordered($value = "name", $alias = Db::DEFAULT_ALIAS, $isDesc = false)
    {
        if ($isDesc === true) {
            $order = "DESC";
        } else {
            $order = "ASC";
        }

        if (is_array($value)) {
            $list = [];
            foreach ($value as $v) {
                $list[] = sprintf("%s.%s", $alias, $v);
            }
            $orderBy = implode(",", $list);
        } else {
            $orderBy = sprintf("%s.%s", $alias, $value);
        }

        $this->getDb()->setOrder(sprintf("%s %s", $orderBy, $order));

        return $this;
    }

    /**
     * Adds in condition to SQL request
     *
     * @param string $field
     * @param array  $values
     * @param string $alias
     *
     * @return AbstractModel
     */
    public function in($field, $values, $alias = Db::DEFAULT_ALIAS)
    {
        $this->getDb()->addWhere(
            sprintf(
                "%s.%s IN (%s)",
                $alias,
                $field,
                implode(",", $values)
            )
        );

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
                $this->addErrors($relationName, $relationModel->getErrors());
            }

            $this->_fields[$field] = $relationModel->getId();
            $this->_fields[$relationName] = $relationModel;
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

            if (array_key_exists(self::FIELD_ALLOW_NULL, $fieldInfo)
                && $value === null
            ) {
                continue;
            }

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
            if (!$this->getId()) {
                throw new ModelException("Unable to delete the record with null ID");
            }

            $this->getDb()->setWhere("id = :id");
            $this->getDb()->addParameter("id", (int) $this->getId());
        } else {
            $this->getDb()->setWhere($where);

            if (count($parameters) > 0) {
                foreach ($parameters as $key => $value) {
                    $this->getDb()->addParameter($key, $value);
                }
            }
        }

        $this->beforeDelete();
        $this->getDb()->delete();
        $this->getDb()->reset();
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
        $info = $this->getFieldsInfo();

        foreach ($info as $field => $parameters) {
            if (!array_key_exists(self::FIELD_RELATION, $parameters)) {
                continue;
            }

            $relationModel = $this->_getRelationModelByFieldName($field, true);
            $relationModel->delete();
        }
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
            if (array_key_exists(self::FIELD_SKIP_DUPLICATION, $info)) {
                if (array_key_exists(self::FIELD_RELATION, $info)
                    || array_key_exists(self::FIELD_RELATION_TO_PARENT, $info)
                ) {
                    $duplicateModel->_fields[$field] = null;
                } else {
                    $duplicateModel->set([$field => null]);
                }

                continue;
            }

            if (array_key_exists(self::FIELD_RELATION, $info)) {
                $relationName = $this->_getRelationName($field);
                $relationModel = $this->_getRelationModelByFieldName($field, true);
                if (!$relationModel instanceof AbstractModel) {
                    continue;
                }
                $duplicateRelationModel = $relationModel->duplicate();
                $duplicateModel->_fields[$relationName] = $duplicateRelationModel;
                $duplicateModel->_fields[$field] = $duplicateRelationModel->getId();
                continue;
            }

            $duplicateModel->_fields[$field] = $this->get($field);

            if (array_key_exists(self::FIELD_BEFORE_DUPLICATE, $info)) {
                foreach ($info[self::FIELD_BEFORE_DUPLICATE] as $key => $value) {
                    if (is_string($key)) {
                        $method = $key;
                        if (method_exists($this, $method)) {
                            $duplicateModel->set(
                                [
                                    $field => $duplicateModel->$method($duplicateModel->get($field), $value)
                                ]
                            );
                        }
                    } else {
                        $method = $value;
                        if (method_exists($this, $method)) {
                            $duplicateModel->set(
                                [
                                    $field => $duplicateModel->$method($duplicateModel->get($field))
                                ]
                            );
                        }
                    }
                }
            }

            if (!array_key_exists(self::FIELD_CHANGE_ON_DUPLICATE, $info)) {
                continue;
            }

            foreach ($info[self::FIELD_CHANGE_ON_DUPLICATE] as $valueGeneratorKey => $valueGeneratorValue) {
                if (!is_string($valueGeneratorKey)) {
                    $duplicateModel->_fields[$field] = ValueGenerator::generate(
                        $valueGeneratorValue,
                        $duplicateModel->get($field)
                    );
                    continue;
                }


                if (is_string($valueGeneratorValue)
                    && stripos($valueGeneratorValue, "{") === 0
                ) {
                    $valueGeneratorValue = $duplicateModel->get(
                        str_replace(["{", "}"], "", $valueGeneratorValue)
                    );
                } elseif (is_array($valueGeneratorValue)) {
                    foreach ($valueGeneratorValue as &$valueGeneratorVal) {
                        if (is_string($valueGeneratorVal)
                            && stripos($valueGeneratorVal, "{") === 0
                        ) {
                            $valueGeneratorVal = $duplicateModel->get(
                                str_replace(["{", "}"], "", $valueGeneratorVal)
                            );
                        }
                    }
                }

                $duplicateModel->_fields[$field] = ValueGenerator::generate(
                    $valueGeneratorKey,
                    $duplicateModel->get($field),
                    $valueGeneratorValue
                );
            }
        }

        $duplicateModel->save();
        $duplicateModel->afterDuplicate($this);

        return $duplicateModel;
    }

    /**
     * After duplicate
     *
     * @param AbstractModel $oldModel
     */
    protected function afterDuplicate($oldModel)
    {
    }

    /**
     * Gets CSS
     *
     * @return array
     */
    public static function getCss()
    {
        return self::$_css;
    }

    /**
     * Adds CSS to collection
     *
     * @param AbstractModel $model
     * @param string        $selector
     *
     * @throws CommonException
     *
     * @return AbstractModel
     */
    protected function addCss(AbstractModel $model, $selector)
    {
        $type = null;
        if ($model instanceof DesignBlockModel) {
            $type = "block";
        } elseif ($model instanceof DesignTextModel) {
            $type = "text";
        }

        if ($type === null) {
            throw new CommonException(
                "Unable to detect design type to get CSS. Model given: {class}",
                [
                    "class" => get_class($model)
                ]
            );
        }

        $id = sprintf(
            "%s-%s",
            str_replace([".", " "], ["", "-"], $selector),
            $type
        );

        if (array_key_exists($id, self::$_css)) {
            return $this;
        }

        $css = "";
//        $isUser = App::web()->getUser() !== null;
//
//        if ($isUser === true) {
//            $css .= sprintf('<div id="%s">', $id);
//            $css .= "<style>";
//        }

        $css .= View::get(
            "design/" . $type,
            [
                "model"    => $model,
                "id"       => $id,
                "selector" => $selector,
            ]
        );

//        if ($isUser === true) {
//            $css .= '</style></div>';
//        }

        self::$_css[$id] = $css;

        return $this;
    }
}