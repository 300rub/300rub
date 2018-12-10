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

        switch ($imageInstanceModel->get('flip')) {
            case ImageInstanceModel::FLIP_HORIZONTAL:
                break;
        }

        $data = [
            'title'   => $language->getMessage('image', 'cropNoun'),
            'id'      => $instanceId,
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
            'viewWidth'      => $imageInstanceModel->get('viewWidth'),
            'viewHeight'      => $imageInstanceModel->get('viewHeight'),
            'angle'   => $imageInstanceModel->get('angle'),
            'flip'    => $imageInstanceModel->get('flip'),
        ];

        if ($imageModel->get('type') !== ImageModel::TYPE_ZOOM) {
            return $data;
        }

        return array_merge(
            $data,
            [
                'thumbX'      => $imageInstanceModel->get('thumbX'),
                'thumbY'      => $imageInstanceModel->get('thumbY'),
                'thumbWidth'  => $imageInstanceModel->get('thumbWidth'),
                'thumbHeight' => $imageInstanceModel->get('thumbHeight'),
                'thumbAngle'  => $imageInstanceModel->get('thumbAngle'),
                'thumbFlip'   => $imageInstanceModel->get('thumbFlip'),
            ]
        );
    }
}
