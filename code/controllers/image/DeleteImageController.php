<?php

namespace ss\controllers\image;

use ss\application\App;
use ss\application\components\user\Operation;
use ss\controllers\image\_abstract\AbstractDeleteImageController;
use ss\models\blocks\block\BlockModel;
use ss\models\user\UserEventModel;

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

        $url = $this->delete($this->get('id'));
        $blockModel = BlockModel::model()->getById($this->get('blockId'));

        App::getInstance()->getUser()->writeEvent(
            UserEventModel::CATEGORY_BLOCK_IMAGE,
            UserEventModel::TYPE_DELETE,
            sprintf(
                App::getInstance()->getLanguage()->getMessage(
                    'event',
                    'imageDeleted'
                ),
                $url,
                $blockModel->get('name')
            )
        );

        return $this->getSimpleSuccessResult();
    }
}
