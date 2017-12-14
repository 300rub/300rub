<?php

namespace testS\models\model;

/**
 * Abstract class for working with models
 */
abstract class AbstractModel
{

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
}