<?php

namespace testS\models\_abstract;

use testS\application\App;
use testS\application\components\Db;

/**
 * Abstract class for working with models
 */
abstract class AbstractBaseModel
{

    /**
     * Keys for fields
     */
    const FIELD_VALIDATION = 'validation';
    const FIELD_VALUE = 'value';
    const FIELD_SKIP_DUPLICATION = 'skipDuplication';
    const FIELD_CHANGE_ON_DUPLICATE = 'changeOnDuplicate';
    const FIELD_RELATION = 'relation';
    const FIELD_RELATION_TO_PARENT = 'relationToParent';
    const FIELD_TYPE = 'type';
    const FIELD_TYPE_STRING = 'string';
    const FIELD_TYPE_DATETIME = 'datetime';
    const FIELD_TYPE_INT = 'int';
    const FIELD_TYPE_FLOAT = 'float';
    const FIELD_TYPE_BOOL = 'bool';
    const FIELD_BEFORE_SAVE = 'beforeSave';
    const FIELD_BEFORE_DUPLICATE = 'beforeDuplicate';
    const FIELD_ALLOW_NULL = 'allowNull';
    const FIELD_NOT_CHANGE_ON_UPDATE = 'notChangeOnUpdate';
    const FIELD_CURRENT_DATE_TIME = 'currentDateTime';
    const FIELD_UNIQUE = 'unique';

    /**
     * PK fields name
     */
    const PK_FIELD = 'id';

    /**
     * DB object
     *
     * @var Db
     */
    private $_db;

    /**
     * Model fields
     *
     * @var array
     */
    private $_fields = [
        self::PK_FIELD => null
    ];

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
     * @return AbstractBaseModel
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
                        $this->_fields[$field] = '';
                        break;
                    case self::FIELD_TYPE_BOOL:
                        $this->_fields[$field] = false;
                        break;
                    case self::FIELD_TYPE_DATETIME:
                        $this->_fields[$field] = new \DateTime();
                        break;
                    default:
                        $this->_fields[$field] = null;
                        break;
                }

                continue;
            }

            if (array_key_exists(self::FIELD_RELATION, $info)) {
                $relationField = $this->getRelationName($field);
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
     * Gets relation name
     *
     * @param string $fieldName
     *
     * @return string
     */
    protected function getRelationName($fieldName)
    {
        return substr($fieldName, 0, -2) . 'Model';
    }

    /**
     * Gets relation Id field
     *
     * @param string $relationName
     *
     * @return string
     */
    protected function getRelationIdFields($relationName)
    {
        return substr($relationName, 0, -5) . 'Id';
    }

    /**
     * Gets new DB
     *
     * @return Db
     */
    private function _getNewDb()
    {
        $dbObject = clone App::getInstance()->getDb();
        return $dbObject->setTable($this->getTableName());
    }

    /**
     * Gets DB object
     *
     * @return Db
     */
    protected final function getDb()
    {
        if ($this->_db instanceof Db === false) {
            $this->setDb($this->_getNewDb());
        }

        return $this->_db;
    }

    /**
     * Sets Db
     *
     * @param Db $dbObject DB object
     *
     * @return AbstractBaseModel
     */
    protected final function setDb(Db $dbObject)
    {
        $this->_db = $dbObject;

        return $this;
    }

    /**
     * Clears ID
     *
     * @return AbstractBaseModel
     */
    public function clearId()
    {
        $this->_fields[self::PK_FIELD] = 0;
        return $this;
    }

    /**
     * Gets ID
     *
     * @return int
     */
    public function getId()
    {
        return (int)$this->_fields[self::PK_FIELD];
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

    protected function setField($key, $value)
    {
        $this->_fields[$key] = $value;
        return $this;
    }

    protected function getField($key)
    {
        if (array_key_exists($key, $this->_fields)) {
            return $this->_fields[$key];
        }

        return null;
    }

    protected function getFields()
    {
        return $this->_fields;
    }
}