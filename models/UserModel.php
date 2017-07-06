<?php

namespace testS\models;

use testS\applications\App;
use testS\components\Db;
use testS\components\Language;
use testS\components\Operation;
use testS\components\Validator;
use testS\components\ValueGenerator;

/**
 * Model for working with table "users"
 *
 * @package testS\models
 *
 * @method UserModel   byId($id)
 * @method UserModel   find()
 * @method UserModel[] findAll()
 * @method UserModel   exceptId($id)
 * @method UserModel   latest
 */
class UserModel extends AbstractModel
{

    /**
     * Types
     */
    const TYPE_BLOCKED = 0;
    const TYPE_OWNER = 1;
    const TYPE_FULL = 2;
    const TYPE_LIMITED = 3;

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
     * Gets type list
     *
     * @param bool $exceptOwner
     *
     * @return array
     */
    public static function getTypeList($exceptOwner = false)
    {
        $list = [
            self::TYPE_FULL    => Language::t("user", "typeFull"),
            self::TYPE_LIMITED => Language::t("user", "typeLimited"),
            self::TYPE_BLOCKED => Language::t("user", "typeBlocked"),
        ];

        if ($exceptOwner === false) {
            $list[self::TYPE_OWNER] = Language::t("user", "typeOwner");
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
                self::FIELD_SKIP_DUPLICATION => true,
                self::FIELD_UNIQUE           => true
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
            "type"     => [
                self::FIELD_TYPE        => self::FIELD_TYPE_INT,
                self::FIELD_VALUE       => [
                    ValueGenerator::ARRAY_KEY => [self::getTypeList(), self::TYPE_BLOCKED]
                ],
                self::FIELD_BEFORE_SAVE => ["setType"],
            ],
            "name"     => [
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
            "email"    => [
                self::FIELD_TYPE             => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION       => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_EMAIL,
                ],
                self::FIELD_SKIP_DUPLICATION => true,
                self::FIELD_UNIQUE           => true
            ],
        ];
    }

    /**
     * Sets is owner
     *
     * @param int $value
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
     * Gets type as string
     *
     * @param int $type
     *
     * @return string
     */
    public function getType($type = null)
    {
        if ($type === null) {
            $type = $this->get("type");
        }

        $typeList = self::getTypeList();
        if (!array_key_exists($type, $typeList)) {
            return null;
        }

        return $typeList[$type];
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
        $this->getDb()->addWhere(sprintf("%s.type = :type", Db::DEFAULT_ALIAS));
        $this->getDb()->addParameter("type", self::TYPE_OWNER);

        return $this;
    }

