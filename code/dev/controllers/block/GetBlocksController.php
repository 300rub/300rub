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

        $types = array_keys(BlockModel::model()->getTypeNames());
        foreach ($types as $type) {
            $this->_addListItem($type);
        }

        $language = App::getInstance()->getLanguage();
        return [
            'title'
                => $language->getMessage('block', 'blocks'),
            'description'
                => $language->getMessage('block', 'blockDescription'),
            'labels' => [
                'blockSection'
                    => $language->getMessage('block', 'blockSection'),
            ],
            'list'  => $this->_list
        ];
    }

    /**
     * Adds item to list
     *
     * @param string $type Type
     *
     * @return GetBlocksController
     */
    private function _addListItem($type)
    {
        if ($this->hasBlockOperation($type) === false) {
            return $this;
        }

        $blockModel = new BlockModel();

        $blockSection = $this->getBlockSection();
        if ($blockSection > 0) {
            $blockModel
                ->byContentType($type)
                ->bySectionId($blockSection)
                ->byLanguage(
                    App::getInstance()->getLanguage()->getActiveId()
                );

            if ($blockModel->getCount() === 0) {
                return $this;
            }
        }

        $this->_list[] = [
            'name' => $blockModel->getTypeName($type),
            'type' => $type
        ];

        return $this;
    }
}
