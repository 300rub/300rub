<?php

namespace ss\models\blocks\record;

use ss\application\App;
use ss\application\components\Db;
use ss\models\blocks\record\_base\AbstractRecordCloneModel;

/**
 * Model for working with table "recordClones"
 */
class RecordCloneModel extends AbstractRecordCloneModel
{

    /**
     * Class name
     */
    const CLASS_NAME = '\\ss\\models\\blocks\\record\\RecordCloneModel';

    /**
     * Default page size
     */
    const DEFAULT_MAX_COUNT = 3;

    /**
     * Generates HTML
     *
     * @return string
     */
    public function generateHtml()
    {
        $recordInstances = RecordInstanceModel::model()
            ->byRecordId($this->get('recordId'))
            ->limit($this->_getMaxCount())
            ->ordered('sort', Db::DEFAULT_ALIAS, true)
            ->findAll();

        return App::getInstance()->getView()->get(
            'content/record/clone',
            [
                'blockId'     => $this->getBlockId(),
                'instances'   => $recordInstances,
                'viewType'    => $this
                    ->get('designRecordCloneModel')
                    ->get('viewType')
            ]
        );
    }

    /**
     * Generates CSS
     *
     * @return array
     */
    public function generateCss()
    {
        return [];
    }

    /**
     * Generates JS
     *
     * @return array
     */
    public function generateJs()
    {
        return [];
    }

    /**
     * Gets new model
     *
     * @return RecordCloneModel
     */
    public static function model()
    {
        return new self;
    }

    /**
     * Gets max count
     *
     * @return int
     */
    private function _getMaxCount()
    {
        $maxCount = $this->get('maxCount');

        if ($maxCount === 0) {
            return self::DEFAULT_MAX_COUNT;
        }

        return $maxCount;
    }
}
