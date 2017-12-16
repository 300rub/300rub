<?php

namespace testS\models\blocks\block;

use testS\application\App;
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
class BlockModel extends AbstractBlockModel
{



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
     * Gets type names
     *
     * @return array
     */
    public static function getTypeNames()
    {
        return [
            self::TYPE_TEXT   => Language::t("text", "texts"),
            self::TYPE_IMAGE  => Language::t("image", "images"),
            self::TYPE_RECORD => Language::t("record", "records"),
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

        $model->set([
            "id" => $this->get("contentId")
        ]);

        return $model;
    }

    /**
     * Gets model by contentType and contentId
     *
     * @param bool   $withRelations
     * @param int    $value
     * @param string $instance
     *
     * @return AbstractModel
     *
     * @throws ModelException
     */
    public function getContentModel($withRelations = false, $value = null, $instance = null)
    {
        if ($value === null) {
            $value = $this->get("contentId");
        }

        if ($instance === null) {
            $instance = "testS\\models\\AbstractContentModel";
        } else {
            $instance = "testS\\models\\{$instance}";
        }

        $newModel = $this->_getNewContentModel();
        $model = $newModel->byId($value)->withRelations($withRelations)->find();
        if (!$model instanceof $instance) {
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
        if ($memcachedValue !== false) {
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