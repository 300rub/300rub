<?php

namespace ss\controllers\section;

use ss\application\App;
use ss\application\components\db\Table;
use ss\application\components\user\Operation;
use ss\application\exceptions\NotFoundException;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\record\RecordCloneModel;
use ss\models\sections\GridLineModel;
use ss\models\sections\GridModel;
use ss\models\sections\SectionModel;

/**
 * Updates section structure
 */
class UpdateStructureController extends AbstractController
{

    /**
     * Runs controller
     *
     * @return array
     */
    public function run()
    {
        $this->checkSectionOperation(
            Operation::SECTION_UPDATE_CONTENT
        );

        $this->checkData(
            [
                'id'        => [self::TYPE_INT, self::NOT_EMPTY],
                'structure' => [self::TYPE_ARRAY],
            ]
        );



        return $this->getSimpleSuccessResult();
    }
}
