<?php

namespace ss\controllers\record;

use ss\application\components\helpers\Link;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\record\RecordModel;

/**
 * Gets content
 */
class GetContentController extends AbstractController
{

    /**
     * Runs controller
     *
     * @return array
     */
    public function run()
    {
        $html = $this->_getRecordModel()->getInstancesHtml(
            (int)$this->get('page'),
            $this->get('sectionId')
        );

        $link = new Link();
        $html = $link->parseLinks($html);

        return [
            'html' => $html
        ];
    }

    /**
     * Gets record model
     *
     * @return RecordModel
     */
    private function _getRecordModel()
    {
        $blockModel = BlockModel::model()->getById($this->get('blockId'));
        return $blockModel->getContentModel(
            RecordModel::CLASS_NAME
        );
    }
}
