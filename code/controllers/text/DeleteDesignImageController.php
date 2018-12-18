<?php

namespace ss\controllers\text;

use ss\application\App;
use ss\application\components\user\Operation;
use ss\controllers\image\_abstract\AbstractDeleteImageController;
use ss\models\blocks\block\BlockModel;
use ss\models\user\UserEventModel;

/**
 * Deletes the image
 */
class DeleteDesignImageController extends AbstractDeleteImageController
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
            ]
        );

        $this->checkBlockOperation(
            BlockModel::TYPE_TEXT,
            $this->get('blockId'),
            Operation::TEXT_UPDATE_DESIGN
        );

        $this->delete($this->get('id'));

        return $this->getSimpleSuccessResult();
    }
}
