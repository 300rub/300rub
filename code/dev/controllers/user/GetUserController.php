<?php

namespace ss\controllers\user;

use ss\application\App;
use ss\application\components\user\Operation;

use ss\application\components\valueGenerator\ValueGenerator;
use ss\application\exceptions\AccessException;
use ss\application\exceptions\BadRequestException;
use ss\application\exceptions\NotFoundException;
use ss\controllers\_abstract\AbstractController;
use ss\models\_abstract\AbstractModel;
use ss\models\blocks\block\BlockModel;
use ss\models\sections\SectionModel;
use ss\models\user\UserModel;

/**
 * Gets User
 */
class GetUserController extends AbstractController
{

    /**
     * User operations
     *
     * @var array
     */
    private $_userOperations = [];

    /**
     * Title
     *
     * @var string
     */
    private $_title = '';

    /**
     * Name
     *
     * @var string
     */
    private $_name = '';

    /**
     * Login
     *
     * @var string
     */
    private $_login = '';

    /**
     * Email
     *
     * @var string
     */
    private $_email = '';

    /**
     * Type
     *
     * @var integer
     */
    private $_type = 0;

    /**
     * Flag of changing operation
     *
     * @var integer
     */
    private $_canChangeOperations = false;

    /**
     * Button label
     *
     * @var string
     */
    private $_buttonLabel = '';

    /**
     * Runs controller
     *
     * @throws BadRequestException
     *
     * @return array
     */
    public function run()
    {
        $this->checkUser();

        $language = App::getInstance()->getLanguage();

        $userId = 0;
        $blockId = $this->get('id');
        if (empty($blockId) === false) {
            $userId = (int)$this->get('id');
            if ($userId === 0) {
                throw new BadRequestException(
                    'Incorrect request to get user'
                );
            }
        }

        $userModel = new UserModel();

        $passwordValidation = [];
        if ($userId === 0) {
            $passwordValidation = array_merge(
                $userModel->getValidationRulesForField('password'),
                [
                    'minLength' => 3
                ]
            );
        }

        $this->_setValues($userId);

        return [
            'id'         => $userId,
            'title'      => $this->_title,
            'forms' => [
                'name'       => [
                    'label'      => $language->getMessage('common', 'name'),
                    'value'      => $this->_name,
                    'name'       => 'name',
                    'validation' => $userModel->getValidationRulesForField('name'),
                ],
                'login'      => [
                    'label'      => $language->getMessage('user', 'login'),
                    'value'      => $this->_login,
                    'name'       => 'login',
                    'validation' => $userModel->getValidationRulesForField('login'),
                ],
                'password'      => [
                    'label'      => $language->getMessage('user', 'password'),
                    'name'       => 'password',
                    'validation' => $passwordValidation,
                ],
                'passwordConfirm'      => [
                    'label'
                        => $language->getMessage('user', 'passwordConfirm'),
                    'name'       => 'passwordConfirm',
                    'validation' => $passwordValidation,
                ],
                'email'      => [
                    'label'      => $language->getMessage('common', 'email'),
                    'value'      => $this->_email,
                    'name'       => 'email',
                    'validation' => $userModel->getValidationRulesForField('email'),
                ],
                'type'       => [
                    'label' => $language->getMessage('user', 'type'),
                    'value' => $this->_type,
                    'name'  => 'type',
                    'list'  => App::getInstance()->getValueGenerator()->getValue(
                        ValueGenerator::ORDERED_ARRAY,
                        $userModel->getTypeList(true)
                    )
                ],
            ],
            'operations' => [
                'canChange' => $this->_canChangeOperations,
                'list'      => $this->_getOperations($this->_userOperations),
                'limitedId' => UserModel::TYPE_LIMITED,
            ],
            'labels' => [
                'button' => $this->_buttonLabel,
                'operations'
                    => $language->getMessage('user', 'operations'),
                'isChangePassword'
                    => $language->getMessage('user', 'isChangePassword'),
            ]
        ];
    }

