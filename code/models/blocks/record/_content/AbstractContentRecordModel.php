<?php

namespace ss\models\blocks\record\_content;

use ss\application\App;
use ss\application\components\db\Table;
use ss\application\components\helpers\Link;
use ss\application\components\helpers\Pagination;
use ss\application\exceptions\NotFoundException;
use ss\models\blocks\record\_base\AbstractRecordModel;
use ss\models\blocks\record\RecordInstanceModel;
use ss\application\components\helpers\DateTime;

/**
 * Abstract model for working with table record content
 */
abstract class AbstractContentRecordModel extends AbstractRecordModel
{

    /**
     * Default page size
     */
    const DEFAULT_PAGE_SIZE = 10;

    /**
     * Page number
     *
     * @var integer
     */
    private $_page = 0;

    /**
     * Record URI
     *
     * @var string
     */
    private $_recordAlias = null;

    /**
     * Generates HTML
     *
     * @return string
     */
    public function generateHtml()
    {
        $this->_setParametersFromUri();

        if ($this->_recordAlias !== null) {
            $instance = $this->_getInstanceHtml();

            if ($instance !== null) {
                return $instance;
            }
        }

        return $this->_getListHtml();
    }

    /**
     * Generates CSS
     *
     * @return array
     */
    public function generateCss()
    {
        $css = [];

        $css = array_merge(
            $css,
            $this->_getFullCardCss()
        );

        $css = array_merge(
            $css,
            $this->_getShortCardCss()
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
        $jsList = [];
        $view = App::getInstance()->getView();

        if ($this->get('hasImages') === true) {
            $jsList = array_merge(
                $jsList,
                $this->get('imagesImageModel')->generateJsForContainer(
                    sprintf(
                        '.block-%s .full-card-images',
                        $this->getBlockId()
                    )
                )
            );
        }

        if ($this->get('useAutoload') === true) {
            $jsList = array_merge(
                $jsList,
                $view->generateJs(
                    'content/record/js/autoload',
                    sprintf('.block-%s', $this->getBlockId()),
                    [
                        'blockId' => $this->getBlockId()
                    ]
                )
            );
        }

        return $jsList;
    }

    /**
     * Gets records HTML
     *
     * @return string
     */
    private function _getListHtml()
    {
        $page = App::getInstance()
            ->getSite()
            ->getParameter($this->getBlockId(), 'page');

        $pagination = '';
        $useAutoload = $this->get('useAutoload');
        if ($useAutoload === false) {
            $pagination = $this->_getPagination();
        }

        return App::getInstance()->getView()->get(
            'content/record/list',
            [
                'typeCss'     => $this
                    ->get('designRecordModel')
                    ->getViewTypeCss($this->_getViewType()),
                'pagination'  => $pagination,

                'blockId'     => $this->getBlockId(),
                'instances'   => $this->getInstancesHtml(
                    $page,
                    App::getInstance()
                        ->getSite()
                        ->getActiveSection()
                        ->getId()
                ),

                'useAutoload' => $useAutoload,
            ]
        );
    }

    /**
     * Gets instances HTML
     *
     * @param int $page      Page number
     * @param int $sectionId Section ID
     *
     * @return string
     */
    public function getInstancesHtml($page, $sectionId)
    {
        $recordInstances = RecordInstanceModel::model()
            ->byRecordId($this->getId())
            ->limit(
                $this->_getPageNavigationSize(),
                $page
            )
            ->ordered('sort', Table::DEFAULT_ALIAS, true)
            ->findAll();

        $link = new Link();

        $html = '';
        foreach ($recordInstances as $recordInstance) {
            $cover = null;
            if ($this->get('hasCover') === true
                && $recordInstance->get('coverImageInstanceId') !== null
            ) {
                $imageInstance
                    = $recordInstance->get('coverImageInstanceModel');

                if ($imageInstance !== null) {
                    $cover = [
                        'id'       => $imageInstance->getId(),
                        'alt'      => $imageInstance->get('alt'),
                        'viewUrl'
                            => $imageInstance->get('viewFileModel')->getUrl(),
                        'thumbUrl'
                            => $imageInstance->get('thumbFileModel')->getUrl(),
                        'hasZoom'  => $this->get('hasCoverZoom'),
                    ];
                }
            }

            $date = DateTime::create($recordInstance->get('date'))
                ->getValue($this->get('shortCardDateType'));

            $description = '';
            if ($this->get('hasDescription') === true) {
                $description = $recordInstance
                    ->get('descriptionTextInstanceModel')
                    ->get('text');
            }

            $html .= App::getInstance()->getView()->get(
                'content/record/shortCard',
                [
                    'cover'       => $cover,
                    'name'
                        => $recordInstance->get('seoModel')->get('name'),
                    'date'        => $date,
                    'description' => $description,
                    'uri'         => $link->generateLink(
                        $recordInstance->get('seoModel')->get('alias'),
                        $sectionId
                    )
                ]
            );
        }

        return $html;
    }

    /**
     * Gets full card CSS
     *
     * @return array
     */
    private function _getFullCardCss()
    {
        $css = [];
        $view = App::getInstance()->getView();

        $designRecordModel = $this->get('designRecordModel');

        $css = array_merge(
            $css,
            $view->generateCss(
                $designRecordModel->get('fullCardContainerDesignBlockModel'),
                sprintf('.block-%s.full-card', $this->getBlockId())
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designRecordModel->get('fullCardTitleDesignBlockModel'),
                sprintf('.block-%s .full-card-title', $this->getBlockId())
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designRecordModel->get('fullCardTitleDesignTextModel'),
                sprintf('.block-%s .full-card-title', $this->getBlockId())
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designRecordModel->get('fullCardDateDesignBlockModel'),
                sprintf('.block-%s .full-card-date', $this->getBlockId())
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designRecordModel->get('fullCardDateDesignTextModel'),
                sprintf('.block-%s .full-card-date', $this->getBlockId())
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designRecordModel->get('fullCardTextDesignBlockModel'),
                sprintf('.block-%s .full-card-text', $this->getBlockId())
            )
        );

        if ($this->get('hasImages') === true) {
            $css = array_merge(
                $css,
                $this->get('imagesImageModel')->generateCssForContainer(
                    sprintf(
                        '.block-%s .full-card-images',
                        $this->getBlockId()
                    )
                )
            );
        }

        return $css;
    }

    /**
     * Gets full card CSS
     *
     * @return array
     */
    private function _getShortCardCss()
    {
        $css = [];
        $view = App::getInstance()->getView();

        $designRecordModel = $this->get('designRecordModel');

        $css = array_merge(
            $css,
            $view->generateCss(
                $designRecordModel->get('shortCardContainerDesignBlockModel'),
                sprintf('.block-%s.record-list', $this->getBlockId())
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designRecordModel->get('shortCardInstanceDesignBlockModel'),
                sprintf('.block-%s .record-card', $this->getBlockId())
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designRecordModel->get('shortCardTitleDesignBlockModel'),
                sprintf(
                    '.block-%s .record-card .short-card-title',
                    $this->getBlockId()
                )
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designRecordModel->get('shortCardTitleDesignTextModel'),
                sprintf(
                    '.block-%s .record-card .short-card-title',
                    $this->getBlockId()
                )
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designRecordModel->get('shortCardDateDesignBlockModel'),
                sprintf(
                    '.block-%s .record-card .short-card-date',
                    $this->getBlockId()
                )
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designRecordModel->get('shortCardDateDesignTextModel'),
                sprintf(
                    '.block-%s .record-card .short-card-date',
                    $this->getBlockId()
                )
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designRecordModel->get('shortCardDescriptionDesignBlockModel'),
                sprintf(
                    '.block-%s .record-card .short-card-description',
                    $this->getBlockId()
                )
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designRecordModel->get('shortCardDescriptionDesignTextModel'),
                sprintf(
                    '.block-%s .record-card .short-card-description',
                    $this->getBlockId()
                )
            )
        );

        $css = array_merge(
            $css,
            $this->_getShortCardPaginationCss()
        );

        return $css;
    }

    /**
     * Gets full card CSS
     *
     * @return array
     */
    private function _getShortCardPaginationCss()
    {
        $css = [];
        $view = App::getInstance()->getView();

        $designRecordModel = $this->get('designRecordModel');

        $css = array_merge(
            $css,
            $view->generateCss(
                $designRecordModel->get('shortCardPaginationDesignBlockModel'),
                sprintf('.block-%s .pagination', $this->getBlockId())
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designRecordModel->get(
                    'shortCardPaginationItemDesignBlockModel'
                ),
                sprintf('.block-%s .pagination a', $this->getBlockId())
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designRecordModel->get(
                    'shortCardPaginationItemDesignTextModel'
                ),
                sprintf('.block-%s .pagination a', $this->getBlockId())
            )
        );

        return $css;
    }

    /**
     * Gets pagination
     *
     * @return string
     */
    private function _getPagination()
    {
        $count = $this->_getCount();
        $site = App::getInstance()->getSite();
        $blockId = $this->getBlockId();
        $currentPage = $site->getParameter($blockId, 'page');
        $pageNavigationSize = $this->_getPageNavigationSize();

        $pagination = new Pagination();
        $pagination
            ->setBlockId($blockId)
            ->setCurrentPage($currentPage)
            ->setLastPage(ceil($count / $pageNavigationSize))
            ->setParameters($site->getParameter($blockId))
            ->setUri($site->getActiveSectionUri());

        return $pagination->getHtml();
    }

    /**
     * Gets records count
     *
     * @return int
     */
    private function _getCount()
    {
        return RecordInstanceModel::model()
            ->byRecordId($this->getId())
            ->getCount();
    }

    /**
     * Gets view type
     *
     * @return int
     */
    private function _getViewType()
    {
        return $this->get('designRecordModel')->get('shortCardViewType');
    }

    /**
     * Gets record instance HTML
     *
     * @return string
     *
     * @throws NotFoundException
     */
    private function _getInstanceHtml()
    {
        $recordInstance = RecordInstanceModel::model()
            ->byAlias($this->_recordAlias)
            ->byRecordId($this->getId())
            ->find();

        if ($recordInstance === null) {
            return null;
        }

        $imagesHtml = '';
        if ($this->get('hasImages') === true) {
            $imagesHtml = $this
                ->get('imagesImageModel')
                ->getImageInstancesHtml(
                    $recordInstance->get('imageGroupId')
                );
        }

        $date = DateTime::create($recordInstance->get('date'))
            ->getValue($this->get('fullCardDateType'));

        return App::getInstance()->getView()->get(
            'content/record/fullCard',
            [
                'blockId'    => $this->getBlockId(),
                'name'       => $recordInstance->get('seoModel')->get('name'),
                'data'       => $date,
                'imagesHtml' => $imagesHtml,
                'text'       => $recordInstance
                    ->get('textTextInstanceModel')
                    ->get('text'),

            ]
        );
    }

    /**
     * Sets parameters from URI
     *
     * @return AbstractContentRecordModel
     */
    private function _setParametersFromUri()
    {
        $parameter = App::getInstance()->getSite()->getUri(2);
        if ($parameter === null) {
            return $this;
        }

        $page = (int)$parameter;
        if ($parameter > 0
            && (string)$page === $parameter
            && $this->get('useAutoload') === false
        ) {
            $this->_page = $page;
            return $this;
        }

        $this->_recordAlias = $parameter;
        return $this;
    }

    /**
     * Gets default page size
     *
     * @return int
     */
    private function _getPageNavigationSize()
    {
        $size = $this->get('pageNavigationSize');

        if ($size === 0) {
            return self::DEFAULT_PAGE_SIZE;
        }

        return $size;
    }
}
