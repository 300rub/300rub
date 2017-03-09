<?php

namespace testS\controllers;

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
        $language = $this->getLanguageFromRequest();

        $blockModels = (new BlockModel())
            ->byContentType(BlockModel::TYPE_TEXT)
            ->byLanguage($language);

        $isDisplayBlocksFromPage = $this->getIsDisplayBlocksFromPage();
        if ($isDisplayBlocksFromPage === true) {
            $sectionId = $this->getSectionIdFromRequest();
            $blockModels->bySectionId($sectionId);
        }

        $blockModels = $blockModels->findAll();

        $list = [];
        foreach ($blockModels as $blockModel) {
            $list[] = [
                "blockName"       => $blockModel->get("name"),
                "contentId"       => $blockModel->get("contentId"),
                "canUpdate"       => $this->hasOperation(),
                "canUpdateDesign" => $this->hasOperation(),
            ];
        }

        return [
            "title"        => "",
            "description"  => "",
            "list"         => $list,
            "back"         => [
                "controller" => "",
                "action"     => ""
            ],
            "update"       => [
                "controller" => "",
                "action"     => ""
            ],
            "updateDesign" => [
                "controller" => "",
                "action"     => ""
            ],
            "canAdd"       => $this->hasOperation(),
        ];
    }

//    protected function getBlocksResponse(
//        $title,
//        $description,
//        $updateController,
//        $updateAction,
//        $updateDesignController,
//        $updateDesignAction,
//        $canAdd,
//
//    ) {
//
//    }

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