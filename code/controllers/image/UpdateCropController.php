<?php

namespace ss\controllers\image;

use ss\application\App;
use ss\application\components\user\Operation;
use ss\controllers\image\_abstract\AbstractUpdateCropController;
use ss\models\blocks\block\BlockModel;
use ss\models\user\UserEventModel;

/**
 * Crops image
 */
class UpdateCropController extends AbstractUpdateCropController
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

        $result = $this->crop();

        $blockModel = BlockModel::model()->getById($this->get('blockId'));

        App::getInstance()->getUser()->writeEvent(
            UserEventModel::CATEGORY_BLOCK_IMAGE,
            UserEventModel::TYPE_EDIT,
            sprintf(
                App::getInstance()->getLanguage()->getMessage(
                    'event',
                    'imageCropped'
                ),
                $result['originalUrl'],
                $blockModel->get('name')
            )
        );

        return $result;
    }
}