    /**
     * Sets values
     *
     * @param integer $userId User ID
     *
     * @return GetUserController
     *
     * @throws AccessException
     * @throws NotFoundException
     */
    private function _setValues($userId)
    {
        $this->_userOperations = [];
        $this->_name = '';
        $this->_login = '';
        $this->_email = '';
        $this->_type = 0;

        $language = App::getInstance()->getLanguage();

        if ($userId === 0) {
            $this->checkSettingsOperation(Operation::SETTINGS_USER_ADD);
            $this->_title = $language->getMessage('user', 'addUser');
            $this->_buttonLabel = $language->getMessage('common', 'add');
            $this->_canChangeOperations = $this->isFullAccess();

            return $this;
        }

        $user = App::getInstance()->getUser();

        $this->_canChangeOperations = false;
        $this->_title = $language->getMessage('user', 'editUser');
        $this->_buttonLabel = $language->getMessage('common', 'update');

        if ($user->getId() === $userId) {
            $this->_name = $user->getName();
            $this->_login = $user->getLogin();
            $this->_email = $user->getEmail();
            $this->_type = $user->getType();
            $this->_userOperations = [];

            return $this;
        }

        $this->checkSettingsOperation(Operation::SETTINGS_USER_UPDATE);

        $userModel = $this->_getUserById($userId);

        if ($userModel === null) {
            throw new NotFoundException(
                'Unable to find user with ID: {id}',
                [
                    'id' => $userId
                ]
            );
        }

        if ($userModel->isOwner() === true) {
            throw new AccessException(
                'Unable to get owner'
            );
        }

        $this->_name = $userModel->get('name');
        $this->_login = $userModel->get('login');
        $this->_email = $userModel->get('email');
        $this->_type = $userModel->get('type');
        $this->_userOperations = $userModel->getOperations();
        if ($this->isFullAccess() === true
            && $userModel->isOwner() === false
        ) {
            $this->_canChangeOperations = true;
        }

        return $this;
    }

    /**
     * Gets operations
     *
     * @param array $userOperations User operations
     *
     * @return array
     */
    private function _getOperations($userOperations)
    {
        $operations = [];

        $operations[Operation::TYPE_SECTIONS]
            = $this->_getSectionOperations($userOperations);
        $operations[Operation::TYPE_BLOCKS]
            = $this->_getBlockOperations($userOperations);
        $operations[Operation::TYPE_SETTINGS]
            = $this->_getSettingsOperations($userOperations);

        return $operations;
    }

    /**
     * Gets user by ID
     *
     * @param integer $userId User ID
     *
     * @return null|AbstractModel|UserModel
     */
    private function _getUserById($userId)
    {
        $userModel = new UserModel();
        $userModel->byId($userId);
        return $userModel->find();
    }

    /**
     * Gets section operations
     *
     * @param array $userOperations Operations
     *
     * @return array
     */
    private function _getSectionOperations($userOperations)
    {
        $language = App::getInstance()->getLanguage();

        $operations = [
            'title' => $language->getMessage('section', 'sections'),
            'data'  => []
        ];
        $operations['data'][Operation::ALL] = [
            'title' => $language->getMessage('operation', 'all'),
            'data'  => $this->_getAllSectionOperations($userOperations)
        ];

        $sections = new SectionModel();
        $sections->withRelations(['seoModel'])->ordered('name', 'seoModel');
        $sections = $sections->findAll();
        if (count($sections) > 0) {
            foreach ($sections as $section) {
                $sectionId = $section->getId();

                $operations['data'][$sectionId] = [
                    'title' => $section->get('seoModel')->get('name'),
                    'data'  => $this->_getSectionIdOperations(
                        $userOperations,
                        $sectionId
                    )
                ];
            }
        }

        return $operations;
    }

