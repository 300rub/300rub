<?php

namespace testS\controllers\image;

use testS\application\components\Operation;
use testS\controllers\_abstract\AbstractController;
use testS\models\blocks\block\BlockModel;
use testS\models\blocks\image\ImageInstanceModel;

/**
 * Adds block
 */
class CreateImageController extends AbstractController
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
                'blockId'      => [self::NOT_EMPTY],
                'imageGroupId' => [self::NOT_EMPTY],
            ]
        );

        $this->checkBlockOperation(
            BlockModel::TYPE_IMAGE,
            $this->get('blockId'),
            Operation::IMAGE_UPLOAD
        );

        $imageInstanceModel = new ImageInstanceModel();
        $imageInstanceModel->set(
            [
                'imageGroupId' => $this->get('imageGroupId')
            ]
        );

        return $imageInstanceModel->upload();
    }
}
