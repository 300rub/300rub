<?php

namespace ss\models\blocks\helpers\tab\_base;

use ss\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "designTabs"
 */
abstract class AbstractDesignTabModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'designTabs';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'containerDesignBlockId' => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'tabDesignBlockId'     => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'tabDesignTextId'      => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\text\\DesignTextModel'
            ],
            'contentDesignBlockId'     => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
        ];
    }
}
