<?php

namespace testS\models;

use testS\applications\App;
use testS\components\Db;
use testS\components\exceptions\ModelException;
use testS\components\exceptions\NotFoundException;
use testS\components\Language;
use testS\components\Validator;
use testS\components\ValueGenerator;

/**
 * Model for working with table "blocks"
 *
 * @package testS\models
 *
 * @method BlockModel byId($id)
 * @method BlockModel withRelations()
 * @method BlockModel find()
 * @method BlockModel latest()
 * @method BlockModel[] findAll()
 * @method BlockModel duplicate()
 */
class BlockModel extends AbstractModel
{

    /**
     * Content types
     */
    const TYPE_TEXT = 1;
    const TYPE_IMAGE = 2;

    /**
     * URI
     *
     * @var string
     */
    private $_uri = "";

    /**
     * HTML
     *
     * @var string
     */
    private $_html = "";

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
     * Type list
     *
     * @var array
     */
    public static $typeList = [
        self::TYPE_TEXT  => "TextModel",
        self::TYPE_IMAGE => "ImageModel"
    ];

    /**
     * Gets type names
     *
     * @return array
     */
    public static function getTypeNames()
    {
        return [
            self::TYPE_TEXT  => Language::t("text", "texts"),
        ];
    }

    /**
     * Gets type name
     *
     * @param int $type
     *
     * @return string
     */
    public static function getTypeName($type)
    {
        $typeNames = self::getTypeNames();
        if (array_key_exists($type, $typeNames)) {
            return $typeNames[$type];
        }

        return "";
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "blocks";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "name"        => [
                self::FIELD_TYPE                => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION          => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 255
                ],
                self::FIELD_VALUE               => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
                self::FIELD_CHANGE_ON_DUPLICATE => [
                    ValueGenerator::COPY_NAME
                ],
            ],
            "language"    => [
                self::FIELD_TYPE                 => self::FIELD_TYPE_INT,
                self::FIELD_VALUE                => [
                    ValueGenerator::ARRAY_KEY => [Language::$aliasList, Language::getActiveId()]
                ],
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],
            "contentType" => [
                self::FIELD_TYPE                 => self::FIELD_TYPE_INT,
                self::FIELD_VALUE                => [
                    ValueGenerator::ARRAY_KEY => [self::$typeList]
                ],
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],
            "contentId"   => [
                self::FIELD_TYPE                 => self::FIELD_TYPE_INT,
                self::FIELD_BEFORE_SAVE          => ["setContentIdBeforeSave"],
                self::FIELD_BEFORE_DUPLICATE     => ["setContentIdBeforeDuplicate"],
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],
        ];
    }

    /**
     * Sets and checks content ID
     *
     * @param int $value
     *
     * @throws ModelException
     *
     * @return int
     */
    protected function setContentIdBeforeSave($value)
    {
        $value = (int)$value;

        if ($value === 0) {
            throw new ModelException("Unable to save BlockModel because contentId is null");
        }

        $this->getContentModel();

        return $value;
    }

    /**
     * Sets contentId before duplicate
     *
     * @param int $value
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
        $className = "\\testS\\models\\" . self::$typeList[$this->get("contentType")];

        $model = new $className;
        if (!$model instanceof AbstractContentModel) {
            throw new ModelException(
                "Unable to find model: {className} with contentType = {contentType}",
                [
                    "className"   => $className,
                    "contentType" => $this->get("contentType")
                ]
            );
        }

        return $model;
    }

    /**
     * Gets model by contentType and contentId
     *
     * @param bool $withRelations
     * @param int  $value
     *
     * @return AbstractModel
     *
     * @throws ModelException
     */
    public function getContentModel($withRelations = false, $value = null)
    {
        if ($value === null) {
            $value = $this->get("contentId");
        }

        $newModel = $this->_getNewContentModel();
        $model = $newModel->byId($value)->withRelations($withRelations)->find();
        if (!$model instanceof AbstractModel) {
            throw new ModelException(
                "Unable to find model: {className} with ID = {id}",
                [
                    "className" => get_class($newModel),
                    "id"        => $value
                ]
            );
        }

        return $model;
    }

    /**
     * Runs after deleting
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
     * @param int $contentType
     *
     * @return BlockModel
     */
    public function byContentType($contentType)
    {
        $this->getDb()->addWhere(sprintf("%s.contentType = :contentType", Db::DEFAULT_ALIAS));
        $this->getDb()->addParameter("contentType", $contentType);

        return $this;
    }

    /**
     * Finds by contentId
     *
     * @param int $contentId
     *
     * @return BlockModel
     */
    public function byContentId($contentId)
    {
        $this->getDb()->addWhere(sprintf("%s.contentId = :contentId", Db::DEFAULT_ALIAS));
        $this->getDb()->addParameter("contentId", $contentId);

        return $this;
    }

    /**
     * Finds by sectionId
     *
     * @param int $sectionId
     *
     * @return BlockModel
     */
    public function bySectionId($sectionId)
    {
        $sectionId = (int) $sectionId;
        if ($sectionId <= 0) {
            return $this;
        }

        $this->getDb()->addJoin(
            "grids",
            "grids",
            Db::DEFAULT_ALIAS,
            self::PK_FIELD,
            Db::JOIN_TYPE_INNER,
            "blockId"
        );

        $this->getDb()->addJoin(
            "gridLines",
            "gridLines",
            "grids",
            "gridLineId"
        );

        $this->getDb()->addWhere(sprintf("%s.sectionId = :sectionId", "gridLines"));
        $this->getDb()->addParameter("sectionId", $sectionId);

        return $this;
    }

    /**
     * Finds by language
     *
     * @param int $language
     *
     * @return BlockModel
     */
    public function byLanguage($language)
    {
        $this->getDb()->addWhere(sprintf("%s.language = :language", Db::DEFAULT_ALIAS));
        $this->getDb()->addParameter("language", $language);

        return $this;
    }

    /**
     * Sets URI
     *
     * @param string $uri
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
            ->setContentId($this->get("contentId"))
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
     * @param int $id
     *
     * @return string
     */
    private static function _getMemcachedKey($id)
    {
        return sprintf("block_%s", $id);
    }

    /**
     * Gets model by ID
     *
     * @param int $id
     *
     * @return BlockModel
     *
     * @throws NotFoundException
     */
    public static function getById($id)
    {
        $memcached = App::getInstance()->getMemcached();
        $memcachedKey = self::_getMemcachedKey($id);

        $memcachedValue = $memcached->get($memcachedKey);
        if ($memcachedValue instanceof BlockModel) {
            return $memcachedValue;
        }

        $model = (new BlockModel())->byId($id)->find();
        if ($model === null) {
            throw new NotFoundException("Unable to find block model by ID: {id}", ["id" => $id]);
        }

        $memcached->set($memcachedKey, $model);

        return $model;
    }
}