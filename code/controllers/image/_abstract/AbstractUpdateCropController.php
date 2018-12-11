<?php

namespace ss\controllers\image\_abstract;

use ss\application\exceptions\NotFoundException;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\image\ImageInstanceModel;

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
                'id'          => [self::TYPE_INT, self::NOT_EMPTY],
                'viewX'       => [self::TYPE_INT],
                'viewY'       => [self::TYPE_INT],
                'viewWidth'   => [self::TYPE_INT],
                'viewHeight'  => [self::TYPE_INT],
                'viewAngle'   => [self::TYPE_INT],
                'viewFlip'    => [self::TYPE_INT],
                'thumbX'      => [self::TYPE_INT],
                'thumbY'      => [self::TYPE_INT],
                'thumbWidth'  => [self::TYPE_INT],
                'thumbHeight' => [self::TYPE_INT],
                'thumbAngle'  => [self::TYPE_INT],
                'thumbFlip'   => [self::TYPE_INT],
            ]
        );

        $data = [
            'viewX'       => $this->get('viewX'),
            'viewY'       => $this->get('viewY'),
            'viewWidth'   => $this->get('viewWidth'),
            'viewHeight'  => $this->get('viewHeight'),
            'viewAngle'   => $this->get('viewAngle'),
            'viewFlip'    => $this->get('viewFlip'),
            'thumbX'      => $this->get('thumbX'),
            'thumbY'      => $this->get('thumbY'),
            'thumbWidth'  => $this->get('thumbWidth'),
            'thumbHeight' => $this->get('thumbHeight'),
            'thumbAngle'  => $this->get('viewAngle'),
            'thumbFlip'   => $this->get('viewFlip'),
        ];

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
