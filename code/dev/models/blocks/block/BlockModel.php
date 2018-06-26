<?php

namespace ss\models\blocks\block;

use ss\application\App;
use ss\application\components\Db;
use ss\application\components\helpers\Link;
use ss\application\exceptions\NotFoundException;
use ss\models\_abstract\AbstractModel;
use ss\models\blocks\block\_base\AbstractBlockModel;

/**
 * Model for working with table "blocks"
 */
class BlockModel extends AbstractBlockModel
{

    /**
     * URI
     *
     * @var string
     */
    private $_uri = '';

    /**
     * HTML
     *
     * @var string
     */
    private $_html = '';

    /**
     * CSS
     *
     * @var array
     */
    private $_css = [];

    /**
     * JS
     *
     * @var array
     */
    private $_js = [];

    /**
     * Gets type names
     *
     * @return array
     */
    public function getTypeNames()
    {
        $language = App::getInstance()->getLanguage();

        return [
            self::TYPE_TEXT   => $language->getMessage('text', 'texts'),
            self::TYPE_IMAGE  => $language->getMessage('image', 'images'),
            self::TYPE_RECORD => $language->getMessage('record', 'records'),
        ];
    }

    /**
     * Gets type name
     *
     * @param int $type Type
     *
     * @return string
     */
    public function getTypeName($type)
    {
        $typeNames = self::getTypeNames();
        if (array_key_exists($type, $typeNames) === true) {
            return $typeNames[$type];
        }

        return '';
    }

    /**
     * Runs after deleting
     *
     * @return void
     */
    protected function afterDelete()
    {
        parent::afterDelete();

        App::getInstance()->getMemcached()->delete(
            self::_getMemcachedKey($this->getId())
        );

        $this->getContentModel()->delete();
    }

    /**
     * Runs after saving
     *
     * @return void
     */
    protected function afterSave()
    {
        parent::afterSave();

        App::getInstance()->getMemcached()->delete(
            $this->_getMemcachedKey($this->getId())
        );
    }

    /**
     * Finds by contentType
     *
     * @param int $contentType Content type
     *
     * @return BlockModel
     */
    public function byContentType($contentType)
    {
        $this->getDb()->addWhere(
            sprintf(
                '%s.contentType = :contentType',
                Db::DEFAULT_ALIAS
            )
        );
        $this->getDb()->addParameter('contentType', $contentType);

        return $this;
    }

    /**
     * Finds by contentId
     *
     * @param int $contentId Content ID
     *
     * @return BlockModel
     */
    public function byContentId($contentId)
    {
        $this->getDb()->addWhere(
            sprintf(
                '%s.contentId = :contentId',
                Db::DEFAULT_ALIAS
            )
        );
        $this->getDb()->addParameter('contentId', $contentId);

        return $this;
    }

    /**
     * Finds by sectionId
     *
     * @param int $sectionId Section ID
     *
     * @return BlockModel
     */
    public function bySectionId($sectionId)
    {
        $sectionId = (int)$sectionId;
        if ($sectionId <= 0) {
            return $this;
        }

        $this->getDb()->addJoin(
            Db::JOIN_TYPE_INNER,
            'grids',
            'grids',
            'blockId',
            Db::DEFAULT_ALIAS,
            self::PK_FIELD
        );

        $this->getDb()->addJoin(
            Db::JOIN_TYPE_INNER,
            'gridLines',
            'gridLines',
            self::PK_FIELD,
            'grids',
            'gridLineId'
        );

        $this->getDb()->addWhere(
            'gridLines.sectionId = :sectionId'
        );
        $this->getDb()->addParameter('sectionId', $sectionId);

        return $this;
    }

    /**
     * Finds by language
     *
     * @param int $language Language ID
     *
     * @return BlockModel
     */
    public function byLanguage($language)
    {
        $this->getDb()->addWhere(
            sprintf(
                '%s.language = :language',
                Db::DEFAULT_ALIAS
            )
        );
        $this->getDb()->addParameter('language', $language);

        return $this;
    }

    /**
     * Sets URI
     *
     * @param string $uri URI
     *
     * @return BlockModel
     */
    public function setUri($uri)
    {
        $this->_uri = $uri;
        return $this;
    }

    /**
     * Sets content
     *
     * @return BlockModel
     */
    public function setContent()
    {
        $model = $this->getNewContentModel();

        $model
            ->setBlockId($this->getId())
            ->setUri($this->_uri)
            ->generateContent();

        $this->_html = $model->getHtml();
        $this->_css = $model->getCss();
        $this->_js = $model->getJs();

        return $this;
    }

    /**
     * Gets HTML
     *
     * @return string
     */
    public function getHtml()
    {
        $link = new Link();
        return $link->parseLinks($this->_html);
    }

    /**
     * Gets CSS
     *
     * @return array
     */
    public function getCss()
    {
        return $this->_css;
    }

    /**
     * Gets JS
     *
     * @return array
     */
    public function getJs()
    {
        return $this->_js;
    }

    /**
     * Gets memcached key
     *
     * @param int $blockId Block ID
     *
     * @return string
     */
    private function _getMemcachedKey($blockId)
    {
        return sprintf('block_%s', $blockId);
    }

    /**
     * Gets model by ID
     *
     * @param int $blockId Block ID
     *
     * @return BlockModel|AbstractModel
     *
     * @throws NotFoundException
     */
    public function getById($blockId)
    {
        $memcached = App::getInstance()->getMemcached();
        $memcachedKey = $this->_getMemcachedKey($blockId);

        $memcachedValue = $memcached->get($memcachedKey);
        if ($memcachedValue !== false) {
            return $memcachedValue;
        }

        $model = self::model()->byId($blockId)->find();
        if ($model === null) {
            throw new NotFoundException(
                'Unable to find block model by ID: {id}',
                [
                    'id' => $blockId
                ]
            );
        }

        $memcached->set($memcachedKey, $model);

        return $model;
    }

    /**
     * Gets latest block model
     *
     * @return null|AbstractModel|BlockModel
     */
    public function getLatest()
    {
        return self::model()->latest()->find();
    }

    /**
     * Gets BlockModel
     *
     * @return BlockModel
     */
    public static function model()
    {
        return new self;
    }
}