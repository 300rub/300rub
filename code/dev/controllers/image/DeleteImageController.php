<?php

namespace ss\controllers\image;

use ss\application\components\user\Operation;
use ss\controllers\image\_abstract\AbstractDeleteImageController;
use ss\models\blocks\block\BlockModel;

/**
 * Deletes the image
 */
class DeleteImageController extends AbstractDeleteImageController
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
                'id'      => [self::TYPE_INT, self::NOT_EMPTY],
            ]
        );

        $this->checkBlockOperation(
            BlockModel::TYPE_IMAGE,
            $this->get('blockId'),
            Operation::IMAGE_UPLOAD
        );

        return $this->delete($this->get('id'));
    }
}
