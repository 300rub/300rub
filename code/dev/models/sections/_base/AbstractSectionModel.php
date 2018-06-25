<?php

namespace ss\models\sections\_base;

use ss\application\App;
use ss\application\components\Db;
use ss\application\components\ValueGenerator;
use ss\models\_abstract\AbstractModel;

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
            'isMain'        => [
                self::FIELD_TYPE             => self::FIELD_TYPE_BOOL,
                self::FIELD_SKIP_DUPLICATION => true,
                self::FIELD_BEFORE_SAVE      => ['generateIsMain']
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

        return $this->main($this->get('language'))->find() === null;
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

        $this->getDb()->addWhere(
            sprintf(
                '%s.isMain = :isMain',
                Db::DEFAULT_ALIAS
            )
        );
        $this->getDb()->addWhere(
            sprintf(
                '%s.language = :language',
                Db::DEFAULT_ALIAS
            )
        );
        $this->getDb()->addParameter('isMain', 1);
        $this->getDb()->addParameter('language', $language);

        return $this;
    }
}
