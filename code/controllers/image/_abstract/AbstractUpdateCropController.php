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
                'x1'          => [self::TYPE_INT],
                'y1'          => [self::TYPE_INT],
                'viewWidth'          => [self::TYPE_INT],
                'viewHeight'          => [self::TYPE_INT],
                'angle'       => [self::TYPE_INT],
                'flip'        => [self::TYPE_INT],
                'thumbX'      => [self::TYPE_INT],
                'thumbY'      => [self::TYPE_INT],
                'thumbWidth'  => [self::TYPE_INT],
                'thumbHeight' => [self::TYPE_INT],
                'thumbAngle'  => [self::TYPE_INT],
                'thumbFlip'   => [self::TYPE_INT],
            ]
        );

        $data = [
            'x1'          => $this->get('x1'),
            'y1'          => $this->get('y1'),
            'viewWidth'          => $this->get('viewWidth'),
            'viewHeight'          => $this->get('viewHeight'),
            'angle'       => $this->get('angle'),
            'flip'        => $this->get('flip'),
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
