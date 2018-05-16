<?php

namespace ss\models\blocks\record;

use ss\application\App;
use ss\application\components\Db;
use ss\application\components\helpers\Pagination;
use ss\application\exceptions\NotFoundException;
use ss\models\blocks\record\_base\AbstractRecordModel;

/**
 * Model for working with table "records"
 */
class RecordModel extends AbstractRecordModel
{

    /**
     * Class name
     */
    const CLASS_NAME = '\\ss\\models\\blocks\\record\\RecordModel';

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
    private $_recordUri = null;

    /**
     * Gets HTML Memcached short card key
     *
     * @param int $instanceId Record instance ID
     *
     * @return string
     */
    private function _getHtmlMemcachedShortCardKey($instanceId)
    {
        return sprintf('record_short_card_%s', $instanceId);
    }

    /**
     * Gets HTML Memcached full card key
     *
     * @param int $instanceId Record instance ID
     *
     * @return string
     */
    private function _getHtmlMemcachedFullCardKey($instanceId)
    {
        return sprintf('record_full_card_%s', $instanceId);
    }

    /**
     * Gets record count Memcached key
     *
     * @param int $recordId Record ID
     *
     * @return string
     */
    private function _getRecordCountMemcachedKey($recordId)
    {
        return sprintf('record_%s_count', $recordId);
    }

    /**
     * Gets view type Memcached key
     *
     * @param int $recordId Record ID
     *
     * @return string
     */
    private function _getViewTypeMemcachedKey($recordId)
    {
        return sprintf('record_%s_view_type', $recordId);
    }

    /**
     * Generates HTML
     *
     * @return string
     */
    public function generateHtml()
    {
        $this->_setParametersFromUri();

        if ($this->_recordUri !== null) {
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
                sprintf('.block-%s .record-card .short-card-title', $this->getBlockId())
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designRecordModel->get('shortCardTitleDesignTextModel'),
                sprintf('.block-%s .record-card .short-card-title', $this->getBlockId())
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designRecordModel->get('shortCardDateDesignBlockModel'),
                sprintf('.block-%s .record-card .short-card-date', $this->getBlockId())
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designRecordModel->get('shortCardDateDesignTextModel'),
                sprintf('.block-%s .record-card .short-card-date', $this->getBlockId())
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designRecordModel->get('shortCardDescriptionDesignBlockModel'),
                sprintf('.block-%s .record-card .short-card-description', $this->getBlockId())
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designRecordModel->get('shortCardDescriptionDesignTextModel'),
                sprintf('.block-%s .record-card .short-card-description', $this->getBlockId())
            )
        );

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
                $designRecordModel->get('shortCardPaginationItemDesignBlockModel'),
                sprintf('.block-%s .pagination a', $this->getBlockId())
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $designRecordModel->get('shortCardPaginationItemDesignTextModel'),
                sprintf('.block-%s .pagination a', $this->getBlockId())
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
                'blockId'     => $this->getBlockId(),
                'instances'   => $this->getInstancesHtml(
                    $page,
                    App::getInstance()->getSite()->getActiveSectionUri()
                ),
                'pagination'  => $pagination,
                'useAutoload' => $useAutoload,
                'viewType'    => $this->_getViewType()
            ]
        );
    }

    /**
     * Gets instances HTML
     *
     * @param int    $page    Page number
     * @param string $urlBase URL base
     *
     * @return string
     */
    public function getInstancesHtml($page, $urlBase)
    {
        $recordInstances = RecordInstanceModel::model()
            ->byRecordId($this->getId())
            ->limit(
                $this->_getPageNavigationSize(),
                $page
            )
            ->ordered('sort', Db::DEFAULT_ALIAS, true)
            ->findAll();

        $html = '';
        foreach ($recordInstances as $recordInstance) {
            $cacheValue = $this->getHtmlMemcached(
                $this->_getHtmlMemcachedShortCardKey(
                    $recordInstance->getId()
                )
            );
            if ($cacheValue !== false) {
                $html .= $cacheValue;
                continue;
            }

            $record = App::getInstance()->getView()->get(
                'content/record/shortCard',
                [
                    'record'         => $this,
                    'recordInstance' => $recordInstance,
                    'urlBase'        => $urlBase
                ]
            );

            $this->setHtmlMemcached(
                $this->_getHtmlMemcachedShortCardKey(
                    $recordInstance->getId()
                ),
                $record
            );

            $html .= $record;
        }

        return $html;
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
            ->setUrl($site->getActiveSectionUri());

        return $pagination->getHtml();
    }

    /**
     * Gets records count
     *
     * @return int
     */
    private function _getCount()
    {
        $cacheValue = $this->getHtmlMemcached(
            $this->_getRecordCountMemcachedKey(
                $this->getId()
            )
        );
        if ($cacheValue !== false) {
            return $cacheValue;
        }

        $count = RecordInstanceModel::model()
            ->byRecordId($this->getId())
            ->getCount();

        $this->setHtmlMemcached(
            $this->_getRecordCountMemcachedKey(
                $this->getId()
            ),
            $count
        );

        return $count;
    }

    /**
     * Gets view type
     *
     * @return int
     */
    private function _getViewType()
    {
        $cacheValue = $this->getHtmlMemcached(
            $this->_getViewTypeMemcachedKey(
                $this->getId()
            )
        );
        if ($cacheValue !== false) {
            return $cacheValue;
        }

        $viewType = $this->get('designRecordModel')->get('shortCardViewType');

        $this->setHtmlMemcached(
            $this->_getViewTypeMemcachedKey(
                $this->getId()
            ),
            $viewType
        );

        return $viewType;
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
            ->byUrl($this->_recordUri)
            ->byRecordId($this->getId())
            ->find();

        if ($recordInstance === null) {
            return null;
        }

        $cacheValue = $this->getHtmlMemcached(
            $this->_getHtmlMemcachedFullCardKey(
                $recordInstance->getId()
            )
        );
        if ($cacheValue !== false) {
            return $cacheValue;
        }

        $imagesHtml = '';
        if ($this->get('hasImages') === true) {
            $imagesHtml = $this
                ->get('imagesImageModel')
                ->getImageInstancesHtml(
                    $recordInstance->get('imageGroupId')
                );
        }

        $html = App::getInstance()->getView()->get(
            'content/record/fullCard',
            [
                'blockId'           => $this->getBlockId(),
                'record'            => $this,
                'designRecordModel' => $this->get('designRecordModel'),
                'recordInstance'    => $recordInstance,
                'text'              => $recordInstance
                    ->get('textTextInstanceModel')
                    ->get('text'),
                'imagesHtml'        => $imagesHtml,
            ]
        );

        $this->setHtmlMemcached(
            $this->_getHtmlMemcachedFullCardKey(
                $recordInstance->getId()
            ),
            $html
        );

        return $html;
    }

    /**
     * Sets parameters from URI
     *
     * @return RecordModel
     */
    private function _setParametersFromUri()
    {
        $url = App::getInstance()->getSite()->getUri(2);
        if ($url === null) {
            return $this;
        }

        $page = (int)$url;
        if ($url > 0
            && (string)$page === $url
            && $this->get('useAutoload') === false
        ) {
            $this->_page = $page;
            return $this;
        }

        $this->_recordUri = $url;
        return $this;
    }

    /**
     * Gets RecordModel
     *
     * @return RecordModel
     */
    public static function model()
    {
        return new self;
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
