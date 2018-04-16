<?php

namespace ss\controllers\image;

use ss\application\components\Operation;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\image\ImageInstanceModel;

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
                'imageGroupId' => $this->get('imageGroupId'),
                'alt'          => $this->get('alt'),
                'link'         => $this->get('link'),
            ]
        );

        return $imageInstanceModel->upload();
    }
}
