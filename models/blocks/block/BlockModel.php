<?php

namespace testS\models\blocks\block;

use testS\application\App;
use testS\application\components\Db;
use testS\application\exceptions\ModelException;
use testS\application\exceptions\NotFoundException;
use testS\models\_abstract\AbstractModel;
use testS\models\blocks\_abstract\AbstractContentModel;

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
    public static function getTypeNames()
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
    public static function getTypeName($type)
    {
        $typeNames = self::getTypeNames();
        if (array_key_exists($type, $typeNames) === true) {
            return $typeNames[$type];
        }

        return '';
    }

    /**
     * Sets and checks content ID
     *
     * @param int $value Content ID
     *
     * @throws ModelException
     *
     * @return int
     */
    protected function setContentIdBeforeSave($value)
    {
        $value = (int)$value;

        if ($value === 0) {
            throw new ModelException(
                'Unable to save BlockModel because contentId is null'
            );
        }

        $this->getContentModel();

        return $value;
    }

    /**
     * Sets contentId before duplicate
     *
     * @param int $value Content ID
     *
     * @return int
     *
     * @throws ModelException
     */
    protected function setContentIdBeforeDuplicate($value)
    {
        return $this
            ->getContentModel(true, $value)
            ->duplicate()
            ->getId();
    }

    /**
     * Gets new content model
     *
     * @return AbstractContentModel
     *
     * @throws ModelException
     */
    private function _getNewContentModel()
    {
        $className = self::$typeList[$this->get('contentType')];

        $model = $this->getModelByName($className);
        if ($model instanceof AbstractContentModel === false) {
            throw new ModelException(
                'Unable to find model: {className} ' .
                'with contentType = {contentType}',
                [
                    'className'   => $className,
                    'contentType' => $this->get('contentType')
                ]
            );
        }

        $model->set(
            [
            'id' => $this->get('contentId')
            ]
        );

        return $model;
    }

    /**
     * Gets model by contentType and contentId
     *
     * @param bool   $withRelations Flag to use relations
     * @param int    $value         Content ID
     * @param string $instance      Instance to check
     *
     * @return AbstractContentModel|AbstractModel
     *
     * @throws ModelException
     */
    public function getContentModel(
        $withRelations = null,
        $value = null,
        $instance = null
    ) {
        if ($value === null) {
            $value = $this->get('contentId');
        }

        if ($instance === null) {
            $instance
                = 'testS\\models\\blocks\\_abstract\\AbstractContentModel';
        }

        $newModel = $this->_getNewContentModel();
        $model = $newModel->byId($value);

        if ($withRelations === true) {
            $model->withRelations();
        }

        $model->find();
        if ($model instanceof $instance === false) {
            throw new ModelException(
                'Unable to find model: {className} with ID = {id}',
                [
                    'className' => get_class($newModel),
                    'id'        => $value
                ]
            );
        }

        return $model;
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
            self::_getMemcachedKey($this->getId())
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
            'grids',
            'grids',
            Db::DEFAULT_ALIAS,
            self::PK_FIELD,
            Db::JOIN_TYPE_INNER,
            'blockId'
        );

        $this->getDb()->addJoin(
            'gridLines',
            'gridLines',
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
        $model = $this->_getNewContentModel();

        $model
            ->setBlockId($this->getId())
            ->setUri($this->_uri)
            ->setContentId($this->get('contentId'))
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
        return $this->_html;
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
    private static function _getMemcachedKey($blockId)
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
    public static function getById($blockId)
    {
        $memcached = App::getInstance()->getMemcached();
        $memcachedKey = self::_getMemcachedKey($blockId);

        $memcachedValue = $memcached->get($memcachedKey);
        if ($memcachedValue !== false) {
            return $memcachedValue;
        }

        $model = new BlockModel();
        $model = $model->byId($blockId)->find();
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
}
