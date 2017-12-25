<?php

namespace testS\models\sections\_abstract;

use testS\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "gridLines"
 */
abstract class AbstractGridLineModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "gridLines";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "sectionId"       => [
                self::FIELD_RELATION_TO_PARENT => "SectionModel",
            ],
            "outsideDesignId" => [
                self::FIELD_RELATION => "DesignBlockModel"
            ],
            "insideDesignId"  => [
                self::FIELD_RELATION => "DesignBlockModel"
            ],
            "sort"            => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
        ];
    }
}