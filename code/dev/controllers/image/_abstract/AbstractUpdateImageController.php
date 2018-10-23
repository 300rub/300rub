<?php

namespace ss\controllers\image\_abstract;

use ss\application\exceptions\NotFoundException;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\image\ImageInstanceModel;

/**
 * Abstract class to update images
 */
abstract class AbstractUpdateImageController extends AbstractController
{

    /**
     * Updates image
     *
     * @return array
     */
    protected function update()
    {
        $this->checkData(
            [
                'id'      => [self::TYPE_INT, self::NOT_EMPTY],
                'isCover' => [self::TYPE_BOOL],
                'alt'     => [self::TYPE_STRING],
            ]
        );

        $data = [
            'isCover' => $this->get('isCover'),
            'alt'     => $this->get('alt'),
        ];

        $this->_getImageInstanceModel()->update($data);

        return $this->getSimpleSuccessResult();
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
