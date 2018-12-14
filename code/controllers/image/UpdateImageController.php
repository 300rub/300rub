<?php

namespace ss\controllers\image;

use ss\application\App;
use ss\application\components\user\Operation;
use ss\controllers\image\_abstract\AbstractUpdateImageController;
use ss\models\blocks\block\BlockModel;
use ss\models\user\UserEventModel;

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

        $result = $this->update();

        $blockModel = BlockModel::model()->getById($this->get('blockId'));

        App::getInstance()->getUser()->writeEvent(
            UserEventModel::CATEGORY_BLOCK_IMAGE,
            UserEventModel::TYPE_EDIT,
            sprintf(
                App::getInstance()->getLanguage()->getMessage(
                    'event',
                    'imageData'
                ),
                $result,
                $blockModel->get('name')
            )
        );

        return $this->getSimpleSuccessResult();
    }
}
