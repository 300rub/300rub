<?php

namespace testS\controllers\image;

use testS\application\components\Operation;
use testS\application\exceptions\NotFoundException;
use testS\controllers\_abstract\AbstractController;
use testS\models\blocks\block\BlockModel;
use testS\models\blocks\image\ImageGroupModel;
use testS\models\blocks\image\ImageModel;

/**
 * Updates album
 */
class UpdateAlbumController extends AbstractController
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
                'name'    => [self::TYPE_STRING],
            ]
        );

        $this->checkBlockOperation(
            BlockModel::TYPE_IMAGE,
            $this->get('blockId'),
            Operation::IMAGE_UPDATE_ALBUM
        );

        $blockModel = BlockModel::model()->getById($this->get('blockId'));
        $imageModel = $blockModel->getContentModel(
            false,
            null,
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
                    'blockId' => $blockModel->get(),
                    'imageId' => $imageModel->getId(),
                ]
            );
        }

        $imageGroupModel->set(
            [
                'name' => $this->get('name'),
            ]
        );
        $imageGroupModel->save();

        $errors = $imageGroupModel->getParsedErrors();
        if (count($errors) > 0) {
            $this->removeSavedData();

            return [
                'errors' => $errors
            ];
        }

        return $this->getSimpleSuccessResult();
    }
}
