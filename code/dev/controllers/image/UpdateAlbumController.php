<?php

namespace ss\controllers\image;

use ss\application\components\user\Operation;
use ss\application\exceptions\NotFoundException;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\image\ImageGroupModel;
use ss\models\blocks\image\ImageModel;

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
                'blockId'     => [self::TYPE_INT, self::NOT_EMPTY],
                'id'          => [self::TYPE_INT, self::NOT_EMPTY],
                'name'        => [self::TYPE_STRING],
                'alias'       => [self::TYPE_STRING],
                'title'       => [self::TYPE_STRING],
                'keywords'    => [self::TYPE_STRING],
                'description' => [self::TYPE_STRING],
            ]
        );

        $this->checkBlockOperation(
            BlockModel::TYPE_IMAGE,
            $this->get('blockId'),
            Operation::IMAGE_UPDATE_ALBUM
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
                    'blockId' => $blockModel->get(),
                    'imageId' => $imageModel->getId(),
                ]
            );
        }

        $imageGroupModel->set(
            [
                'seoModel' => [
                    'name'        => $this->get('name'),
                    'alias'       => $this->get('alias'),
                    'title'       => $this->get('title'),
                    'keywords'    => $this->get('keywords'),
                    'description' => $this->get('description'),
                ]
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
