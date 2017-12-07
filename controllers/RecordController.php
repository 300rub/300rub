<?php

namespace testS\controllers;

use testS\components\Language;
use testS\components\Operation;
use testS\models\BlockModel;
use testS\models\RecordModel;

/**
 * RecordController
 *
 * @package testS\controllers
 */
class RecordController extends AbstractController
{

    /**
     * Gets a list of blocks
     *
     * @return array
     */
    public function getBlocks()
    {
        $this->checkUser();

        $blockModels = (new BlockModel())
            ->byContentType(BlockModel::TYPE_RECORD)
            ->byLanguage(Language::getActiveId())
            ->bySectionId($this->getDisplayBlocksFromSection())
            ->findAll();

        $cloneBlockModels = (new BlockModel())
            ->byContentType(BlockModel::TYPE_RECORD_CLONE)
            ->byLanguage(Language::getActiveId())
            ->bySectionId($this->getDisplayBlocksFromSection())
            ->findAll();

        $packedCloneModels = [];
        foreach ($cloneBlockModels as $cloneBlockModel) {
            $contentModel = $cloneBlockModel->getContentModel(false, null, "RecordCloneModel");

            $recordId = $contentModel->get("recordId");
            if (!array_key_exists($recordId, $packedCloneModels)) {
                $packedCloneModels[$recordId] = [];
            }

            $packedCloneModels[$recordId][] = $cloneBlockModel;
        }

        $list = [];
        foreach ($blockModels as $blockModel) {
            $canUpdateSettings = $this->hasBlockOperation(
                BlockModel::TYPE_RECORD,
                $blockModel->getId(),
                Operation::RECORD_UPDATE_SETTINGS
            );
            $canUpdateDesign = $this->hasBlockOperation(
                BlockModel::TYPE_RECORD,
                $blockModel->getId(),
                Operation::RECORD_UPDATE_DESIGN
            );
            $canUpdateContent = $this->hasBlockOperation(
                BlockModel::TYPE_RECORD,
                $blockModel->getId(),
                Operation::RECORD_UPDATE_CONTENT
            );

            if ($canUpdateSettings === false
                && $canUpdateDesign === false
                && $canUpdateContent === false
            ) {
                continue;
            }

            $clones = [];
            if ($canUpdateSettings === true
                || $canUpdateDesign === true
            ) {
                $contentId = $blockModel->get("contentId");
                if (array_key_exists($contentId, $packedCloneModels)) {
                    /**
                     * @var BlockModel[] $cloneModels
                     */
                    $cloneModels = $packedCloneModels[$contentId];
                    foreach ($cloneModels as $cloneModel) {
                        $clones[] = [
                            "name"              => $cloneModel->get("name"),
                            "id"                => $cloneModel->getId(),
                            "canUpdateSettings" => $canUpdateSettings,
                            "canUpdateDesign"   => $canUpdateDesign,
                        ];
                    }
                }
            }

            $list[] = [
                "name"              => $blockModel->get("name"),
                "id"                => $blockModel->getId(),
                "canUpdateSettings" => $canUpdateSettings,
                "canUpdateDesign"   => $canUpdateDesign,
                "canUpdateContent"  => $canUpdateContent,
                "clones"            => $clones
            ];
        }

        $canAdd = $this->hasBlockOperation(
            BlockModel::TYPE_RECORD,
            Operation::ALL,
            Operation::RECORD_ADD
        );

        return [
            "title"       => Language::t("record", "records"),
            "description" => Language::t("record", "panelDescription"),
            "list"        => $list,
            "back"        => [
                "controller" => "block",
                "action"     => "blocks"
            ],
            "settings"    => [
                "controller" => "record",
                "action"     => "block"
            ],
            "design"      => [
                "controller" => "record",
                "action"     => "design"
            ],
            "content"     => [
                "controller" => "record",
                "action"     => "content"
            ],
            "canAdd"      => $canAdd,
        ];
    }

