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
     * @return string
     */
    protected function update()
    {
        $this->checkData(
            [
                'id'      => [self::TYPE_INT, self::NOT_EMPTY],
                'isCover' => [self::TYPE_BOOL],
                'alt'     => [self::TYPE_STRING],
                'link'    => [self::TYPE_STRING],
            ]
        );

        $data = [
            'isCover' => $this->get('isCover'),
            'alt'     => $this->get('alt'),
            'link'    => $this->get('link'),
        ];

        $model = $this->_getImageInstanceModel();
        $model->update($data);

        $errors = $model->getParsedErrors();
        if (count($errors) > 0) {
            return [
                'errors' => $errors
            ];
        }

        return $model->get('originalFileModel')->getUrl();
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
            ->withRelations(['originalFileModel'])
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
