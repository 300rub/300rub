<?php

namespace ss\models\blocks\block\_base;

use ss\application\App;
use ss\application\components\Validator;

use ss\application\exceptions\ModelException;
use ss\models\_abstract\AbstractModel;
use ss\models\blocks\_abstract\AbstractContentModel;
use ss\models\blocks\image\ImageModel;
use ss\models\blocks\menu\MenuModel;
use ss\models\blocks\record\RecordCloneModel;
use ss\models\blocks\record\RecordModel;
use ss\models\blocks\text\TextModel;

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
    const TYPE_MENU = 5;

    /**
     * Type list
     *
     * @var array
     */
    public static $typeList = [
        self::TYPE_TEXT         => TextModel::CLASS_NAME,
        self::TYPE_IMAGE        => ImageModel::CLASS_NAME,
        self::TYPE_RECORD       => RecordModel::CLASS_NAME,
        self::TYPE_RECORD_CLONE => RecordCloneModel::CLASS_NAME,
        self::TYPE_MENU         => MenuModel::CLASS_NAME,
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
            ->getContentModel(null, $value)
            ->duplicate()
            ->getId();
    }

    /**
     * Gets model by contentType and contentId
     *
     * @param string $instance Instance to check
     * @param int    $value    Content ID
     *
     * @return AbstractContentModel|AbstractModel
     *
     * @throws ModelException
     */
    public function getContentModel(
        $instance = null,
        $value = null
    ) {
        if ($value === null) {
            $value = $this->get('contentId');
        }

        if ($instance === null) {
            $instance
                = 'ss\\models\\blocks\\_abstract\\AbstractContentModel';
        }

        $newModel = $this->getNewContentModel();
        $model = $newModel->byId($value)->find();
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
