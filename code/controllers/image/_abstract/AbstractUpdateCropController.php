<?php

namespace ss\controllers\image\_abstract;

use ss\application\exceptions\NotFoundException;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\image\ImageInstanceModel;
use ss\models\blocks\image\ImageModel;

/**
 * Abstract class to crop images
 */
abstract class AbstractUpdateCropController extends AbstractController
{

    /**
     * Crops image
     *
     * @return array
     */
    public function crop()
    {
        $this->checkData(
            [
                'id'   => [self::TYPE_INT, self::NOT_EMPTY],
                'view' => [
                    'x'      => [self::TYPE_INT],
                    'y'      => [self::TYPE_INT],
                    'width'  => [self::TYPE_INT],
                    'height' => [self::TYPE_INT],
                    'angle'  => [self::TYPE_INT],
                    'flip'   => [self::TYPE_INT],
                ],
            ]
        );

        $viewData = $this->get('view');
        $data = [
            'viewX'       => $viewData['x'],
            'viewY'       => $viewData['y'],
            'viewWidth'   => $viewData['width'],
            'viewHeight'  => $viewData['height'],
            'viewAngle'   => $viewData['angle'],
            'viewFlip'    => $viewData['flip'],
        ];

        $imageModel = ImageModel::model()->findByImageInstanceId(
            $this->get('id')
        );
        if ($imageModel->get('type') !== ImageModel::TYPE_ZOOM) {
            return $this->_getImageInstanceModel()->crop($data);
        }

        $this->checkData(
            [
                'thumb' => [
                    'x'      => [self::TYPE_INT],
                    'y'      => [self::TYPE_INT],
                    'width'  => [self::TYPE_INT],
                    'height' => [self::TYPE_INT],
                    'angle'  => [self::TYPE_INT],
                    'flip'   => [self::TYPE_INT],
                ],
            ]
        );

        $thumbData = $this->get('thumb');
        $data = array_merge(
            $data,
            [
                'thumbX'       => $thumbData['x'],
                'thumbY'       => $thumbData['y'],
                'thumbWidth'   => $thumbData['width'],
                'thumbHeight'  => $thumbData['height'],
                'thumbAngle'   => $thumbData['angle'],
                'thumbFlip'    => $thumbData['flip'],
            ]
        );

        return $this->_getImageInstanceModel()->crop($data);
    }

    /**
     * Gets image instance model
     *
     * @return ImageInstanceModel
     *
     * @throws NotFoundException
     */
    private function _getImageInstanceModel()
    {
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

        return $imageInstanceModel;
    }
}
