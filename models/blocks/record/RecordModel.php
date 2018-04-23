<?php

namespace ss\models\blocks\record;

use ss\application\App;
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
     * Page number
     *
     * @var int
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
     * Generates HTML
     *
     * @return string
     */
    public function generateHtml()
    {
        $this->_setParametersFromUri();

        if ($this->_recordUri !== null) {
            return $this->_getInstance();
        }

        return 'record list';
    }

    /**
     * Gets record instance
     *
     * @return string
     *
     * @throws NotFoundException
     */
    private function _getInstance()
    {
        $recordInstance = RecordInstanceModel::model()
            ->byUrl($this->_recordUri)
            ->byRecordId($this->getContentId())
            ->find();

        if ($recordInstance === null) {
            throw new NotFoundException(
                'Unable to find record instance ' .
                'with URI: {uri} and record ID: {recordId}',
                [
                    'uri'      => $this->_recordUri,
                    'recordId' => $this->getContentId()
                ]
            );
        }

        return App::getInstance()->getView()->get(
            'content/record/instance',
            [
                'blockId'           => $this->getBlockId(),
                'record'            => $this->getContentModel(),
                'designRecordModel' => $this->getContentModel()->get('designRecordModel'),
                'recordInstance'    => $recordInstance,
                'text'              => $recordInstance->get('textTextInstanceModel')->get('text'),
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
            && $this->getContentModel()->get('useAutoload') === false
        ) {
            $this->_page = $page;
            return $this;
        }

        $this->_recordUri = $url;
        return $this;
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
}
