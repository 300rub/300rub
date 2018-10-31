<?php

namespace ss\controllers\image;

use ss\application\components\user\Operation;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\image\ImageGroupModel;
use ss\models\blocks\image\ImageModel;

/**
 * Creates an album
 */
class CreateAlbumController extends AbstractController
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
                'blockId'     => [self::TYPE_INT, self::NOT_EMPTY],
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
            Operation::IMAGE_CREATE_ALBUM
        );

        $blockModel = BlockModel::model()->getById($this->get('blockId'));
        $imageModel = $blockModel->getContentModel(
            ImageModel::CLASS_NAME
        );

        $imageGroupModel = new ImageGroupModel();
        $imageGroupModel->set(
            [
                'imageId'  => $imageModel->getId(),
                'seoModel' => [
                    'name'        => $this->get('name'),
                    'alias'       => $this->get('alias'),
                    'title'       => $this->get('title'),
                    'keywords'    => $this->get('keywords'),
                    'description' => $this->get('description'),
                ],
                'sort'     => 10000,
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
