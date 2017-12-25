<?php

namespace testS\models\blocks\text\_abstract;

use testS\application\App;
use testS\application\components\ValueGenerator;
use testS\models\blocks\_abstract\AbstractContentModel;

/**
 * Abstract model for working with table "texts"
 */
abstract class AbstractTextModel extends AbstractContentModel
{

    /**
     * Types
     */
    const TYPE_DIV = 0;
    const TYPE_H1 = 1;
    const TYPE_H2 = 2;
    const TYPE_H3 = 3;

    /**
     * Gets type list
     *
     * @return array
     */
    public static function getTypeList()
    {
        $language = App::getInstance()->getLanguage();

        return [
            self::TYPE_DIV => $language->getMessage('text', 'typeDefault'),
            self::TYPE_H1  => $language->getMessage('text', 'typeH1'),
            self::TYPE_H2  => $language->getMessage('text', 'typeH2'),
            self::TYPE_H3  => $language->getMessage('text', 'typeH3'),
        ];
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'texts';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'designTextId'  => [
                self::FIELD_RELATION => 'DesignTextModel'
            ],
            'designBlockId' => [
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'type'          => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::getTypeList(),
                        self::TYPE_DIV
                    ]
                ],
            ],
            'hasEditor'     => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
        ];
    }
}