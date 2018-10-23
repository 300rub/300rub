<?php

namespace ss\controllers\image;

use ss\application\components\user\Operation;
use ss\controllers\image\_abstract\AbstractCropImageController;
use ss\models\blocks\block\BlockModel;

/**
 * Crops image
 */
class UpdateCropController extends AbstractCropImageController
{

    /**
     * Runs controller
     *
     * @return array
     */
    public function run()
    {
        $this->checkData(
            [
                'blockId' => [self::TYPE_INT, self::NOT_EMPTY],
            ]
        );

        $this->checkBlockOperation(
            BlockModel::TYPE_IMAGE,
            $this->get('blockId'),
            Operation::IMAGE_UPDATE
        );

        return $this->crop();
    }
}
