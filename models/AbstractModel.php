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
    const FIELD_RELATION = "relation";
    const FIELD_TYPE = "type";
    const FIELD_TYPE_STRING = "string";
    const FIELD_TYPE_INT = "int";
    const FIELD_TYPE_BOOL = "bool";
    const FIELD_RELATION_MODEL = "model";
    const FIELD_RELATION_TYPE = "type";
    const FIELD_RELATION_TYPE_BELONGS_TO = "belongs_to";
    const FIELD_RELATION_TYPE_HAS_ONE = "has_one";
    const FIELD_RELATION_NAME = "relationName";

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
    abstract protected function getFieldsInfo();

    /**
     * Constructor
     *
     * @param Db $db
     */
    public function __construct($db = null)
    {
        $this->_createNullFields();

        if ($db !== null) {
            $this->setDb($db);
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
                $f = $info[self::FIELD_RELATION][self::FIELD_RELATION_NAME];
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
            $this->_db = new Db();
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
    protected function setDb(Db $db)
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
     * Sets Db request data before find
     *
     * @param string $changedTableName
     *
     * @return AbstractModel
     */
    public function setDbRequestDataBeforeFind($changedTableName = "")
    {
        $isRelation = true;
        if ($changedTableName === "") {
            $changedTableName = $this->getTableName();
            $isRelation = false;
        }

        $this->getDb()->addSelect(
            $changedTableName,
            "id",
            $isRelation
        );

        foreach (array_keys($this->getFieldsInfo()) as $field) {
            $this->getDb()->addSelect(
                $changedTableName,
                $field,
                $isRelation
            );
        }

        if ($this->_withRelations === false) {
            return $this;
        }

        /**
         * @var AbstractModel $relationModel
         */
        foreach ($this->getRelationsFieldsInfo() as $field => $parameters) {
            if ($parameters[self::FIELD_RELATION_TYPE] !== self::FIELD_RELATION_TYPE_BELONGS_TO) {
                continue;
            }

            $relationName = $parameters[self::FIELD_RELATION_NAME];
            $relationModel = "\\testS\\models\\" . $parameters[self::FIELD_RELATION_MODEL];
            $relationModel = new $relationModel($this->getDb());

            if ($isRelation === true) {
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
     * Executes after finding
     */
    protected function afterFind()
    {
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
            $this->id = (int) $fields["id"];
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
            if (array_key_exists(self::FIELD_TYPE, $parameters)) {
                $method = sprintf("get%s", ucfirst($parameters[self::FIELD_TYPE]));
                if (method_exists($this, $method)) {
                    $this->$field = $this->$method($this->$field);
                }
            }

            if (array_key_exists(self::FIELD_SET, $parameters)) {
                foreach ($parameters[self::FIELD_SET] as $key => $value) {
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

            if (array_key_exists(self::FIELD_RELATION, $parameters)) {
                $this->$field = $this->getInt($this->$field);

                $relationInfo = $parameters[self::FIELD_RELATION];
                $relationName = $relationInfo[self::FIELD_RELATION_NAME];

                if (array_key_exists($relationName, $fields)) {
                    $relationModelName = "\\testS\\models\\" . $relationInfo[self::FIELD_RELATION_MODEL];
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

            /**
             * @var AbstractModel $relationModel
             */
            $relationInfo = $parameters[self::FIELD_RELATION];
            if ($relationInfo[self::FIELD_RELATION_TYPE] === self::FIELD_RELATION_TYPE_BELONGS_TO) {
                $relationName = $relationInfo[self::FIELD_RELATION_NAME];
                $relationModelName = "\\testS\\models\\" . $relationInfo[self::FIELD_RELATION_MODEL];
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
            $this->_setFieldsAndDbRequestDataBeforeSave();

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

            $parameters[$field] = $this->$field;
            $fields[] = $field;
        }

        $this->getDb()->setFields($fields);
        $this->getDb()->setParameters($parameters);

        return $this;
    }

    /**
     * Runs before saving
     */
    protected function beforeSave()
    {
        foreach ($this->getRelationsFieldsInfo() as $field => $relationInfo) {
            /**
             * @var AbstractModel $relationModel
             */
            $relationName = $relationInfo[self::FIELD_RELATION_NAME];
            $relationModelName = "\\testS\\models\\" . $relationInfo[self::FIELD_RELATION_MODEL];

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
            $this->$field = $relationModel->id;
        }
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
    public function withRelations()
    {
        $this->_withRelations = true;
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
     * Gets int type
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
        return (bool) $value;
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
        $value = (int) $value;
        if ($value >= 1) {
            return 1;
        }

        return 0;
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
     * Sets language
     *
     * @param int $value
     *
     * @return int
     */
    protected function setLanguage($value)
    {
        if ($value === 0
            || !array_key_exists($value, Language::$aliasList)
        ) {
            $value = Language::$activeId;
        }

        return $value;
    }
}