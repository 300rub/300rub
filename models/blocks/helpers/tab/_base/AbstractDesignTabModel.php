<?php

namespace testS\models\blocks\helpers\tab\_base;

use testS\models\blocks\helpers\tab\_abstract\AbstractTabModel;

/**
 * Abstract model for working with table "designTabs"
 */
abstract class AbstractDesignTabModel extends AbstractTabModel
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
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'tabDesignBlockId'     => [
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'tabDesignTextId'      => [
                self::FIELD_RELATION => 'DesignTextModel'
            ],
            'contentDesignBlockId'     => [
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
        ];
    }
}
