<?php

namespace ss\controllers\text;

use ss\application\components\user\Operation;
use ss\controllers\image\_abstract\AbstractUpdateCropController;
use ss\models\blocks\block\BlockModel;

/**
 * Crops image
 */
class UpdateDesignImageCropController extends AbstractUpdateCropController
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
            BlockModel::TYPE_TEXT,
            $this->get('blockId'),
            Operation::TEXT_UPDATE_DESIGN
        );

        return $this->crop();
    }
}
