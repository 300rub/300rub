<?php

namespace ss\controllers\image;

use ss\application\App;
use ss\application\components\user\Operation;
use ss\application\exceptions\NotFoundException;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\image\ImageGroupModel;
use ss\models\blocks\image\ImageModel;
use ss\models\user\UserEventModel;

/**
 * Deletes album
 */
class DeleteAlbumController extends AbstractController
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
                'blockId' => [self::TYPE_INT, self::NOT_EMPTY],
                'id'      => [self::TYPE_INT, self::NOT_EMPTY],
            ]
        );

        $this->checkBlockOperation(
            BlockModel::TYPE_IMAGE,
            $this->get('blockId'),
            Operation::IMAGE_DELETE_ALBUM
        );

        $blockModel = BlockModel::model()->getById($this->get('blockId'));
        $imageModel = $blockModel->getContentModel(
            ImageModel::CLASS_NAME
        );
        $imageGroupModel = ImageGroupModel::model()
            ->byImageId($imageModel->getId())
            ->byId($this->get('id'))
            ->withRelations(['seoModel'])
            ->find();

        if ($imageGroupModel === null) {
            throw new NotFoundException(
                'Unable to find ImageGroupModel by ID: {id} ' .
                'and blockId: {blockId} and imageId: {imageId}',
                [
                    'id'      => $this->get('id'),
                    'blockId' => $blockModel->getId(),
                    'imageId' => $imageModel->getId(),
                ]
            );
        }

        $name = $imageGroupModel->get('seoModel')->get('name');

        $imageGroupModel->delete();

        App::getInstance()->getUser()->writeEvent(
            UserEventModel::CATEGORY_BLOCK_IMAGE,
            UserEventModel::TYPE_DELETE,
            sprintf(
                App::getInstance()->getLanguage()->getMessage(
                    'event',
                    'imageAlbumDeleted'
                ),
                $name,
                $blockModel->get('name')
            )
        );

        return $this->getSimpleSuccessResult();
    }
}
