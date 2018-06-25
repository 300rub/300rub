<?php

namespace ss\controllers\image;

use ss\application\components\Operation;
use ss\application\exceptions\NotFoundException;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\image\ImageInstanceModel;

/**
 * Updates image
 */
class UpdateImageController extends AbstractController
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
                'blockId' => [self::TYPE_INT, self::NOT_EMPTY],
                'id'      => [self::TYPE_INT, self::NOT_EMPTY],
                'isCover' => [self::TYPE_BOOL],
                'alt'     => [self::TYPE_STRING],
                'x1'      => [self::TYPE_INT],
                'y1'      => [self::TYPE_INT],
                'x2'      => [self::TYPE_INT],
                'y2'      => [self::TYPE_INT],
                'thumbX1' => [self::TYPE_INT],
                'thumbY1' => [self::TYPE_INT],
                'thumbX2' => [self::TYPE_INT],
                'thumbY2' => [self::TYPE_INT],
                'angle'   => [self::TYPE_INT],
                'flip'    => [self::TYPE_INT],
            ]
        );

        $this->checkBlockOperation(
            BlockModel::TYPE_IMAGE,
            $this->get('blockId'),
            Operation::IMAGE_UPDATE
        );

        $data = [
            'isCover' => $this->get('isCover'),
            'alt'     => $this->get('alt'),
            'x1'      => $this->get('x1'),
            'y1'      => $this->get('y1'),
            'x2'      => $this->get('x2'),
            'y2'      => $this->get('y2'),
            'thumbX1' => $this->get('thumbX1'),
            'thumbY1' => $this->get('thumbY1'),
            'thumbX2' => $this->get('thumbX2'),
            'thumbY2' => $this->get('thumbY2'),
            'angle'   => $this->get('angle'),
            'flip'    => $this->get('flip'),
        ];

        return $this->_getImageInstanceModel()->update($data);
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
