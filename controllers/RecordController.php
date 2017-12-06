<?php

namespace testS\controllers;

use testS\components\Language;
use testS\components\Operation;
use testS\models\BlockModel;

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
     * Adds block
     */
    public function createBlock()
    {
        // @TODO
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