    /**
     * Gets all section operations
     *
     * @param array $userOperations Operations
     *
     * @return array
     */
    private function _getAllSectionOperations($userOperations)
    {
        $operations = [];

        $operationList = App::getInstance()
            ->getOperation()
            ->getSectionOperations(true);
        asort($operationList);

        $type = Operation::TYPE_SECTIONS;

        foreach ($operationList as $key => $label) {
            $value = false;
            $hasSections = array_key_exists(
                $type,
                $userOperations
            );
            if ($hasSections === true) {
                $hasAll = array_key_exists(
                    Operation::ALL,
                    $userOperations[$type]
                );
                if ($hasAll === true) {
                    $value = in_array(
                        $key,
                        $userOperations[$type][Operation::ALL]
                    );
                }
            }

            $operations[] = [
                'label' => $label,
                'name'  => sprintf(
                    'operations.%s.%s.%s',
                    $type,
                    Operation::ALL,
                    $key
                ),
                'value' => $value
            ];
        }

        return $operations;
    }

    /**
     * Get operation for section by ID
     *
     * @param array   $userOperations Operations
     * @param integer $sectionId      Section ID
     *
     * @return array
     */
    private function _getSectionIdOperations($userOperations, $sectionId)
    {
        $operations = [];

        $operationList = App::getInstance()
            ->getOperation()
            ->getSectionOperations(false);
        asort($operationList);

        foreach ($operationList as $key => $label) {
            $value = false;
            $hasSections = array_key_exists(
                Operation::TYPE_SECTIONS,
                $userOperations
            );
            if ($hasSections === true) {
                $hasSectionId = array_key_exists(
                    $sectionId,
                    $userOperations[Operation::TYPE_SECTIONS]
                );
                if ($hasSectionId === true) {
                    $value = in_array(
                        $key,
                        $userOperations[Operation::TYPE_SECTIONS][$sectionId]
                    );
                }
            }

            $operations[] = [
                'label' => $label,
                'name'  => sprintf(
                    'operations.%s.%s.%s',
                    Operation::TYPE_SECTIONS,
                    $sectionId,
                    $key
                ),
                'value' => $value
            ];
        }

        return $operations;
    }

    /**
     * Gets block operations
     *
     * @param array $userOperations Operation
     *
     * @return array
     */
    private function _getBlockOperations($userOperations)
    {
        $language = App::getInstance()->getLanguage();

        $operations = [
            'title' => $language->getMessage('block', 'blocks'),
            'data'  => []
        ];

        $blockModel = new BlockModel();
        foreach ($blockModel->getTypeNames() as $blockKey => $title) {
            $operations['data'][$blockKey] = [
                'title' => $title,
                'data'  => []
            ];

            $operations['data'][$blockKey]['data'][Operation::ALL] = [
                'title' => $language->getMessage('operation', 'all'),
                'data'  => $this->_getAllBlockOperations(
                    $userOperations,
                    $blockKey
                )
            ];

            $blocks = BlockModel::model()
                ->byContentType($blockKey)
                ->ordered()
                ->findAll();
            if (count($blocks) > 0) {
                switch ($blockKey) {
                    case BlockModel::TYPE_TEXT:
                        $operationList = App::getInstance()->getOperation()
                            ->getBlockTextOperations(false);
                        break;
                    case BlockModel::TYPE_IMAGE:
                        $operationList = App::getInstance()->getOperation()
                            ->getBlockImageOperations(false);
                        break;
                    default:
                        $operationList = [];
                        break;
                }

                asort($operationList);

                foreach ($blocks as $block) {
                    $blockId = $block->getId();

                    $operations['data'][$blockKey]['data'][$blockId] = [
                        'title' => $block->get('name'),
                        'data'  => $this->_getBlockIdOperations(
                            $operationList,
                            $userOperations,
                            $blockKey,
                            $blockId
                        )
                    ];
                }
            }
        }

        return $operations;
    }

