<?php

namespace ss\controllers\text;

use ss\application\components\user\Operation;
use ss\controllers\image\_abstract\AbstractCreateImageController;
use ss\models\blocks\block\BlockModel;

/**
 * Adds image
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
            2,
            Operation::IMAGE_UPLOAD
        );

        $result = $this
            ->setBlockId(2)
            ->create();

        return [
            'location' => $result['viewUrl'],
        ];
    }
}
