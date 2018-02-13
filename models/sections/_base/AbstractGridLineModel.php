<?php

namespace ss\models\sections\_base;

use ss\models\_abstract\AbstractModel;

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
        return 'gridLines';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'sectionId'       => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\ss\\models\\sections\\SectionModel',
            ],
            'outsideDesignId' => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'insideDesignId'  => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'sort'            => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
        ];
    }
}
