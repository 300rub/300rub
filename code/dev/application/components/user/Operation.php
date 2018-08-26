<?php

namespace ss\application\components\user;

use ss\application\App;
use ss\models\blocks\block\BlockModel;

/**
 * Class for work with user from session
 */
class Operation
{

    /**
     * Operation types
     */
    const TYPE_SECTIONS = 'SECTIONS';
    const TYPE_BLOCKS = 'BLOCKS';
    const TYPE_SETTINGS = 'SETTINGS';

    /**
     * All
     */
    const ALL = 'ALL';

    /**
     * Section operations
     */
    const SECTION_ADD = 'SECTION_ADD';
    const SECTION_UPDATE = 'SECTION_UPDATE';
    const SECTION_DESIGN_UPDATE = 'SECTION_DESIGN_UPDATE';
    const SECTION_DELETE = 'SECTION_DELETE';
    const SECTION_DUPLICATE = 'SECTION_DUPLICATE';

    /**
     * Settings operations
     */
    const SETTINGS_ICON = 'SETTINGS_ICON';
    const SETTINGS_USER_VIEW = 'SETTINGS_USER_VIEW';
    const SETTINGS_USER_UPDATE = 'SETTINGS_USER_UPDATE';
    const SETTINGS_USER_DELETE = 'SETTINGS_USER_DELETE';
    const SETTINGS_USER_VIEW_SESSIONS = 'SETTINGS_USER_VIEW_SESSIONS';
    const SETTINGS_USER_DELETE_SESSIONS = 'SETTINGS_USER_DELETE_SESSIONS';
    const SETTINGS_USER_ADD = 'SETTINGS_USER_ADD';
    const SETTINGS_USER_CAN_RELEASE = 'SETTINGS_USER_CAN_RELEASE';

    /**
     * Block text operations
     */
    const TEXT_ADD = 'TEXT_ADD';
    const TEXT_UPDATE_SETTINGS = 'TEXT_UPDATE_SETTINGS';
    const TEXT_UPDATE_DESIGN = 'TEXT_UPDATE_DESIGN';
    const TEXT_UPDATE_CONTENT = 'TEXT_UPDATE_CONTENT';
    const TEXT_DELETE = 'TEXT_DELETE';
    const TEXT_DUPLICATE = 'TEXT_DUPLICATE';

    /**
     * Block image operations
     */
    const IMAGE_ADD = 'IMAGE_ADD';
    const IMAGE_UPLOAD = 'IMAGE_UPLOAD';
    const IMAGE_UPDATE = 'IMAGE_UPDATE';
    const IMAGE_DELETE = 'IMAGE_DELETE';
    const IMAGE_DUPLICATE = 'IMAGE_DUPLICATE';
    const IMAGE_UPDATE_SETTINGS = 'IMAGE_UPDATE_SETTINGS';
    const IMAGE_UPDATE_DESIGN = 'IMAGE_UPDATE_DESIGN';
    const IMAGE_UPDATE_CONTENT = 'IMAGE_UPDATE_CONTENT';
    const IMAGE_CREATE_ALBUM = 'IMAGE_CREATE_ALBUM';
    const IMAGE_UPDATE_ALBUM = 'IMAGE_UPDATE_ALBUM';
    const IMAGE_DELETE_ALBUM = 'IMAGE_DELETE_ALBUM';

    /**
     * Block record operations
     */
    const RECORD_ADD = 'RECORD_ADD';
    const RECORD_ADD_CLONE = 'RECORD_ADD_CLONE';
    const RECORD_UPDATE_SETTINGS = 'RECORD_UPDATE_SETTINGS';
    const RECORD_UPDATE_CLONE_SETTINGS = 'RECORD_UPDATE_CLONE_SETTINGS';
    const RECORD_UPDATE_DESIGN = 'RECORD_UPDATE_DESIGN';
    const RECORD_UPDATE_CONTENT = 'RECORD_UPDATE_CONTENT';
    const RECORD_DELETE = 'RECORD_DELETE';
    const RECORD_DELETE_CLONE = 'RECORD_DELETE_CLONE';
    const RECORD_DUPLICATE = 'RECORD_DUPLICATE';
    const RECORD_DUPLICATE_CLONE = 'RECORD_DUPLICATE_CLONE';

    /**
     * Gets section operations
     *
     * @param bool $isAll Is to display all operations
     *
     * @return array
     */
    public function getSectionOperations($isAll)
    {
        $language = App::getInstance()->getLanguage();

        $list = [
            self::SECTION_UPDATE
                => $language->getMessage('operation', 'edit'),
            self::SECTION_DESIGN_UPDATE
                => $language->getMessage('operation', 'editDesign'),
            self::SECTION_DELETE
                => $language->getMessage('operation', 'delete'),
            self::SECTION_DUPLICATE
                => $language->getMessage('operation', 'duplicate'),
        ];

        if ($isAll === true) {
            $list[self::SECTION_ADD]
                = $language->getMessage('operation', 'add');
        }

        return $list;
    }

