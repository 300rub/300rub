<?php

namespace ss\controllers\image;

use ss\application\App;
use ss\application\components\user\Operation;
use ss\controllers\image\_abstract\AbstractCreateImageController;
use ss\models\blocks\block\BlockModel;
use ss\models\user\UserEventModel;

/**
 * Adds image
 */
class CreateImageController extends AbstractCreateImageController
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
                'blockId' => [self::NOT_EMPTY],
            ]
        );

        $this->checkBlockOperation(
            BlockModel::TYPE_IMAGE,
            $this->get('blockId'),
            Operation::IMAGE_UPLOAD
        );

        $result = $this
            ->setImageGroupId($this->get('imageGroupId'))
            ->setBlockId($this->get('blockId'))
            ->create();

        $blockModel = BlockModel::model()->getById($this->get('blockId'));

        App::getInstance()->getUser()->writeEvent(
            UserEventModel::CATEGORY_BLOCK_IMAGE,
            UserEventModel::TYPE_ADD,
            sprintf(
                App::getInstance()->getLanguage()->getMessage(
                    'event',
                    'imageUploaded'
                ),
                $result['originalUrl'],
                $blockModel->get('name')
            )
        );

        return [
            'id'   => $result['id'],
            'name' => $result['name'],
            'url'  => $result['thumbUrl'],
        ];
    }
}
