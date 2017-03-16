<?php

namespace testS\controllers;

use testS\components\Language;
use testS\components\Operation;
use testS\models\BlockModel;

/**
 * TextController
 *
 * @package testS\controllers
 */
class TextController extends AbstractController
{

    /**
     * Gets block's HTML
     */
    public function getHtml()
    {
        // @TODO
    }

    /**
     * Gets a list of blocks
     */
    public function getBlocks()
    {
        $this->checkUser();

        $blockModels = (new BlockModel())
            ->byContentType(BlockModel::TYPE_TEXT)
            ->byLanguage(Language::getActiveId())
            ->bySectionId($this->getDisplayBlocksFromSection())
            ->findAll();

        $list = [];
        foreach ($blockModels as $blockModel) {
            $canUpdateSettings = $this->hasBlockOperation(
                BlockModel::TYPE_TEXT,
                $blockModel->get("contentId"),
                Operation::TEXT_UPDATE_SETTINGS
            );
            $canUpdateDesign = $this->hasBlockOperation(
                BlockModel::TYPE_TEXT,
                $blockModel->get("contentId"),
                Operation::TEXT_UPDATE_DESIGN
            );
            $canUpdateContent = $this->hasBlockOperation(
                BlockModel::TYPE_TEXT,
                $blockModel->get("contentId"),
                Operation::TEXT_UPDATE_CONTENT
            );

            if ($canUpdateSettings === false
                && $canUpdateDesign === false
                && $canUpdateContent === false
            ) {
                continue;
            }

            $list[] = [
                "blockName"         => $blockModel->get("name"),
                "contentId"         => $blockModel->get("contentId"),
                "canUpdateSettings" => $canUpdateSettings,
                "canUpdateDesign"   => $canUpdateDesign,
                "canUpdateContent"  => $canUpdateContent
            ];
        }

        $canAdd = $this->hasBlockOperation(
            BlockModel::TYPE_TEXT,
            Operation::ALL,
            Operation::TEXT_UPDATE_SETTINGS
        );

        return [
            "title"       => Language::t("text", "texts"),
            "description" => Language::t("text", "panelDescription"),
            "list"        => $list,
            "back"        => [
                "controller" => "block",
                "action"     => "blocks"
            ],
            "settings"    => [
                "controller" => "text",
                "action"     => "block"
            ],
            "design"      => [
                "controller" => "text",
                "action"     => "design"
            ],
            "content"     => [
                "controller" => "text",
                "action"     => "content"
            ],
            "canAdd"      => $canAdd,
        ];
    }

    /**
     * Gets block
     */
    public function getBlock()
    {
        // @TODO
    }

    /**
     * Adds block
     */
    public function addBlock()
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
}