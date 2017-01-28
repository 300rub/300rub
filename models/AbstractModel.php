<?php

namespace testS\models;

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
}