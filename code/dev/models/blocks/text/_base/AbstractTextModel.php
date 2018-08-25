<?php

namespace ss\models\blocks\text\_base;

use ss\application\App;

use ss\application\components\valueGenerator\ValueGenerator;
use ss\models\blocks\_abstract\AbstractContentModel;
use ss\models\blocks\block\DesignBlockModel;
use ss\models\blocks\text\DesignTextModel;

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
    public function getTypeList()
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
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\text\\DesignTextModel'
            ],
            'designBlockId' => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'type'          => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        $this->getTypeList(),
                        self::TYPE_DIV
                    ]
                ],
            ],
            'hasEditor'     => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
        ];
    }

    /**
     * Gets design text model
     *
     * @return DesignTextModel
     */
    public function getDesignTextModel()
    {
        return $this->get('designTextModel');
    }

    /**
     * Gets design block model
     *
     * @return DesignBlockModel
     */
    public function getDesignBlockModel()
    {
        return $this->get('designBlockModel');
    }
}
