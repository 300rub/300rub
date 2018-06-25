<?php

namespace ss\controllers\image;

use ss\application\components\Operation;
use ss\application\exceptions\NotFoundException;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\image\ImageGroupModel;
use ss\models\blocks\image\ImageModel;

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

        $imageGroupModel->delete();

        return $this->getSimpleSuccessResult();
    }
}
