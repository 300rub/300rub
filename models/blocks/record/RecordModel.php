<?php

namespace ss\models\blocks\record;

use ss\application\App;
use ss\application\components\Pagination;
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
     * Date formats
     *
     * @var array
     */
    private $_dateFormats = [
        self::DATE_TYPE_COMMON => 'd/m/Y'
    ];

    /**
     * Gets cache type
     *
     * @return integer
     */
    public function getCacheType()
    {
        return self::NO_CACHE;
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
        $view = App::getInstance()->getView();

        $designRecordModel = $this->get('designRecordModel');

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
            ->findAll();

        return App::getInstance()->getView()->get(
            'content/record/instances',
            [
                'record'          => $this,
                'recordInstances' => $recordInstances,
                'urlBase'         => $urlBase
            ]
        );
    }

    /**
     * Gets pagination
     *
     * @return string
     */
    private function _getPagination()
    {
        $count = RecordInstanceModel::model()
            ->byRecordId($this->getId())
            ->getCount();
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

        $imagesHtml = '';
        if ($this->get('hasImages') === true) {
            $imagesHtml = $this
                ->get('imagesImageModel')
                ->getImageInstancesHtml(
                    $recordInstance->get('imageGroupId')
                );
        }

        return App::getInstance()->getView()->get(
            'content/record/instance',
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
     * Gets short card date format
     *
     * @return string
     */
    public function getShortCardDateFormat()
    {
        $type = $this->get('shortCardDateType');

        if (array_key_exists($type, $this->_dateFormats) === true) {
            return $this->_dateFormats[$type];
        }

        return $this->_dateFormats[self::DATE_TYPE_COMMON];
    }

    /**
     * Gets full card date format
     *
     * @return string
     */
    public function getFullCardDateFormat()
    {
        $type = $this->get('fullCardDateType');

        if (array_key_exists($type, $this->_dateFormats) === true) {
            return $this->_dateFormats[$type];
        }

        return $this->_dateFormats[self::DATE_TYPE_COMMON];
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