    /**
     * Gets settings operations
     *
     * @return array
     */
    public function getSettingsOperations()
    {
        $language = App::getInstance()->getLanguage();

        return [
            self::SETTINGS_ICON
                => $language->getMessage(
                    'operation',
                    'settingsChangeIcon'
                ),
            self::SETTINGS_USER_VIEW
                => $language->getMessage(
                    'operation',
                    'settingsViewUsers'
                ),
            self::SETTINGS_USER_UPDATE
                => $language->getMessage(
                    'operation',
                    'settingsEditUsers'
                ),
            self::SETTINGS_USER_DELETE
                => $language->getMessage(
                    'operation',
                    'settingsDeleteUsers'
                ),
            self::SETTINGS_USER_VIEW_SESSIONS
                => $language->getMessage(
                    'operation',
                    'settingsViewUserSessions'
                ),
            self::SETTINGS_USER_DELETE_SESSIONS
                => $language->getMessage(
                    'operation',
                    'settingsDeleteUserSessions'
                ),
            self::SETTINGS_USER_ADD
                => $language->getMessage(
                    'operation',
                    'settingsAddUsers'
                ),
            self::SETTINGS_USER_CAN_RELEASE
                => $language->getMessage(
                    'operation',
                    'settingsCanRelease'
                ),
        ];
    }

    /**
     * Gets block text operations
     *
     * @param bool $isAll Is to display all operations
     *
     * @return array
     */
    public function getBlockTextOperations($isAll)
    {
        $language = App::getInstance()->getLanguage();

        $list = [
            self::TEXT_UPDATE_SETTINGS
                => $language->getMessage('operation', 'editSettings'),
            self::TEXT_UPDATE_DESIGN
                => $language->getMessage('operation', 'editDesign'),
            self::TEXT_UPDATE_CONTENT
                => $language->getMessage('operation', 'edit'),
            self::TEXT_DELETE
                => $language->getMessage('operation', 'delete'),
            self::TEXT_DUPLICATE
                => $language->getMessage('operation', 'duplicate'),
        ];

        if ($isAll === true) {
            $list[self::TEXT_ADD] = $language->getMessage('operation', 'add');
        }

        return $list;
    }

    /**
     * Gets block image operations
     *
     * @param bool $isAll Is to display all operations
     *
     * @return array
     */
    public function getBlockImageOperations($isAll)
    {
        $language = App::getInstance()->getLanguage();

        $list = [
            self::IMAGE_UPLOAD
                => $language->getMessage('operation', 'imageUpload'),
            self::IMAGE_UPDATE
                => $language->getMessage('operation', 'imageUpdate'),
            self::IMAGE_DELETE
                => $language->getMessage('operation', 'imageDelete'),
            self::IMAGE_UPDATE_SETTINGS
                => $language->getMessage('operation', 'editSettings'),
            self::IMAGE_UPDATE_DESIGN
                => $language->getMessage('operation', 'editDesign'),
            self::IMAGE_UPDATE_CONTENT
                => $language->getMessage('operation', 'edit'),
            self::IMAGE_DUPLICATE
                => $language->getMessage('operation', 'duplicate'),
            self::IMAGE_UPDATE_ALBUM
                => $language->getMessage('image', 'updateAlbum'),
            self::IMAGE_CREATE_ALBUM
                => $language->getMessage('image', 'createAlbum'),
            self::IMAGE_DELETE_ALBUM
                => $language->getMessage('image', 'deleteAlbum'),
        ];

        if ($isAll === true) {
            $list[self::IMAGE_ADD] = $language->getMessage('operation', 'add');
        }

        return $list;
    }

    /**
     * Gets block image operations
     *
     * @param bool $isAll Is to display all operations
     *
     * @return array
     */
    public function getBlockRecordOperations($isAll)
    {
        $language = App::getInstance()->getLanguage();

        $list = [
            self::RECORD_UPDATE_SETTINGS
                => $language->getMessage('operation', 'editSettings'),
            self::RECORD_UPDATE_CLONE_SETTINGS
                => $language->getMessage('operation', 'editCloneSettings'),
            self::RECORD_UPDATE_DESIGN
                => $language->getMessage('operation', 'editDesign'),
            self::RECORD_UPDATE_CONTENT
                => $language->getMessage('operation', 'edit'),
            self::RECORD_DELETE
                => $language->getMessage('operation', 'delete'),
            self::RECORD_DELETE_CLONE
                => $language->getMessage('operation', 'deleteClone'),
            self::RECORD_DUPLICATE
                => $language->getMessage('operation', 'duplicate'),
            self::RECORD_DUPLICATE_CLONE
                => $language->getMessage('operation', 'duplicateClone'),
        ];

        if ($isAll === true) {
            $list[self::RECORD_ADD] = $language->getMessage('operation', 'add');
            $list[self::RECORD_ADD_CLONE]
                = $language->getMessage('operation', 'addClone');
        }

        return $list;
    }

    /**
     * Gets a list of content operations by content type
     *
     * @param int  $contentType Content type
     * @param bool $isAll       Flag
     *
     * @return array
     */
    public function getOperationsByContentType($contentType, $isAll)
    {
        switch ($contentType) {
            case BlockModel::TYPE_TEXT:
                return self::getBlockTextOperations($isAll);
            case BlockModel::TYPE_IMAGE:
                return self::getBlockImageOperations($isAll);
            case BlockModel::TYPE_RECORD:
                return self::getBlockRecordOperations($isAll);
            default:
                return [];
        }
    }
}
