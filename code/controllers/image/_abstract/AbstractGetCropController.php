<?php

namespace ss\controllers\image\_abstract;

use ss\application\App;
use ss\application\exceptions\NotFoundException;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\helpers\file\FileModel;
use ss\models\blocks\image\ImageInstanceModel;
use ss\models\blocks\image\ImageModel;

/**
 * Abstract class to get crop details
 */
abstract class AbstractGetCropController extends AbstractController
{

    /**
     * Gets crop data
     *
     * @param int $instanceId Instance ID
     *
     * @return array
     *
     * @throws NotFoundException
     */
    public function getCrop($instanceId)
    {
        $instanceId = (int)$instanceId;
        $imageModel = ImageModel::model()->findByImageInstanceId($instanceId);

        $viewCropX = 0;
        $viewCropY = 0;
        if ($imageModel !== null) {
            $viewCropX = $imageModel->get('viewCropX');
            $viewCropY = $imageModel->get('viewCropY');
        }

        $imageInstanceModel = ImageInstanceModel::model()
            ->byId($instanceId)
            ->find();
        if ($imageInstanceModel instanceof ImageInstanceModel === false) {
            throw new NotFoundException(
                'Unable to find ImageInstanceModel by ID: {id}',
                [
                    'id' => $instanceId
                ]
            );
        }

        $fileModel = $imageInstanceModel->get('originalFileModel');
        if ($fileModel instanceof FileModel === false) {
            throw new NotFoundException(
                'Unable to get original FileModel ' .
                'for ImageInstanceModel with ID: {id}',
                [
                    'id' => $instanceId
                ]
            );
        }

        $language = App::getInstance()->getLanguage();

        $data = [
            'title'    => $language->getMessage('image', 'cropNoun'),
            'id'       => $instanceId,
            'labels'   => [
                'preview'     => $language->getMessage('image', 'preview'),
                'actions'     => $language->getMessage('image', 'actions'),
                'proportions' => $language->getMessage('image', 'proportions'),
                'button'      => $language->getMessage('image', 'cropVerb'),
                'mainImage'   => $language->getMessage('image', 'mainImage'),
                'thumb'       => $language->getMessage('image', 'thumb'),
            ],
            'url'      => $fileModel->getUrl(),
            'hasThumb' => false,
            'view'     => [
                'title'  => 'mainImage',
                'x'      => $imageInstanceModel->get('viewX'),
                'y'      => $imageInstanceModel->get('viewY'),
                'width'  => $imageInstanceModel->get('viewWidth'),
                'height' => $imageInstanceModel->get('viewHeight'),
                'angle'  => $imageInstanceModel->get('viewAngle'),
                'flip'   => $imageInstanceModel->get('viewFlip'),
                'cropX'  => $viewCropX,
                'cropY'  => $viewCropY,
            ],
        ];

        if ($imageModel === null
            || $imageModel->get('type') !== ImageModel::TYPE_ZOOM
        ) {
            return $data;
        }

        return array_merge(
            $data,
            [
                'hasThumb' => true,
                'thumb'    => [
                    'title'  => 'thumb',
                    'x'      => $imageInstanceModel->get('thumbX'),
                    'y'      => $imageInstanceModel->get('thumbY'),
                    'width'  => $imageInstanceModel->get('thumbWidth'),
                    'height' => $imageInstanceModel->get('thumbHeight'),
                    'angle'  => $imageInstanceModel->get('thumbAngle'),
                    'flip'   => $imageInstanceModel->get('thumbFlip'),
                    'cropX'  => $imageModel->get('thumbCropX'),
                    'cropY'  => $imageModel->get('thumbCropY'),
                ],
            ]
        );
    }
}
