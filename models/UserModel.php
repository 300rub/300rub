<?php

namespace testS\models;

use testS\components\Db;
use testS\components\Operation;
use testS\components\Validator;

/**
 * Model for working with table "users"
 *
 * @package testS\models
 *
 * @method UserModel byId($id)
 * @method UserModel find()
 */
class UserModel extends AbstractModel
{

    /**
     * Password salt
     */
    const PASSWORD_SALT = "(^_^)";

    /**
     * Length of password
     */
    const PASSWORD_HASH_LENGTH = 40;

    /**
     * Remember or not
     *
     * @var bool
     */
    public $isRemember = false;

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "users";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "login"    => [
                self::FIELD_TYPE             => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION       => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MIN_LENGTH => 3,
                    Validator::TYPE_MAX_LENGTH => 50,
                    Validator::TYPE_LATIN_DIGIT_UNDERSCORE_HYPHEN
                ],
                self::FIELD_BEFORE_SAVE      => ["setLogin"],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "password" => [
                self::FIELD_TYPE             => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION       => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MIN_LENGTH => 40,
                    Validator::TYPE_MAX_LENGTH => 40,
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "isOwner"  => [
                self::FIELD_TYPE                 => self::FIELD_TYPE_BOOL,
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
                self::FIELD_BEFORE_SAVE          => ["setIsOwner"],
            ],
            "name"     => [
                self::FIELD_TYPE             => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION       => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 100,
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            "email"    => [
                self::FIELD_TYPE             => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION       => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_EMAIL,
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
        ];
    }

    /**
     * Sets is owner
     *
     * @param bool $value
     *
     * @return bool
     */
    protected function setIsOwner($value)
    {
        if ($value === true) {
            return $this->owner()->find() === null;
        }

        return false;
    }

    /**
     * Sets login
     *
     * @param bool $value
     *
     * @return bool
     */
    protected function setLogin($value)
    {
        if (!$this->isNew()) {
            return $value;
        }

        $model = $this->byLogin($value)->find();
        if ($model !== null) {
            $this->addErrors("login", [Validator::TYPE_UNIQUE]);
        }

        return $value;
    }

    /**
     * Adds login condition to SQL request
     *
     * @param string $login
     *
     * @return UserModel
     */
    public function byLogin($login)
    {
        $this->getDb()->addWhere(sprintf("%s.login = :login", Db::DEFAULT_ALIAS));
        $this->getDb()->addParameter("login", $login);

        return $this;
    }

    /**
     * Adds owner condition to SQL request
     *
     * @return UserModel
     */
    public function owner()
    {
        $this->getDb()->addWhere(sprintf("%s.isOwner = :isOwner", Db::DEFAULT_ALIAS));
        $this->getDb()->addParameter("isOwner", 1);

        return $this;
    }

    /**
     * Gets operations by user ID
     *
     * @return array
     */
    public function getOperations()
    {
        if ($this->getId() === 0) {
            return [];
        }

        $operations = [
            Operation::TYPE_BLOCKS   => [],
            Operation::TYPE_SECTIONS => [],
            Operation::TYPE_SETTINGS => [],
        ];

        // All sections
        $sectionGroupOperations = (new UserSectionGroupOperationModel())->byUserId($this->getId())->findAll();
        if (count($sectionGroupOperations) > 0) {
            $operations[Operation::TYPE_SECTIONS][Operation::ALL] = [];
            foreach ($sectionGroupOperations as $sectionGroupOperation) {
                $operations[Operation::TYPE_SECTIONS][Operation::ALL][] = $sectionGroupOperation->get("operation");
            }
        }

        // Sections
        $sectionOperations = (new UserSectionOperationModel())->byUserId($this->getId())->findAll();
        foreach ($sectionOperations as $sectionOperation) {
            $operations[Operation::TYPE_SECTIONS][$sectionOperation->get("sectionId")][] =
                $sectionOperation->get("operation");
        }

        // All blocks
        $blockGroupOperations = (new UserBlockGroupOperationModel())->byUserId($this->getId())->findAll();
        foreach ($blockGroupOperations as $blockGroupOperation) {
            $blockType = $blockGroupOperation->get("blockType");
            if (!array_key_exists($blockType, $operations[Operation::TYPE_BLOCKS])) {
                $operations[Operation::TYPE_BLOCKS][$blockType] = [];
            }
            if (!array_key_exists(Operation::ALL, $operations[Operation::TYPE_BLOCKS][$blockType])) {
                $operations[Operation::TYPE_BLOCKS][$blockType][Operation::ALL] = [];
            }
            $operations[Operation::TYPE_BLOCKS][$blockType][Operation::ALL][] = $blockGroupOperation->get("operation");
        }

        // Blocks
        $blockOperations = (new UserBlockOperationModel())->byUserId($this->getId())->findAll();
        foreach ($blockOperations as $blockOperation) {
            $blockType = $blockOperation->get("blockType");
            if (!array_key_exists($blockType, $operations[Operation::TYPE_BLOCKS])) {
                $operations[Operation::TYPE_BLOCKS][$blockType] = [];
            }
            if (!array_key_exists($blockOperation->get("blockId"), $operations[Operation::TYPE_BLOCKS][$blockType])) {
                $operations[Operation::TYPE_BLOCKS][$blockType][$blockOperation->get("blockId")] = [];
            }
            $operations[Operation::TYPE_BLOCKS][$blockType][$blockOperation->get("blockId")][] =
                $blockOperation->get("operation");
        }

        // Settings
        $settingsOperations = (new UserSettingsOperationModel())->byUserId($this->getId())->findAll();
        foreach ($settingsOperations as $settingsOperation) {
            $operations[Operation::TYPE_SETTINGS][] = $settingsOperation->get("operation");
        }

        if (count($operations[Operation::TYPE_BLOCKS]) === 0) {
            unset($operations[Operation::TYPE_BLOCKS]);
        }
        if (count($operations[Operation::TYPE_SECTIONS]) === 0) {
            unset($operations[Operation::TYPE_SECTIONS]);
        }
        if (count($operations[Operation::TYPE_SETTINGS]) === 0) {
            unset($operations[Operation::TYPE_SETTINGS]);
        }

        return $operations;
    }
}