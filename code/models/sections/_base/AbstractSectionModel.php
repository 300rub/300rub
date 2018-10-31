<?php

namespace ss\models\sections\_base;

use ss\application\App;
use ss\application\components\db\Table;
use ss\application\components\valueGenerator\ValueGenerator;
use ss\models\blocks\_abstract\AbstractDesignModel;
use ss\models\sections\SectionModel;

/**
 * Abstract model for working with table "sections"
 */
abstract class AbstractSectionModel extends AbstractDesignModel
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
                self::FIELD_RELATION
                    => '\\ss\\models\\sections\\SeoModel'
            ],
            'designBlockId' => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
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
            'padding'   => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0,
                ]
            ],
            'isMain'        => [
                self::FIELD_TYPE             => self::FIELD_TYPE_BOOL,
                self::FIELD_SKIP_DUPLICATION => true,
                self::FIELD_BEFORE_SAVE      => ['generateIsMain']
            ],
            'isPublished'   => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
        ];
    }

    /**
     * Generates isMain
     *
     * @param bool $value Is main value
     *
     * @return bool
     */
    protected function generateIsMain($value)
    {
        if ($value !== true) {
            return false;
        }

        SectionModel::model()->updateMany(
            ['isMain' => 0],
            'id > 0'
        );

        return true;
    }

    /**
     * Adds isMain = 1 condition to SQL request
     *
     * @param int $language Language ID
     *
     * @return AbstractSectionModel
     */
    public function main($language = null)
    {
        if ($language === null) {
            $language = App::getInstance()->getLanguage()->getActiveId();
        }

        $this->getTable()
            ->addWhere(
                sprintf(
                    '%s.language = :language',
                    Table::DEFAULT_ALIAS
                )
            )
            ->addWhere(
                sprintf(
                    '%s.isPublished = 1',
                    Table::DEFAULT_ALIAS
                )
            )
            ->addParameter('language', $language)
            ->setOrder(
                sprintf(
                    '%s.isMain DESC, %s.id',
                    Table::DEFAULT_ALIAS,
                    Table::DEFAULT_ALIAS
                )
            )
            ->setLimit(1);

        return $this;
    }
}
