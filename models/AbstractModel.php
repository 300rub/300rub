<?php

namespace testS\models;

use testS\components\Db;
use testS\components\Language;

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
    private $_errors;

    /**
     * Gets table name
     *
     * @return string
     */
    abstract public function getTableName();

    /**
     * Gets fields
     *
     * @return array
     */
    abstract protected function getFields();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->getDb()->setTable($this->getTableName());
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
        $this->getDb()->addWhere("t.id = :id");
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
        $this->getDb()->addWhere("t.id != :id");
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
}