    /**
     * Gets block
     *
     * @return array
     */
    public function getBlock()
    {
        $id = (int)$this->get("id");
        if ($id === 0) {
            $this->checkBlockOperation(BlockModel::TYPE_RECORD, Operation::ALL, Operation::RECORD_ADD);

            $blockModel = new BlockModel();
            $recordModel = new RecordModel();
        } else {
            $this->checkBlockOperation(BlockModel::TYPE_RECORD, $id, Operation::RECORD_UPDATE_SETTINGS);

            $blockModel = BlockModel::getById($id);
            $recordModel = $blockModel->getContentModel(false, null, "RecordModel");
        }

        return [
            "id"          => $id,
            "title"       => Language::t(
                "record",
                $id === 0 ? "addBlockTitle" : "editBlockTitle"
            ),
            "description" => Language::t(
                "record",
                $id === 0 ? "addBlockDescription" : "editBlockDescription"
            ),
            "forms"       => [
                "name"               => [
                    "name"       => "name",
                    "label"      => Language::t("common", "name"),
                    "validation" => $blockModel->getValidationRulesForField("name"),
                    "value"      => $blockModel->get("name"),
                ],
                "hasCover"           => [
                    "name"  => "hasCover",
                    "label" => Language::t("record", "hasCover"),
                    "value" => $recordModel->get("hasCover"),
                ],
                "hasImages"          => [
                    "name"  => "hasImages",
                    "label" => Language::t("record", "hasImages"),
                    "value" => $recordModel->get("hasImages"),
                ],
                "hasCoverZoom"       => [
                    "name"  => "hasCoverZoom",
                    "label" => Language::t("record", "hasCoverZoom"),
                    "value" => $recordModel->get("hasCoverZoom"),
                ],
                "hasDescription"     => [
                    "name"  => "hasDescription",
                    "label" => Language::t("record", "hasDescription"),
                    "value" => $recordModel->get("hasDescription"),
                ],
                "useAutoload"        => [
                    "name"  => "useAutoload",
                    "label" => Language::t("record", "useAutoload"),
                    "value" => $recordModel->get("useAutoload"),
                ],
                "pageNavigationSize" => [
                    "name"  => "pageNavigationSize",
                    "label" => Language::t("record", "pageNavigationSize"),
                    "value" => $recordModel->get("pageNavigationSize"),
                ],
                "shortCardDateType"  => [
                    "label" => Language::t("record", "shortCardDateType"),
                    "value" => $recordModel->get("shortCardDateType"),
                    "name"  => "shortCardDateType",
                    "list"  => RecordModel::getDateTypeList()
                ],
                "fullCardDateType"   => [
                    "label" => Language::t("record", "fullCardDateType"),
                    "value" => $recordModel->get("fullCardDateType"),
                    "name"  => "fullCardDateType",
                    "list"  => RecordModel::getDateTypeList()
                ],
                "button"             => [
                    "label" => Language::t("common", $id === 0 ? "add" : "update"),
                ]
            ]
        ];
    }

    /**
     * Adds block
     *
     * @return array
     */
    public function createBlock()
    {
        $this->checkBlockOperation(BlockModel::TYPE_IMAGE, Operation::ALL, Operation::IMAGE_ADD);

        $this->checkData(
            [
                "name"               => [self::TYPE_STRING],
                "hasCover"           => [self::TYPE_BOOL],
                "hasImages"          => [self::TYPE_BOOL],
                "hasCoverZoom"       => [self::TYPE_BOOL],
                "hasDescription"     => [self::TYPE_BOOL],
                "useAutoload"        => [self::TYPE_BOOL],
                "pageNavigationSize" => [self::TYPE_INT],
                "shortCardDateType"  => [self::TYPE_INT],
                "fullCardDateType"   => [self::TYPE_INT],
            ]
        );

        $recordModel = new RecordModel();
        $recordModel->set(
            [
                "hasCover"           => $this->get("hasCover"),
                "hasImages"          => $this->get("hasImages"),
                "hasCoverZoom"       => $this->get("hasCoverZoom"),
                "hasDescription"     => $this->get("hasDescription"),
                "useAutoload"        => $this->get("useAutoload"),
                "pageNavigationSize" => $this->get("pageNavigationSize"),
                "shortCardDateType"  => $this->get("shortCardDateType"),
                "fullCardDateType"   => $this->get("fullCardDateType"),
            ]
        );
        $recordModel->save();

        $blockModel = new BlockModel();
        $blockModel->set(
            [
                "name"        => $this->get("name"),
                "language"    => Language::getActiveId(),
                "contentType" => BlockModel::TYPE_RECORD,
                "contentId"   => $recordModel->getId(),
            ]
        );
        $blockModel->save();
        $errors = $blockModel->getParsedErrors();
        if (count($errors) > 0) {
            $this->removeSavedData();

            return [
                "errors" => $errors
            ];
        }

        return $this->getSimpleSuccessResult();
    }

    /**
     * Updates block
     */
    public function updateBlock()
    {
        // @TODO
    }

    /**
     * Deletes block
     */
    public function deleteBlock()
    {
        // @TODO
    }

    /**
     * Adds block
     */
    public function createBlockDuplication()
    {
        // @TODO
    }

    /**
     * Gets block
     */
    public function getCloneBlock()
    {
        // @TODO
    }

    /**
     * Adds block
     */
    public function createCloneBlock()
    {
        // @TODO
    }

    /**
     * Updates block
     */
    public function updateCloneBlock()
    {
        // @TODO
    }

    /**
     * Deletes block
     */
    public function deleteCloneBlock()
    {
        // @TODO
    }

    /**
     * Adds block
     */
    public function createCloneBlockDuplication()
    {
        // @TODO
    }

    /**
     * Gets block's design
     */
    public function getDesign()
    {
        // @TODO
    }

    /**
     * Updates block's design
     */
    public function updateDesign()
    {
        // @TODO
    }

    /**
     * Gets block's design
     */
    public function getCloneDesign()
    {
        // @TODO
    }

    /**
     * Updates block's design
     */
    public function updateCloneDesign()
    {
        // @TODO
    }

    /**
     * Gets block's content
     */
    public function getContent()
    {
        // @TODO
    }

    /**
     * Updates block's content
     */
    public function updateContent()
    {
        // @TODO
    }

    /**
     * Adds a record
     */
    public function createRecord()
    {
        // @TODO
    }

    /**
     * Gets a record
     */
    public function getRecord()
    {
        // @TODO
    }

    /**
     * Updates a record
     */
    public function updateRecord()
    {
        // @TODO
    }

    /**
     * Deletes a record
     */
    public function deleteRecord()
    {
        // @TODO
    }
}