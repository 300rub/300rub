<?php

namespace ss\controllers\block;

use ss\application\App;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;

/**
 * Gets a list of blocks
 */
class GetBlocksController extends AbstractController
{

    /**
     * List
     *
     * @var array
     */
    private $_list = [];

    /**
     * Runs controller
     *
     * @return array
     */
    public function run()
    {
        $this->checkUser();

        $this->_list = [];
        $this
            ->_setTextBlock();

        $language = App::web()->getLanguage();
        return [
            'title'       => $language->getMessage('block', 'blocks'),
            'description' => $language->getMessage('block', 'blockDescription'),
            'list'        => $this->_list
        ];
    }

    /**
     * Sets text blocks
     *
     * @return GetBlocksController
     */
    private function _setTextBlock()
    {
        if ($this->hasBlockOperation(BlockModel::TYPE_TEXT) === false) {
            return $this;
        }

        $blockModel = new BlockModel();

        $isDisplay = true;
        $blockSection = $this->getBlockSection();
        if ($blockSection > 0) {
            $blockModel
                ->byContentType(BlockModel::TYPE_TEXT)
                ->bySectionId($blockSection)
                ->byLanguage(App::web()->getLanguage()->getActiveId());

            $isDisplay = false;
            if ($blockModel->getCount() > 0) {
                $isDisplay = true;
            }
        }

        if ($isDisplay === true) {
            $this->_list[] = [
                'name' => $blockModel->getTypeName(BlockModel::TYPE_TEXT),
                'type' => 'text'
            ];
        }

        return $this;
    }
}
