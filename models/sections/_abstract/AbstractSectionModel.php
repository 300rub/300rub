<?php

namespace testS\models\sections\_abstract;

use testS\application\App;
use testS\application\components\ValueGenerator;
use testS\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "sections"
 */
abstract class AbstractSectionModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'sections';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        $language = App::getInstance()->getLanguage();

        return [
            'seoId'         => [
                self::FIELD_RELATION => 'SeoModel'
            ],
            'designBlockId' => [
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'language'      => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        $language->getAliasList(),
                        $language->getActiveId()
                    ]
                ],
            ],
            'isMain'        => [
                self::FIELD_TYPE             => self::FIELD_TYPE_BOOL,
                self::FIELD_SKIP_DUPLICATION => true,
                self::FIELD_BEFORE_SAVE      => ['generateIsMain']
            ],
        ];
    }
}
