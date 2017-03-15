<?php

namespace testS\models;

use testS\components\Db;
use testS\components\exceptions\ModelException;
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
     * Type list
     *
     * @var array
     */
    public static $typeList = [
        self::TYPE_TEXT  => "TextModel",
        self::TYPE_IMAGE => "ImageModel"
    ];

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
            ->getContentModel($value)
            ->duplicate()
            ->getId();
    }

    /**
     * Gets model by contentType and contentId
     *
     * @param int $value
     *
     * @return AbstractModel
     *
     * @throws ModelException
     */
    public function getContentModel($value = null)
    {
        $className = "\\testS\\models\\" . self::$typeList[$this->get("contentType")];

        /**
         * @var AbstractModel $model
         */
        $model = new $className;
        if (!$model instanceof AbstractModel) {
            throw new ModelException(
                "Unable to find model: {className} with contentType = {contentType}",
                [
                    "className"   => $className,
                    "contentType" => $this->get("contentType")
                ]
            );
        }

        if ($value === null) {
            $value = $this->get("contentId");
        }
        $model = $model->byId($value)->withRelations()->find();
        if (!$model instanceof AbstractModel) {
            throw new ModelException(
                "Unable to find model: {className} with ID = {id}",
                [
                    "className" => $className,
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

        $this->getContentModel()->delete();
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
     * Finds by sectionId
     *
     * @param int $sectionId
     *
     * @return BlockModel
     */
    public function bySectionId($sectionId)
    {
        $sectionId = (int) $sectionId;
        if ($sectionId === 0) {
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
}