    /**
     * Gets all block operations
     *
     * @param array   $userOperations User operations
     * @param integer $blockKey       Block key
     *
     * @return array
     */
    private function _getAllBlockOperations($userOperations, $blockKey)
    {
        $operations = [];

        switch ($blockKey) {
            case BlockModel::TYPE_TEXT:
                $operationList = App::getInstance()->getOperation()
                    ->getBlockTextOperations(true);
                break;
            case BlockModel::TYPE_IMAGE:
                $operationList = App::getInstance()->getOperation()
                    ->getBlockImageOperations(true);
                break;
            default:
                $operationList = [];
                break;
        }

        asort($operationList);

        $type = Operation::TYPE_BLOCKS;

        foreach ($operationList as $key => $label) {
            $value = false;
            $hasBlocks = array_key_exists(
                $type,
                $userOperations
            );
            if ($hasBlocks === true) {
                $hasType = array_key_exists(
                    $blockKey,
                    $userOperations[$type]
                );
                if ($hasType === true) {
                    $hasAll = array_key_exists(
                        Operation::ALL,
                        $userOperations[$type][$blockKey]
                    );
                    if ($hasAll === true) {
                        $value = in_array(
                            $key,
                            $userOperations[$type][$blockKey][Operation::ALL]
                        );
                    }
                }
            }

            $operations[] = [
                'label' => $label,
                'name'  => sprintf(
                    'operations.%s.%s.%s.%s',
                    $type,
                    $blockKey,
                    Operation::ALL,
                    $key
                ),
                'value' => $value
            ];
        }

        return $operations;
    }

    /**
     * Gets operations by block ID
     *
     * @param array   $operationList  Operation list
     * @param array   $userOperations User operations
     * @param integer $blockKey       Block key
     * @param integer $blockId        Block ID
     *
     * @return array
     */
    private function _getBlockIdOperations(
        $operationList,
        $userOperations,
        $blockKey,
        $blockId
    ) {
        $operations = [];

        $type = Operation::TYPE_BLOCKS;

        foreach ($operationList as $key => $label) {
            $value = false;
            $hasBlocks = array_key_exists(
                $type,
                $userOperations
            );
            if ($hasBlocks === true) {
                $hasType = array_key_exists(
                    $blockKey,
                    $userOperations[$type]
                );
                if ($hasType === true) {
                    $hasId = array_key_exists(
                        $blockId,
                        $userOperations[$type][$blockKey]
                    );
                    if ($hasId === true) {
                        $value = in_array(
                            $key,
                            $userOperations[$type][$blockKey][$blockId]
                        );
                    }
                }
            }

            $operations[] = [
                'label' => $label,
                'name'  => sprintf(
                    'operations.%s.%s.%s.%s',
                    $type,
                    $blockKey,
                    $blockId,
                    $key
                ),
                'value' => $value
            ];
        }

        return $operations;
    }

    /**
     * Gets settings operations
     *
     * @param array $userOperations Operations
     *
     * @return array
     */
    private function _getSettingsOperations($userOperations)
    {
        $operations = [
            'title' => App::getInstance()
                ->getLanguage()
                ->getMessage('settings', 'settings'),
            'data'  => []
        ];

        $operationList = App::getInstance()
            ->getOperation()
            ->getSettingsOperations();
        asort($operationList);
        foreach ($operationList as $key => $label) {
            $operationValue = false;
            $hasSettings = array_key_exists(
                Operation::TYPE_SETTINGS,
                $userOperations
            );
            if ($hasSettings === true) {
                $operationValue = in_array(
                    $key,
                    $userOperations[Operation::TYPE_SETTINGS]
                );
            }

            $operations['data'][] = [
                'label' => $label,
                'name'  => sprintf(
                    'operations.%s.%s',
                    Operation::TYPE_SETTINGS,
                    $key
                ),
                'value' => $operationValue
            ];
        }

        return $operations;
    }
}
