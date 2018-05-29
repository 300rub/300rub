<?php

namespace ss\models\blocks\record\_content;

use ss\application\App;
use ss\application\components\Db;
use ss\application\components\helpers\Link;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\record\_base\AbstractRecordCloneModel;
use ss\models\blocks\record\RecordInstanceModel;

/**
 * Model for working with table "recordClones"
 */
abstract class AbstractContentRecordCloneModel extends AbstractRecordCloneModel
{

    /**
     * Default page size
     */
    const DEFAULT_MAX_COUNT = 3;

    /**
     * Is fully cached
     *
     * @var bool
     */
    protected $isFullyCached = true;

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
     * Generates CSS
     *
     * @return array
     */
    public function generateCss()
    {
        $css = [];
        $view = App::getInstance()->getView();

        $designRecordModel = $this->get('designRecordCloneModel');

        $css = array_merge(
            $css,
            $view->generateCss(
                $designRecordModel->get('containerDesignBlockModel'),
                sprintf('.block-%s.record-list', $this->getBlockId())
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designRecordModel->get('instanceDesignBlockModel'),
                sprintf('.block-%s .record-card', $this->getBlockId())
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designRecordModel->get('titleDesignBlockModel'),
                sprintf('.block-%s .record-card .title', $this->getBlockId())
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designRecordModel->get('titleDesignTextModel'),
                sprintf('.block-%s .record-card .title', $this->getBlockId())
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designRecordModel->get('dateDesignBlockModel'),
                sprintf('.block-%s .record-card .date', $this->getBlockId())
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designRecordModel->get('dateDesignTextModel'),
                sprintf('.block-%s .record-card .date', $this->getBlockId())
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designRecordModel->get('descriptionDesignBlockModel'),
                sprintf('.block-%s .record-card .description', $this->getBlockId())
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designRecordModel->get('descriptionDesignTextModel'),
                sprintf('.block-%s .record-card .description', $this->getBlockId())
            )
        );

        return $css;
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
}
