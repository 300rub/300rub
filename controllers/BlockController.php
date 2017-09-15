<?php

namespace testS\controllers;

use testS\components\Language;
use testS\models\BlockModel;

/**
 * BlockController
 *
 * @package testS\controllers
 */
class BlockController extends AbstractController
{

    /**
     * Gets a list of blocks
     *
     * @return array
     */
    public function getBlocks()
    {
        $this->checkUser();

        $displayBlocksFromSection = $this->getDisplayBlocksFromSection();

        $list = [];

        if ($this->hasBlockOperation(BlockModel::TYPE_TEXT)) {
            if ($displayBlocksFromSection === 0) {
                $isDisplay = true;
            } else {
                $blocksCount = (new BlockModel())
                    ->byContentType(BlockModel::TYPE_TEXT)
                    ->byLanguage(Language::getActiveId())
                    ->bySectionId($displayBlocksFromSection)
                    ->getCount();
                $isDisplay = $blocksCount > 0;
            }

            if ($isDisplay === true) {
                $list[] = [
                    "name" => BlockModel::getTypeName(BlockModel::TYPE_TEXT),
                    "type" => "text"
                ];
            }
        }

        return [
            "title"       => Language::t("block", "blocks"),
            "description" => Language::t("block", "blockDescription"),
            "list"        => $list
        ];
    }
}