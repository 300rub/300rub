<?php

namespace ss\controllers\menu;

use ss\application\exceptions\NotFoundException;
use ss\controllers\_abstract\AbstractBlockController;

/**
 * Gets block's content
 */
class GetContentController extends AbstractBlockController
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
            ]
        );

        //$blockId = (int)$this->get('blockId');

        return [
            'title'  => 'Menu',
            'labels' => [
                'button' => 'Save'
            ]
        ];
    }
}
