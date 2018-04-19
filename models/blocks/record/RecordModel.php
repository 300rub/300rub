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
     * Generates HTML
     *
     * @return string
     */
    public function generateHtml()
    {
        $this->_setParametersFromUri();

        if ($this->_recordUri !== null) {
            return $this->_getRecord();
        }

        return 'record list';
    }

    /**
     * Gets record
     *
     * @return string
     *
     * @throws NotFoundException
     */
    private function _getRecord()
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

        return 'record';
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
     * Gets RecordModel
     *
     * @return RecordModel
     */
    public static function model()
    {
        return new self;
    }
}
