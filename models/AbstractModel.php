<?php

namespace testS\models;

use testS\components\Db;
use testS\components\exceptions\DbException;
use testS\components\exceptions\ModelException;
use testS\components\Language;
use testS\components\Validator;
use \Exception;

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
     * DB object
     *
     * @var Db
     */
    protected $db;


    const FIELD_VALIDATION = "validation";
    const FIELD_BEFORE_VALIDATION = "beforeValidation";
    const FIELD_SKIP_DUPLICATION = "skipDuplication";
    const FIELD_CHANGE_ON_DUPLICATE = "changeOnDuplicate";

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
}