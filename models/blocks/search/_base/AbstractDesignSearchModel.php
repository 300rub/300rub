<?php

namespace testS\models\blocks\search\_base;

use testS\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "designSearch"
 */
abstract class AbstractDesignSearchModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'designSearch';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'containerDesignBlockId'      => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\block\\DesignBlockModel'
            ],
            'titleDesignBlockId'          => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\block\\DesignBlockModel'
            ],
            'titleDesignTextId'           => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\text\\DesignTextModel'
            ],
            'descriptionDesignBlockId'    => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\block\\DesignBlockModel'
            ],
            'descriptionDesignTextId'     => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\text\\DesignTextModel'
            ],
            'paginationDesignBlockId'     => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\block\\DesignBlockModel'
            ],
            'paginationItemDesignBlockId' => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\block\\DesignBlockModel'
            ],
            'paginationItemDesignTextId'  => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\text\\DesignTextModel'
            ],
        ];
    }
}
