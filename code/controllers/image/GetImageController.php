<?php

namespace ss\controllers\image;

use ss\application\components\user\Operation;
use ss\application\exceptions\NotFoundException;
use ss\controllers\image\_abstract\AbstractGetImageController;
use ss\models\blocks\block\BlockModel;

/**
 * Gets image
 */
class GetImageController extends AbstractGetImageController
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
            Operation::IMAGE_UPDATE
        );

        return $this->getImage($this->get('id'));
    }
}
