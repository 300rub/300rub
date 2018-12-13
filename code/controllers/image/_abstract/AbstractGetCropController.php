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
                'button' => App::getInstance()
                    ->getLanguage()
                    ->getMessage('image', 'cropVerb')
            ],
            'url'      => $fileModel->getUrl(),
            'hasThumb' => false,
            'view'     => [
                'x'      => $imageInstanceModel->get('viewX'),
                'y'      => $imageInstanceModel->get('viewY'),
                'width'  => $imageInstanceModel->get('viewWidth'),
                'height' => $imageInstanceModel->get('viewHeight'),
                'angle'  => $imageInstanceModel->get('viewAngle'),
                'flip'   => $imageInstanceModel->get('viewFlip'),
                'cropX'  => $imageModel->get('viewCropX'),
                'cropY'  => $imageModel->get('viewCropY'),
            ],
        ];

        if ($imageModel->get('type') !== ImageModel::TYPE_ZOOM) {
            return $data;
        }

        return array_merge(
            $data,
            [
                'hasThumb' => true,
                'thumb'    => [
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
