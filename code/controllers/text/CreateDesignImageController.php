<?php

namespace ss\controllers\text;

use ss\application\components\user\Operation;
use ss\controllers\image\_abstract\AbstractCreateImageController;
use ss\models\blocks\block\BlockModel;

/**
 * Adds image
 */
class CreateDesignImageController extends AbstractCreateImageController
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
            BlockModel::TYPE_TEXT,
            $this->get('blockId'),
            Operation::TEXT_UPDATE_DESIGN
        );

        $result = $this
            ->setBlockId($this->get('blockId'))
            ->markUnused()
            ->create();

        return [
            'id'   => $result['id'],
            'name' => $result['name'],
            'url'  => $result['thumbUrl'],
        ];
    }
}
