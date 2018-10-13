<?php

namespace ss\controllers\image;

use ss\application\App;
use ss\application\components\user\Operation;
use ss\application\exceptions\NotFoundException;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\helpers\file\FileModel;
use ss\models\blocks\image\ImageInstanceModel;
use ss\models\blocks\image\ImageModel;

/**
 * Gets image crop details
 */
class GetCropController extends AbstractController
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
                'blockId' => [self::NOT_EMPTY],
                'id'      => [self::NOT_EMPTY],
            ]
        );

        $this->checkBlockOperation(
            BlockModel::TYPE_IMAGE,
            $this->get('blockId'),
            Operation::IMAGE_CROP
        );

        $blockModel = BlockModel::model()->getById($this->get('blockId'));
        $imageModel = $blockModel->getContentModel(
            ImageModel::CLASS_NAME
        );

        $imageInstanceModel = ImageInstanceModel::model()
            ->byId($this->get('id'))
            ->find();
        if ($imageInstanceModel instanceof ImageInstanceModel === false) {
            throw new NotFoundException(
                'Unable to find ImageInstanceModel by ID: {id}',
                [
                    'id' => $this->get('id')
                ]
            );
        }

        $fileModel = $imageInstanceModel->get('originalFileModel');
        if ($fileModel instanceof FileModel === false) {
            throw new NotFoundException(
                'Unable to get original FileModel ' .
                'for ImageInstanceModel with ID: {id}',
                [
                    'id' => $this->get('id')
                ]
            );
        }

        $language = App::getInstance()->getLanguage();

        switch ($imageInstanceModel->get('flip')) {
            case ImageInstanceModel::FLIP_HORIZONTAL:
                break;
        }

        $data = [
            'title'   => $language->getMessage('image', 'cropNoun'),
            'blockId' => $this->get('blockId'),
            'id'      => $this->get('id'),
            'labels'  => [
                'button' => App::getInstance()
                ->getLanguage()
                ->getMessage('image', 'cropVerb')
            ],
            'url'     => $fileModel->getUrl(),
            'width'   => $imageInstanceModel->get('width'),
            'height'  => $imageInstanceModel->get('height'),
            'x1'      => $imageInstanceModel->get('x1'),
            'y1'      => $imageInstanceModel->get('y1'),
            'x2'      => $imageInstanceModel->get('x2'),
            'y2'      => $imageInstanceModel->get('y2'),
            'angle'   => $imageInstanceModel->get('angle'),
            'flip'    => $imageInstanceModel->get('angle'),
        ];

        if ($imageModel->get('type') !== ImageModel::TYPE_ZOOM) {
            return $data;
        }

        return array_merge_recursive(
            $data,
            [
                'thumbX1' => $imageInstanceModel->get('thumbX1'),
                'thumbY1' => $imageInstanceModel->get('thumbY1'),
                'thumbX2' => $imageInstanceModel->get('thumbX2'),
                'thumbY2' => $imageInstanceModel->get('thumbY2'),
            ]
        );
    }
}
