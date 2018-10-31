<?php

namespace ss\models\blocks\record\_base;

use ss\application\components\valueGenerator\ValueGenerator;
use ss\models\blocks\record\_abstract\AbstractDesignModel;

/**
 * Abstract model for working with table "designRecords"
 */
abstract class AbstractDesignRecordModel extends AbstractDesignModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'designRecords';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'shortCardContainerDesignBlockId'      => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'shortCardInstanceDesignBlockId'       => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'shortCardTitleDesignBlockId'          => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'shortCardTitleDesignTextId'           => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\text\\DesignTextModel'
            ],
            'shortCardDateDesignBlockId'            => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'shortCardDateDesignTextId'            => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\text\\DesignTextModel'
            ],
            'shortCardDescriptionDesignBlockId'    => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'shortCardDescriptionDesignTextId'     => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\text\\DesignTextModel'
            ],
            'shortCardPaginationDesignBlockId'     => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'shortCardPaginationItemDesignBlockId' => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'shortCardPaginationItemDesignTextId'  => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\text\\DesignTextModel'
            ],
            'fullCardContainerDesignBlockId'      => [
                self::FIELD_RELATION
                => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'fullCardTitleDesignBlockId'           => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'fullCardTitleDesignTextId'            => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\text\\DesignTextModel'
            ],
            'fullCardDateDesignBlockId'             => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'fullCardDateDesignTextId'             => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\text\\DesignTextModel'
            ],
            'fullCardTextDesignBlockId'             => [
                self::FIELD_RELATION
                => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'shortCardViewType'                    => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        $this->getShortCardViewTypeList(),
                        self::SHORT_CART_VIEW_TYPE_LIST
                    ]
                ],
            ],
        ];
    }
}
