<?php

namespace ss\models\blocks\record\_content;

use ss\application\App;
use ss\application\components\db\Table;
use ss\application\components\helpers\Link;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\record\_base\AbstractRecordCloneModel;
use ss\models\blocks\record\RecordInstanceModel;
use ss\application\components\helpers\DateTime;

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
            ->ordered('sort', Table::DEFAULT_ALIAS, true)
            ->findAll();

        $link = new Link();

        $instances = '';
        foreach ($recordInstances as $recordInstance) {
            $cover = null;
            if ($this->get('hasCover') === true) {
                $imageInstance = $recordInstance->get('coverImageInstanceModel');
                if ($imageInstance !== null) {
                    $cover = [
                        'id'       => $imageInstance->getId(),
                        'alt'      => $imageInstance->get('alt'),
                        'viewUrl'  => $imageInstance->get('viewFileModel')->getUrl(),
                        'thumbUrl' => $imageInstance->get('thumbFileModel')->getUrl(),
                        'hasZoom'  => $this->get('hasCoverZoom'),
                    ];
                }
            }

            $date = DateTime::create($recordInstance->get('date'))
                ->getValue($this->get('dateType'));

            $description = '';
            if ($this->get('hasDescription') === true) {
                $description = $recordInstance
                    ->get('descriptionTextInstanceModel')
                    ->get('text');
            }

            $instances .= App::getInstance()->getView()->get(
                'content/record/cloneCard',
                [
                    'cover'       => $cover,
                    'name'        => $recordInstance->get('seoModel')->get('name'),
                    'date'        => $date,
                    'description' => $description,
                    'uri'         => $link->generateLink(
                        $recordInstance->get('seoModel')->get('alias'),
                        $sectionId
                    )
                ]
            );
        }

        $viewType = $this
            ->get('designRecordCloneModel')
            ->get('viewType');

        return App::getInstance()->getView()->get(
            'content/record/cloneList',
            [
                'blockId'     => $this->getBlockId(),
                'instances'   => $instances,
                'typeCss'     => $this
                    ->get('designRecordCloneModel')
                    ->getViewTypeCss($viewType),
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
                sprintf(
                    '.block-%s .record-card .description',
                    $this->getBlockId()
                )
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designRecordModel->get('descriptionDesignTextModel'),
                sprintf(
                    '.block-%s .record-card .description',
                    $this->getBlockId()
                )
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
        $table = $this->getTable()
            ->addSelect('id', 'sections', 'id')
            ->setTableName('records')
            ->addJoin(
                Table::JOIN_TYPE_INNER,
                'blocks',
                'blocks',
                'contentId',
                Table::DEFAULT_ALIAS,
                self::PK_FIELD
            )
            ->addJoin(
                Table::JOIN_TYPE_INNER,
                'grids',
                'grids',
                'blockId',
                'blocks',
                self::PK_FIELD
            )
            ->addJoin(
                Table::JOIN_TYPE_INNER,
                'gridLines',
                'gridLines',
                self::PK_FIELD,
                'grids',
                'gridLineId'
            )
            ->addJoin(
                Table::JOIN_TYPE_INNER,
                'sections',
                'sections',
                self::PK_FIELD,
                'gridLines',
                'sectionId'
            )
            ->addWhere(sprintf('%s.id = :recordId', Table::DEFAULT_ALIAS))
            ->addWhere('blocks.contentType = :contentType')
            ->addParameter('recordId', $this->get('recordId'))
            ->addParameter('contentType', BlockModel::TYPE_RECORD);

        $result = $table->find();
        if (is_array($result) === true
            && array_key_exists('id', $result) === true
        ) {
            return (int)$result['id'];
        }

        return 0;
    }
}
