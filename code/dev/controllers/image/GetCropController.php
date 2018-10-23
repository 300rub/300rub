<?php

namespace ss\controllers\image;

use ss\application\components\user\Operation;
use ss\application\exceptions\NotFoundException;
use ss\controllers\image\_abstract\AbstractGetCropController;
use ss\models\blocks\block\BlockModel;

/**
 * Gets image crop details
 */
class GetCropController extends AbstractGetCropController
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

        $this->checkBlockOperation(
            BlockModel::TYPE_IMAGE,
            $this->get('blockId'),
            Operation::IMAGE_CROP
        );

        return array_merge(
            $this->getCrop($this->get('id')),
            [
                'blockId' => $this->get('blockId'),
            ]
        );
    }
}
