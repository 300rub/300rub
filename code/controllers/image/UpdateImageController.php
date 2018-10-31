<?php

namespace ss\controllers\image;

use ss\application\components\user\Operation;
use ss\controllers\image\_abstract\AbstractUpdateImageController;
use ss\models\blocks\block\BlockModel;

/**
 * Updates image
 */
class UpdateImageController extends AbstractUpdateImageController
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

        return $this->update();
    }
}
