<?php

namespace testS\models\user;

use testS\application\App;
use testS\application\components\Db;
use testS\application\components\Operation;
use testS\models\blocks\block\BlockModel;
use testS\models\user\_abstract\AbstractUserModel;

/**
 * Model for working with table "users"
 */
class UserModel extends AbstractUserModel
{

    /**
     * Password salt
     */
    const PASSWORD_SALT = '(^_^)';

    /**
     * Length of password
     */
    const PASSWORD_HASH_LENGTH = 40;

    /**
     * Remember or not
     *
     * @var boolean
     */
    public $isRemember = false;

    /**
     * Gets type as string
     *
     * @param int $type Type value
     *
     * @return string
     */
    public function getType($type = null)
    {
        if ($type === null) {
            $type = $this->get('type');
        }

        $typeList = $this->getTypeList(false);
        if (array_key_exists($type, $typeList) === false) {
            return null;
        }

        return $typeList[$type];
    }

    /**
     * Adds login condition to SQL request
     *
     * @param string $login Login
     *
     * @return UserModel
     */
    public function byLogin($login)
    {
        $this->getDb()->addWhere(
            sprintf(
                '%s.login = :login',
                Db::DEFAULT_ALIAS
            )
        );
        $this->getDb()->addParameter('login', $login);

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
        $sectionGroup = new UserSectionGroupOperationModel();
        $sectionGroupOperations = $sectionGroup->byUserId($this->getId())->findAll();
        if (count($sectionGroupOperations) > 0) {
            $operations[Operation::TYPE_SECTIONS][Operation::ALL] = [];
            foreach ($sectionGroupOperations as $sectionGroupOperation) {
                $operations[Operation::TYPE_SECTIONS][Operation::ALL][] = $sectionGroupOperation->get('operation');
            }
        }

        // Sections
        $sectionOperations = (new UserSectionOperationModel())->byUserId($this->getId())->findAll();
        foreach ($sectionOperations as $sectionOperation) {
            $operations[Operation::TYPE_SECTIONS][$sectionOperation->get('sectionId')][] = $sectionOperation->get('operation');
        }

        // All blocks
        $blockGroupOperations = (new UserBlockGroupOperationModel())->byUserId($this->getId())->findAll();
        foreach ($blockGroupOperations as $blockGroupOperation) {
            $blockType = $blockGroupOperation->get('blockType');
            if (!array_key_exists($blockType, $operations[Operation::TYPE_BLOCKS])) {
                $operations[Operation::TYPE_BLOCKS][$blockType] = [];
            }

            if (!array_key_exists(Operation::ALL, $operations[Operation::TYPE_BLOCKS][$blockType])) {
                $operations[Operation::TYPE_BLOCKS][$blockType][Operation::ALL] = [];
            }

            $operations[Operation::TYPE_BLOCKS][$blockType][Operation::ALL][] = $blockGroupOperation->get('operation');
        }

        // Blocks
        $blockOperations = (new UserBlockOperationModel())->byUserId($this->getId())->findAll();
        foreach ($blockOperations as $blockOperation) {
            $blockType = $blockOperation->get('blockType');
            if (!array_key_exists($blockType, $operations[Operation::TYPE_BLOCKS])) {
                $operations[Operation::TYPE_BLOCKS][$blockType] = [];
            }

            if (!array_key_exists($blockOperation->get('blockId'), $operations[Operation::TYPE_BLOCKS][$blockType])) {
                $operations[Operation::TYPE_BLOCKS][$blockType][$blockOperation->get('blockId')] = [];
            }

            $operations[Operation::TYPE_BLOCKS][$blockType][$blockOperation->get('blockId')][] = $blockOperation->get('operation');
        }

        // Settings
        $settingsOperations = (new UserSettingsOperationModel())->byUserId($this->getId())->findAll();
        foreach ($settingsOperations as $settingsOperation) {
            $operations[Operation::TYPE_SETTINGS][] = $settingsOperation->get('operation');
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

        $operation = App::getInstance()->getOperation();

        foreach ($operations[Operation::TYPE_SECTIONS] as $key => $values) {
            if ($key === Operation::ALL
                && is_array($operations[Operation::TYPE_SECTIONS][$key])
            ) {
                $sectionOperations = $operations[Operation::TYPE_SECTIONS][$key];
                foreach ($sectionOperations as $operationKey => $operationValue) {
                    $hasOperation = array_key_exists(
                        $operationKey,
                        $operation->getSectionOperations(true)
                    );
                    if ($hasOperation === true
                        && $operationValue === true
                    ) {
                        $model = new UserSectionGroupOperationModel();
                        $model->set(
                            [
                                'userId'    => $this->getId(),
                                'operation' => $operationKey
                            ]
                        );
                        $model->save();
                    }
                }

                continue;
            }

            if ($key !== Operation::ALL
                && is_array($operations[Operation::TYPE_SECTIONS][$key]) === true
            ) {
                foreach ($operations[Operation::TYPE_SECTIONS][$key] as $operationKey => $operationValue) {
                    $hasOperation = array_key_exists(
                        $operationKey,
                        $operation->getSectionOperations(false)
                    );
                    if ($hasOperation === true
                        && $operationValue === true
                    ) {
                        $model = new UserSectionOperationModel();
                        $model->set(
                            [
                                'userId'    => $this->getId(),
                                'sectionId' => $key,
                                'operation' => $operationKey
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
     * @param array $operations Operations
     *
     * @return UserModel
     */
    private function _addBlockOperations(array $operations)
    {
        if (array_key_exists(Operation::TYPE_BLOCKS, $operations) === false
            || is_array($operations[Operation::TYPE_BLOCKS]) === false
        ) {
            return $this;
        }

        $blockOperations = $operations[Operation::TYPE_BLOCKS];
        foreach ($blockOperations as $blockType => $blockTypeValues) {
            if (array_key_exists($blockType, BlockModel::$typeList) === false
                || is_array($blockTypeValues) === false
            ) {
                continue;
            }

            $operation = App::getInstance()->getOperation();
            $blockAllOperations
                = $operation->getOperationsByContentType($blockType, true);
            $blockOperations
                = $operation->getOperationsByContentType($blockType, false);

            foreach (array_keys($blockTypeValues) as $key) {
                if ($key === Operation::ALL
                    && is_array($blockTypeValues[$key]) === true
                ) {
                    foreach ($blockTypeValues[$key] as $operationKey => $operationValue) {
                        $hasKey = array_key_exists(
                            $operationKey,
                            $blockAllOperations
                        );
                        if ($hasKey === true
                            && $operationValue === true
                        ) {
                            $model = new UserBlockGroupOperationModel();
                            $model->set(
                                [
                                    'userId'    => $this->getId(),
                                    'blockType' => $blockType,
                                    'operation' => $operationKey
                                ]
                            );
                            $model->save();
                        }
                    }

                    continue;
                }

                if ($key !== Operation::ALL
                    && is_array($blockTypeValues[$key]) === true
                ) {
                    foreach ($blockTypeValues[$key] as $operationKey => $operationValue) {
                        $hasKey = array_key_exists(
                            $operationKey,
                            $blockOperations
                        );
                        if ($hasKey === true
                            && $operationValue === true
                        ) {
                            $model = new UserBlockOperationModel();
                            $model->set(
                                [
                                    'userId'    => $this->getId(),
                                    'blockType' => $blockType,
                                    'blockId'   => $key,
                                    'operation' => $operationKey
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
     * @param array $operations Operations
     *
     * @return UserModel
     */
    private function _addSettingsOperations(array $operations)
    {
        if (array_key_exists(Operation::TYPE_SETTINGS, $operations) === false
            || is_array($operations[Operation::TYPE_SETTINGS]) === false
        ) {
            return $this;
        }

        $settingsOperations = $operations[Operation::TYPE_SETTINGS];
        foreach ($settingsOperations as $operationKey => $operationValue) {
            $hasOperation = array_key_exists(
                $operationKey,
                App::getInstance()->getOperation()->getSettingsOperations()
            );
            if ($hasOperation === true
                && $operationValue === true
            ) {
                $model = new UserSettingsOperationModel();
                $model->set(
                    [
                        'userId'    => $this->getId(),
                        'operation' => $operationKey
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
     * @param array $operations Operations
     *
     * @return UserModel
     */
    public function updateOperations(array $operations)
    {
        $this
            ->_deleteOperations()
            ->addOperations($operations);

        $sessionModels = new UserSessionModel();
        $sessionModels->byUserId($this->getId());
        $sessionModels = $sessionModels->findAll();
        foreach ($sessionModels as $sessionModel) {
            App::web()->getMemcached()->delete(
                $sessionModel->get('token')
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
        $blockGroup = new UserBlockGroupOperationModel();
        $blockGroup->delete(
            'userId = :userId',
            [
                'userId' => $this->getId()
            ]
        );

        $blockOperation = new UserBlockOperationModel();
        $blockOperation->delete(
            'userId = :userId',
            [
                'userId' => $this->getId()
            ]
        );

        $sectionGroup = new UserSectionGroupOperationModel();
        $sectionGroup->delete(
            'userId = :userId',
            [
                'userId' => $this->getId()
            ]
        );

        $sectionOperation = new UserSectionOperationModel();
        $sectionOperation->delete(
            'userId = :userId',
            [
                'userId' => $this->getId()
            ]
        );

        $settingsOperation = new UserSettingsOperationModel();
        $settingsOperation->delete(
            'userId = :userId',
            [
                'userId' => $this->getId()
            ]
        );

        return $this;
    }

    /**
     * Is owner
     *
     * @return bool
     */
    public function isOwner()
    {
        return $this->get('type') === self::TYPE_OWNER;
    }

    /**
     * Gets password hash
     *
     * @param string $password   Password hash
     * @param bool   $isOriginal Flag of original password
     *
     * @return string
     */
    public static function getPasswordHash($password, $isOriginal)
    {
        if ($isOriginal === true) {
            return sha1(md5($password . self::PASSWORD_SALT));
        }

        return sha1($password);
    }
}
