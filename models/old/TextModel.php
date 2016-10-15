<?php

namespace testS\models;

use testS\components\exceptions\ModelException;
use testS\components\Language;

/**
 * Model for working with table "texts"
 *
 * @property int $type
 *
 * @method TextModel[] findAll
 * @method TextModel ordered
 * @method TextModel byId($id)
 * @method TextModel find
 * @method TextModel withAll
 *
 * @package testS\models
 */
class TextModel extends AbstractModel
{

	/**
	 * Types
	 */
	const TYPE_DIV = 0;
	const TYPE_H1 = 1;
	const TYPE_H2 = 2;
	const TYPE_H3 = 3;
	const TYPE_ADDRESS = 4;
	const TYPE_MARK = 5;

    /**
     * List of tag type values
     *
     * @var array
     */
    public static $typeTagList = [
        self::TYPE_DIV     => "div",
        self::TYPE_H1      => "h1",
        self::TYPE_H2      => "h2",
        self::TYPE_H3      => "h3",
        self::TYPE_ADDRESS => "adress",
        self::TYPE_MARK    => "mark",
    ];

    /**
     * Gets model object
     *
     * @return TextModel
     */
    public static function model()
    {
        $className = __CLASS__;
        return new $className;
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "texts";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    protected function getFieldsInfo()
    {
        return [
            "name"        => [
                self::FIELD_TYPE                => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION          => ["required", "max" => 255],
                self::FIELD_SET                 => ["clearStripTags"],
                self::FIELD_CHANGE_ON_DUPLICATE => "getCopyName",
            ],
            "language"        => [
                self::FIELD_TYPE                => self::FIELD_TYPE_INT,
                self::FIELD_SET                 => ["setLanguage"],
            ],
            "isEditor"        => [
                self::FIELD_TYPE                => self::FIELD_TYPE_BOOL,
            ],
            "type"        => [
                self::FIELD_TYPE                => self::FIELD_TYPE_INT,
                self::FIELD_SET                 => ["setType"],
            ],
            "text"        => [
                self::FIELD_TYPE                => self::FIELD_TYPE_STRING,
            ],
        ];
    }

	/**
	 * ID of DesignTextModel
	 *
	 * @var int
	 */
	public $designTextId;

	/**
	 * ID of DesignTextModel
	 *
	 * @var int
	 */
	public $designBlockId;

	/**
	 * Design text model
	 *
	 * @var DesignTextModel
	 */
	public $designTextModel;

	/**
	 * Design block model
	 *
	 * @var DesignBlockModel
	 */
	public $designBlockModel;

	/**
	 * Relations
	 *
	 * @var array
	 */
	protected $relations = [
		"designTextModel"  => ['testS\models\DesignTextModel', "designTextId"],
		"designBlockModel" => ['testS\models\DesignBlockModel', "designBlockId"]
	];

	/**
	 * Gets type list
	 *
	 * @return array
	 */
	public static function getTypeList()
	{
		return [
			self::TYPE_DIV     => Language::t("text", "typeDefault"),
			self::TYPE_H1      => Language::t("text", "typeH1"),
			self::TYPE_H2      => Language::t("text", "typeH2"),
			self::TYPE_H3      => Language::t("text", "typeH3"),
			self::TYPE_ADDRESS => Language::t("text", "typeAddress"),
			self::TYPE_MARK    => Language::t("text", "typeImportant"),
		];
	}

	/**
	 * Gets tag name
	 *
	 * @return string
	 */
	public function getTag()
	{
		if (array_key_exists($this->type, self::$typeTagList)) {
			return self::$typeTagList[$this->type];
		}

		return self::$typeTagList[self::TYPE_DIV];
	}

    /**
     * Sets type
     *
     * @param int $value
     *
     * @return int
     */
    protected function setType($value)
    {
        if (!array_key_exists($value, self::$typeTagList)) {
            $value = self::TYPE_DIV;
        }

        return $value;
    }

	/**
	 * Sets values
	 */
	protected function setValues()
	{
		$this->designTextId = intval($this->designTextId);
		$this->designBlockId = intval($this->designBlockId);
	}

	/**
	 * Runs before save
	 */
	protected function beforeSave()
	{
		if (!$this->designTextModel instanceof DesignTextModel) {
			if ($this->designTextId === 0) {
				$this->designTextModel = new DesignTextModel();
			} else {
				$this->designTextModel = DesignTextModel::model()->byId($this->designTextId)->find();
				if ($this->designTextModel === null) {
					$this->designTextModel = new DesignTextModel();
				}
			}
		}

		if (!$this->designBlockModel instanceof DesignBlockModel) {
			if ($this->designBlockId === 0) {
				$this->designBlockModel = new DesignBlockModel();
			} else {
				$this->designBlockModel = DesignBlockModel::model()->byId($this->designBlockId)->find();
				if ($this->designBlockModel === null) {
					$this->designBlockModel = new DesignBlockModel();
				}
			}
		}

		parent::beforeSave();
	}

	/**
	 * Runs before delete
	 *
	 * @throws ModelException
	 */
	protected function beforeDelete()
	{
		$designTextModel = $this->designTextModel;
		if ($designTextModel === null) {
			$designTextModel = DesignTextModel::model()->byId($this->designTextId)->find();
		}
		if ($designTextModel instanceof DesignTextModel) {
			if (!$designTextModel->delete()) {
				throw new ModelException(
					"Unable to delete DesignTextModel model with ID = {id}",
					[
						"id" => $designTextModel->id
					]
				);
			}
		}

		$designBlockModel = $this->designBlockModel;
		if ($designBlockModel === null) {
			$designBlockModel = DesignBlockModel::model()->byId($this->designBlockId)->find();
		}
		if ($designBlockModel instanceof DesignBlockModel) {
			if (!$designBlockModel->delete()) {
				throw new ModelException(
					"Unable to delete DesignBlockModel model with ID = {id}",
					[
						"id" => $designBlockModel->id
					]
				);
			}
		}

		parent::beforeDelete();
	}
}