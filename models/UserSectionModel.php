<?php

namespace testS\models;

/**
 * Model for working with table "userSections"
 *
 * @package testS\models
 */
class UserSectionModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "userSections";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "userId"   => [
                self::FIELD_RELATION_TO_PARENT => "UserModel"
            ],
            "sectionId"   => [
                self::FIELD_RELATION_TO_PARENT => "SectionModel"
            ],
        ];
    }
}