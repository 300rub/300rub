<?php

namespace ss\models\blocks\image\_base;

use ss\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "designImageAlbums"
 */
abstract class AbstractDesignImageAlbumModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'designImageAlbums';
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
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'imageDesignBlockId' => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'nameDesignBlockId' => [
                self::FIELD_RELATION
                => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'nameDesignTextId' => [
                self::FIELD_RELATION
                => '\\ss\\models\\blocks\\text\\DesignTextModel'
            ],
        ];
    }
}
