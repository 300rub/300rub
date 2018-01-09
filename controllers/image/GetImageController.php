<?php

namespace testS\controllers\image;

use testS\application\components\Operation;
use testS\application\exceptions\NotFoundException;
use testS\controllers\_abstract\AbstractController;
use testS\models\blocks\block\BlockModel;
use testS\models\blocks\helpers\file\FileModel;
use testS\models\blocks\image\ImageInstanceModel;

/**
 * Gets image
 */
class GetImageController extends AbstractController
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
            Operation::IMAGE_UPDATE
        );

        $imageInstanceModel = ImageInstanceModel::model()
            ->byId($this->get('id'))
            ->withRelations()
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

        return [
            'url'     => $fileModel->getUrl(),
            'alt'     => $imageInstanceModel->get('alt'),
            'width'   => $imageInstanceModel->get('width'),
            'height'  => $imageInstanceModel->get('height'),
            'x1'      => $imageInstanceModel->get('x1'),
            'y1'      => $imageInstanceModel->get('y1'),
            'x2'      => $imageInstanceModel->get('x2'),
            'y2'      => $imageInstanceModel->get('y2'),
            'thumbX1' => $imageInstanceModel->get('thumbX1'),
            'thumbY1' => $imageInstanceModel->get('thumbY1'),
            'thumbX2' => $imageInstanceModel->get('thumbX2'),
            'thumbY2' => $imageInstanceModel->get('thumbY2'),
        ];
    }
}