    /**
     * Adds order by condition to SQL request
     *
     * @return UserModel
     */
    public function ordered()
    {
        $this->getDb()->setOrder(sprintf("%s.name", Db::DEFAULT_ALIAS));

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

    /**
     * Adds operations
     *
     * @param array $operations
     *
     * @return UserModel
     */
    public function addOperations(array $operations)
    {
        $this
            ->_addSectionOperations($operations)
            ->_addBlockOperations($operations)
            ->_addSettingsOperations($operations);

        return $this;
    }

    /**
     * Adds section operations
     *
     * @param array $operations
     *
     * @return UserModel
     */
    private function _addSectionOperations(array $operations)
    {
        if (!array_key_exists(Operation::TYPE_SECTIONS, $operations)
            || !is_array($operations[Operation::TYPE_SECTIONS])
        ) {
            return $this;
        }

        foreach ($operations[Operation::TYPE_SECTIONS] as $key => $values) {
            if ($key === Operation::ALL
                && is_array($operations[Operation::TYPE_SECTIONS][$key])
            ) {
                foreach ($operations[Operation::TYPE_SECTIONS][$key] as $operation) {
                    if (array_key_exists($operation, Operation::getSectionOperations(true))) {
                        $model = new UserSectionGroupOperationModel();
                        $model->set(
                            [
                                "userId"    => $this->getId(),
                                "operation" => $operation
                            ]
                        );
                        $model->save();
                    }
                }

                continue;
            }

            if ($key !== Operation::ALL
                && is_array($operations[Operation::TYPE_SECTIONS][$key])
            ) {
                foreach ($operations[Operation::TYPE_SECTIONS][$key] as $operation) {
                    if (array_key_exists($operation, Operation::getSectionOperations())) {
                        $model = new UserSectionOperationModel();
                        $model->set(
                            [
                                "userId"    => $this->getId(),
                                "sectionId" => $key,
                                "operation" => $operation
                            ]
                        );
                        $model->save();
                    }
                }
            }
        }

        return $this;
    }

    /**
     * Adds block operations
     *
     * @param array $operations
     *
     * @return UserModel
     */
    private function _addBlockOperations(array $operations) {
        if (!array_key_exists(Operation::TYPE_BLOCKS, $operations)
            || !is_array($operations[Operation::TYPE_BLOCKS])
        ) {
            return $this;
        }

        foreach ($operations[Operation::TYPE_BLOCKS] as $blockType => $blockTypeValues) {
            if (!array_key_exists($blockType, BlockModel::$typeList)
                || !is_array($blockTypeValues)
            ) {
                continue;
            }

            $blockAllOperations = Operation::getOperationsByContentType($blockType, true);
            $blockOperations = Operation::getOperationsByContentType($blockType);


            foreach ($blockTypeValues as $key => $value) {
                if ($key === Operation::ALL
                    && is_array($blockTypeValues[$key])
                ) {
                    foreach ($blockTypeValues[$key] as $operation) {
                        if (array_key_exists($operation, $blockAllOperations)) {
                            $model = new UserBlockGroupOperationModel();
                            $model->set(
                                [
                                    "userId"    => $this->getId(),
                                    "blockType" => $blockType,
                                    "operation" => $operation
                                ]
                            );
                            $model->save();
                        }
                    }

                    continue;
                }

                if ($key !== Operation::ALL
                    && is_array($blockTypeValues[$key])
                ) {
                    foreach ($blockTypeValues[$key] as $operation) {
                        if (array_key_exists($operation, $blockOperations)) {
                            $model = new UserBlockOperationModel();
                            $model->set(
                                [
                                    "userId"    => $this->getId(),
                                    "blockType" => $blockType,
                                    "blockId"   => $key,
                                    "operation" => $operation
                                ]
                            );
                            $model->save();
                        }
                    }
                }
            }
        }

        return $this;
    }

    /**
     * Adds settings operations
     *
     * @param array $operations
     *
     * @return UserModel
     */
    private function _addSettingsOperations(array $operations)
    {
        if (!array_key_exists(Operation::TYPE_SETTINGS, $operations)
            || !is_array($operations[Operation::TYPE_SETTINGS])
        ) {
            return $this;
        }

        foreach ($operations[Operation::TYPE_SETTINGS] as $operation) {
            if (array_key_exists($operation, Operation::getSettingsOperations())) {
                $model = new UserSettingsOperationModel();
                $model->set(
                    [
                        "userId"    => $this->getId(),
                        "operation" => $operation
                    ]
                );
                $model->save();
            }
        }

        return $this;
    }

    /**
     * Updates operations
     *
     * @param array $operations
     *
     * @return UserModel
     */
    public function updateOperations(array $operations)
    {
        $this
            ->_deleteOperations()
            ->addOperations($operations);

        $sessionModels = (new UserSessionModel())->byUserId($this->getId())->findAll();
        foreach ($sessionModels as $sessionModel) {
            App::web()->getMemcached()->delete(
                $sessionModel->get("token")
            );
        }

        return $this;
    }

    /**
     * Deletes operations
     *
     * @return UserModel
     */
    private function _deleteOperations()
    {
        (new UserBlockGroupOperationModel())->delete("userId = :userId", ["userId" => $this->getId()]);
        (new UserBlockOperationModel())->delete("userId = :userId", ["userId" => $this->getId()]);
        (new UserSectionGroupOperationModel())->delete("userId = :userId", ["userId" => $this->getId()]);
        (new UserSectionOperationModel())->delete("userId = :userId", ["userId" => $this->getId()]);
        (new UserSettingsOperationModel())->delete("userId = :userId", ["userId" => $this->getId()]);

        return $this;
    }

    /**
     * Is owner
     *
     * @return bool
     */
    public function isOwner()
    {
        return $this->get("type") === self::TYPE_OWNER;
    }

    /**
     * Gets password hash
     *
     * @param string $password
     * @param bool   $isOriginal
     *
     * @return string
     */
    public static function getPasswordHash($password, $isOriginal = false)
    {
        if ($isOriginal === true) {
            return sha1(md5($password . self::PASSWORD_SALT));
        }

        return sha1($password);
    }
}