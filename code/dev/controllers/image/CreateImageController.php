<?php

namespace ss\controllers\image;

use ss\application\components\user\Operation;
use ss\controllers\image\_abstract\AbstractCreateImageController;
use ss\models\blocks\block\BlockModel;

/**
 * Adds block
 */
class CreateImageController extends AbstractCreateImageController
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
                'blockId' => [self::NOT_EMPTY],
            ]
        );

        $this->checkBlockOperation(
            BlockModel::TYPE_IMAGE,
            $this->get('blockId'),
            Operation::IMAGE_UPLOAD
        );

        $result = $this
            ->setImageGroupId($this->get('imageGroupId'))
            ->setBlockId($this->get('blockId'))
            ->create();

        return [
            'id'   => $result['id'],
            'name' => $result['name'],
            'url'  => $result['thumbUrl'],
        ];
    }
}
