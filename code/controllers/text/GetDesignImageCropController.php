<?php

namespace ss\controllers\text;

use ss\application\components\user\Operation;
use ss\application\exceptions\NotFoundException;
use ss\controllers\image\_abstract\AbstractGetCropController;
use ss\models\blocks\block\BlockModel;

/**
 * Gets image crop details
 */
class GetDesignImageCropController extends AbstractGetCropController
{

    /**
     * Runs controller
     *
     * @return array
     *
     * @throws NotFoundException
     */
    public function run()
    {
        $this->checkData(
            [
                'blockId' => [self::NOT_EMPTY],
                'id'      => [self::NOT_EMPTY],
            ]
        );

        $blockId = (int)$this->get('blockId');

        $this->checkBlockOperation(
            BlockModel::TYPE_TEXT,
            $blockId,
            Operation::TEXT_UPDATE_DESIGN
        );

        return array_merge(
            $this->getCrop($this->get('id')),
            [
                'blockId' => $blockId,
            ]
        );
    }
}
