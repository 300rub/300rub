<?php

namespace ss\models\blocks\record;

use ss\application\App;
use ss\application\components\Db;
use ss\application\components\helpers\Link;
use ss\models\blocks\block\BlockModel;
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
        $sectionId = $this->_getSectionId();
        if ($sectionId === 0) {
            return '';
        }

        $recordInstances = RecordInstanceModel::model()
            ->byRecordId($this->get('recordId'))
            ->limit($this->_getMaxCount())
            ->ordered('sort', Db::DEFAULT_ALIAS, true)
            ->findAll();

        $link = new Link();

        $instances = '';
        foreach ($recordInstances as $recordInstance) {
            $instances .= App::getInstance()->getView()->get(
                'content/record/cloneCard',
                [
                    'recordClone'    => $this,
                    'recordInstance' => $recordInstance,
                    'url'            => $link->generateLink(
                        $recordInstance->get('seoModel')->get('url'),
                        $sectionId
                    )
                ]
            );
        }

        return App::getInstance()->getView()->get(
            'content/record/cloneList',
            [
                'blockId'     => $this->getBlockId(),
                'instances'   => $instances,
                'viewType'    => $this
                    ->get('designRecordCloneModel')
                    ->get('viewType')
            ]
        );
    }

    /**
     * Gets section ID
     *
     * @return int
     */
    private function _getSectionId()
    {
        $dbObject = App::getInstance()->getDb();

        $dbObject
            ->addSelect('id', 'sections', 'id');
        $dbObject
            ->setTable('records');
        $dbObject
            ->addJoin(
                Db::JOIN_TYPE_INNER,
                'blocks',
                'blocks',
                'contentId',
                Db::DEFAULT_ALIAS,
                self::PK_FIELD
            )
            ->addJoin(
                Db::JOIN_TYPE_INNER,
                'grids',
                'grids',
                'blockId',
                'blocks',
                self::PK_FIELD
            )
            ->addJoin(
                Db::JOIN_TYPE_INNER,
                'gridLines',
                'gridLines',
                self::PK_FIELD,
                'grids',
                'gridLineId'
            )
            ->addJoin(
                Db::JOIN_TYPE_INNER,
                'sections',
                'sections',
                self::PK_FIELD,
                'gridLines',
                'sectionId'
            );
        $dbObject
            ->addWhere(sprintf('%s.id = :recordId', Db::DEFAULT_ALIAS))
            ->addWhere('blocks.contentType = :contentType');
        $dbObject
            ->addParameter('recordId', $this->get('recordId'))
            ->addParameter('contentType', BlockModel::TYPE_RECORD);

        $result = $dbObject->find();
        if (is_array($result) === true
            && array_key_exists('id', $result) === true
        ) {
            return (int)$result['id'];
        }

        return 0;
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
