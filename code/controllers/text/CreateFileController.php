<?php

namespace ss\controllers\text;

use ss\application\components\user\Operation;
use ss\application\exceptions\BadRequestException;
use ss\controllers\text\_abstract\AbstractCreateFileController;
use ss\models\blocks\block\BlockModel;

/**
 * Adds file
 */
class CreateFileController extends AbstractCreateFileController
{

    /**
     * Runs controller
     *
     * @return array
     *
     * @throws BadRequestException
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
            Operation::TEXT_UPDATE_CONTENT
        );

        $fileModel = $this->upload();

        return [
            'url' => $fileModel->getUrl()
        ];
    }
}
