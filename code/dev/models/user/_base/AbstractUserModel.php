<?php

namespace ss\models\user\_base;

use ss\application\App;
use ss\application\components\Db;
use ss\application\components\Validator;

use ss\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "users"
 */
abstract class AbstractUserModel extends AbstractModel
{

    /**
     * Types
     */
    const TYPE_BLOCKED = 0;
    const TYPE_OWNER = 1;
    const TYPE_FULL = 2;
    const TYPE_LIMITED = 3;

    /**
     * Gets type list
     *
     * @param bool $exceptOwner Flag to except owner
     *
     * @return array
     */
    public function getTypeList($exceptOwner)
    {
        $language = App::getInstance()->getLanguage();

        $list = [
            self::TYPE_FULL
                => $language->getMessage('user', 'typeFull'),
            self::TYPE_LIMITED
                => $language->getMessage('user', 'typeLimited'),
            self::TYPE_BLOCKED
                => $language->getMessage('user', 'typeBlocked'),
        ];

        if ($exceptOwner === false) {
            $list[self::TYPE_OWNER]
                = $language->getMessage('user', 'typeOwner');
        }

        return $list;
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'users';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'login'    => [
                self::FIELD_TYPE             => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION       => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MIN_LENGTH => 3,
                    Validator::TYPE_MAX_LENGTH => 50,
                    Validator::TYPE_LATIN_DIGIT_UNDERSCORE_HYPHEN
                ],
                self::FIELD_SKIP_DUPLICATION => true,
                self::FIELD_UNIQUE           => true
            ],
            'password' => [
                self::FIELD_TYPE             => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION       => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MIN_LENGTH => 40,
                    Validator::TYPE_MAX_LENGTH => 40,
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'type'     => [
                self::FIELD_TYPE        => self::FIELD_TYPE_INT,
                self::FIELD_VALUE       => [
                    ValueGenerator::ARRAY_KEY => [
                        $this->getTypeList(false),
                        self::TYPE_BLOCKED
                    ]
                ],
                self::FIELD_BEFORE_SAVE => ['setType'],
            ],
            'name'     => [
                self::FIELD_TYPE             => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION       => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 100,
                ],
                self::FIELD_SKIP_DUPLICATION => true,
                self::FIELD_VALUE      => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
            ],
            'email'    => [
                self::FIELD_TYPE             => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION       => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_EMAIL,
                ],
                self::FIELD_SKIP_DUPLICATION => true,
                self::FIELD_UNIQUE           => true
            ],
            'code'     => [
                self::FIELD_TYPE             => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION       => [
                    Validator::TYPE_MAX_LENGTH => 25,
                ],
                self::FIELD_SKIP_DUPLICATION => true,
                self::FIELD_VALUE      => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
            ],
        ];
    }

    /**
     * Sets is owner
     *
     * @param int $value Type value
     *
     * @return bool
     */
    protected function setType($value)
    {
        if ($value === self::TYPE_OWNER
            && $this->owner()->exceptId($this->getId())->find() !== null
        ) {
            return self::TYPE_BLOCKED;
        }

        return $value;
    }

    /**
     * Adds owner condition to SQL request
     *
     * @return AbstractUserModel
     */
    public function owner()
    {
        $this->getDb()->addWhere(
            sprintf(
                '%s.type = :type',
                Db::DEFAULT_ALIAS
            )
        );
        $this->getDb()->addParameter('type', self::TYPE_OWNER);

        return $this;
    }
}
