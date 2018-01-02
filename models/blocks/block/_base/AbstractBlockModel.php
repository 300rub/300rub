<?php

namespace testS\models\blocks\block\_base;

use testS\application\App;
use testS\application\components\Validator;
use testS\application\components\ValueGenerator;
use testS\application\exceptions\ModelException;
use testS\models\_abstract\AbstractModel;
use testS\models\blocks\_abstract\AbstractContentModel;

/**
 * Abstract model for working with table "blocks"
 */
abstract class AbstractBlockModel extends AbstractModel
{

    /**
     * Content types
     */
    const TYPE_TEXT = 1;
    const TYPE_IMAGE = 2;
    const TYPE_RECORD = 3;
    const TYPE_RECORD_CLONE = 4;

    /**
     * Type list
     *
     * @var array
     */
    public static $typeList = [
        self::TYPE_TEXT
            => '\\testS\\models\\blocks\\text\\TextModel',
        self::TYPE_IMAGE
            => '\\testS\\models\\blocks\\image\\ImageModel',
        self::TYPE_RECORD
            => '\\testS\\models\\blocks\\record\\RecordModel',
        self::TYPE_RECORD_CLONE
            => '\\testS\\models\\blocks\\record\\RecordCloneModel',
    ];

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'blocks';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        $language = App::getInstance()->getLanguage();

        return [
            'name'        => [
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
            'language'    => [
                self::FIELD_TYPE                 => self::FIELD_TYPE_INT,
                self::FIELD_VALUE                => [
                    ValueGenerator::ARRAY_KEY => [
                        $language->getAliasList(),
                        $language->getActiveId()
                    ]
                ],
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],
            'contentType' => [
                self::FIELD_TYPE                 => self::FIELD_TYPE_INT,
                self::FIELD_VALUE                => [
                    ValueGenerator::ARRAY_KEY => [self::$typeList]
                ],
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],
            'contentId'   => [
                self::FIELD_TYPE                 => self::FIELD_TYPE_INT,
                self::FIELD_BEFORE_SAVE          => [
                    'setContentIdBeforeSave'
                ],
                self::FIELD_BEFORE_DUPLICATE     => [
                    'setContentIdBeforeDuplicate'
                ],
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],
        ];
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

        $newModel = $this->getNewContentModel();
        $model = $newModel->byId($value);

        if ($withRelations === true) {
            $model->withRelations();
        }

        $model = $model->find();
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
     * Gets new content model
     *
     * @return AbstractContentModel
     *
     * @throws ModelException
     */
    protected function getNewContentModel()
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
}
