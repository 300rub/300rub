<?php

namespace testS\models;

use testS\components\exceptions\ContentException;
use testS\components\exceptions\ModelException;
use testS\components\Language;

/**
 * Model for working with table "grids"
 *
 * @package testS\models
 *
 * @property int           $gridLineId
 * @property int           $width
 * @property int           $x
 * @property int           $y
 * @property int           $contentType
 * @property int           $contentId
 * @property GridLineModel $gridLineModel
 *
 * @method GridModel[] findAll()
 * @method GridModel   in($field, $values)
 * @method GridModel   with($array)
 * @method GridModel   ordered($value)
 */
class GridModel extends AbstractModel
{

    /**
     * Grid size
     */
    const GRID_SIZE = 12;

    /**
     * Default width
     */
    const DEFAULT_WIDTH = 3;

    /**
     * Content types. Text
     */
    const TYPE_TEXT = 1;

    /**
     * Content types. Image
     */
    const TYPE_IMAGE = 2;

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "grids";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    protected function getFieldsInfo()
    {
        return [
            "x"           => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["max" => self::GRID_SIZE - 1, "min" => 0]
            ],
            "y"           => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["min" => 0]
            ],
            "width"       => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => [
                    "minThen" => [0, self::DEFAULT_WIDTH],
                    "max"     => [self::GRID_SIZE, "{x}", "-"]
                ],
            ],
            "contentType" => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "contentId"   => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "gridLineId"  => [
                self::FIELD_RELATION => [
                    self::FIELD_RELATION_MODEL => "GridLineModel",
                    self::FIELD_RELATION_NAME  => "gridLineModel",
                    self::FIELD_RELATION_TYPE  => self::FIELD_RELATION_TYPE_HAS_ONE
                ]
            ],
        ];
    }

    /**
     * Adds order by line & y & x to SQL request
     *
     * @return GridModel
     */
    public function orderedWithLines()
    {
        $this->getDb()->setOrder("gridLineModel.sort, y, x");
        return $this;
    }

    /**
     * Gets structure
     *
     * @param SectionModel $section Section model
     *
     * @return array
     */
    public function getStructure(SectionModel $section)
    {
        $structure["width"] = $section->getWidth();

        $gridLineIds = [];
        $gridLineModels = (new GridLineModel)
            ->withRelations()
            ->bySectionId($section->id)
            ->ordered("sort")
            ->findAll();

        if (!$gridLineModels) {
            return [];
        }

        foreach ($gridLineModels as $gridLineModel) {
            $gridLineIds[] = $gridLineModel->id;
        }
        $gridModels = (new GridModel)->in("t.gridLineId", $gridLineIds)->ordered("y, x")->findAll();
        $lines = [];

        foreach ($gridLineModels as $gridLineModel) {
            $grids = [];
            foreach ($gridModels as $gridModel) {
                if ($gridModel->gridLineId == $gridLineModel->id) {
                    $grids[] = $gridModel;
                }
            }
            $lines[$gridLineModel->sort] = [
                "line"  => $gridLineModel,
                "grids" => $grids
            ];
        }

        foreach ($lines as $sort => $data) {
            $structure["lines"][$sort] = [
                "line"  => $data["line"],
                "grids" => $this->_getLineStructure($data["grids"])
            ];
        }

        return $structure;
    }

    /**
     * Gets line structure
     *
     * @param GridModel[] $grids Grid models
     *
     * @return array
     */
    private function _getLineStructure($grids)
    {
        $structure = [];

        $doubleGrid = [];
        for ($i = 0; $i < self::GRID_SIZE * 2; $i++) {
            $doubleGrid[$i] = 0;
        }
        foreach ($grids as $grid) {
            for ($i = $grid->x * 2; $i < ($grid->x + $grid->width) * 2 - 1; $i++) {
                $doubleGrid[$i] = 1;
            }
        }

        $borders = [];
        $flag = 0;
        foreach ($doubleGrid as $x => $val) {
            if ($val != $flag) {
                $borders[] = $x;
                $flag = $val;
            }
        }

        if (!$borders) {
            return $structure;
        }

        for ($i = 0; $i < count($borders); $i = $i + 2) {
            if ($i) {
                $offset = ($borders[$i] - $borders[$i - 1] - 1) / 2;
            } else {
                $offset = $borders[$i] / 2;
            }

            $gridsList = [];
            $right = 0;
            $prevY = 0;
            foreach ($grids as $grid) {
                if (
                    $grid->x >= $borders[$i] / 2
                    && $grid->x < $borders[$i + 1] / 2
                    && $grid->width <= ($borders[$i + 1] - $borders[$i] + 1) / 2
                ) {
                    if ($grid->y > $prevY) {
                        $right = 0;
                    }
                    $gridsList[] = [
                        "model"  => $grid->getContentModel(),
                        "view"   => $grid->getContentView(),
                        "class"  => $grid->getBlockClass(),
                        "col"    => $grid->width,
                        "y"      => $grid->y,
                        "offset" => $grid->x - $borders[$i] / 2 - $right,
                    ];
                    $prevY = $grid->y;
                    $right = $grid->x - $borders[$i] / 2 + $grid->width;
                }
            }

            $structure[] = [
                "col"    => ($borders[$i + 1] - $borders[$i] + 1) / 2,
                "offset" => $offset,
                "grids"  => $gridsList,
            ];
        }

        return $structure;
    }

    /**
     * Adds section ID to SQL request
     *
     * @param int $sectionId Section ID
     *
     * @return GridModel
     */
    public function bySectionId($sectionId)
    {
        $this->withRelations();
        $this->getDb()->addWhere("gridLineModel.sectionId = :sectionId");
        $this->getDb()->addParameter("sectionId", $sectionId);

        return $this;
    }

    /**
     * Adds line ID to SQL request
     *
     * @param int $lineId Line ID
     *
     * @return GridModel
     */
    public function byLineId($lineId)
    {
        $this->getDb()->addWhere("gridLineId = :lineId");
        $this->getDb()->addParameter("lineId", $lineId);

        return $this;
    }

    /**
     * Adds type to SQL request
     *
     * @param int $type Type
     *
     * @return GridModel
     */
    public function byType($type)
    {
        $this->getDb()->addWhere("contentType = :type");
        $this->getDb()->addParameter("type", $type);

        return $this;
    }

    /**
     * Gets all grids for sections structure window
     *
     * @param int $sectionId Section ID
     *
     * @return array
     */
    public function getAllGridsForGridWindow($sectionId)
    {
        $list = [];
        $typeList = self::getTypesList();

        $grids = $this->bySectionId($sectionId)->orderedWithLines()->findAll();
        foreach ($grids as $grid) {
            /**
             * @var object $model
             */
            $modelName = "\\models\\" . $typeList[$grid->contentType]["model"];
            $model = new $modelName;
            $model = $model->byId($grid->contentId)->find();
            $list[intval($grid->gridLineModel->sort)]["id"] = $grid->gridLineModel->id;
            $list[intval($grid->gridLineModel->sort)]["grids"][] = [
                "id"    => $grid->contentId,
                "x"     => $grid->x,
                "y"     => $grid->y,
                "width" => $grid->width,
                "type"  => $grid->contentType,
                "name"  => $model->name,
            ];
        }

        return $list;
    }

    /**
     * Updates grid'd structure for section
     *
     * @param int   $sectionId Section ID
     * @param array $data      Structure data
     *
     * @throws ContentException
     * @throws ModelException
     */
    public function updateGridForSection($sectionId, $data)
    {
        $oldGrids = $this->bySectionId($sectionId)->findAll();
        $gridLines = (new GridLineModel)->bySectionId($sectionId)->findAll();
        $oldGridLines = [];
        foreach ($gridLines as $gridLine) {
            $oldGridLines[$gridLine->id] = $gridLine;
        }

        $lineNumber = 1;
        foreach ($data as $content) {
            if (!empty($content["id"])) {
                $gridLineModel = (new GridLineModel)->byId($content["id"])->find();
                if (!$gridLineModel) {
                    throw new ContentException(
                        "Unable to find GridLineModel with ID = {id}",
                        [
                            "id" => $content["id"]
                        ]
                    );
                }

                $gridLineModel->sort = $lineNumber;
                if (!$gridLineModel->save()) {
                    throw new ModelException("Unable to save GridLineModel");
                }

                if (array_key_exists($content["id"], $oldGridLines)) {
                    unset($oldGridLines[$content["id"]]);
                }
            } else {
                $gridLineModel = new GridLineModel();
                $gridLineModel->sectionId = $sectionId;
                $gridLineModel->sort = $lineNumber;
                if (!$gridLineModel->save()) {
                    throw new ModelException("Unable to save GridLineModel");
                }
            }

            if (isset($content["items"]) && !is_array($content["items"])) {
                throw new ContentException("Unable to find items from content or items are not array");
            }

            foreach ($content["items"] as $item) {
                $model = new self;
                $model->gridLineId = $gridLineModel->id;
                $model->x = $item["x"];
                $model->y = $item["y"];
                $model->width = $item["width"];
                $model->contentType = $item["type"];
                $model->contentId = $item["id"];
                if (!$model->save()) {
                    throw new ModelException("Unable to save GridModel");
                }
            }

            $lineNumber++;
        }

        foreach ($oldGrids as $grid) {
            $grid->delete();
        }

        /**
         * @var \testS\models\GridLineModel[] $oldGridLines
         */
        foreach ($oldGridLines as $oldGridLine) {
            $oldGridLine->delete();
        }
    }

    /**
     * Gets content types list
     *
     * @return array
     */
    public static function getTypesList()
    {
        return [
            self::TYPE_TEXT => [
                "name"     => Language::t("text", "text"),
                "model"    => "TextModel",
                "view"     => "text",
                "selector" => "j-text-",
                "with"     => ["designTextModel"]
            ]
        ];
    }

    /**
     * Gets content model
     *
     * @return AbstractModel
     *
     * @throws ModelException
     */
    public function getContentModel()
    {
        $typeList = self::getTypesList();

        if (!array_key_exists($this->contentType, $typeList)) {
            throw new ModelException(
                "Unable to find content model. Type is undefined: {type}",
                [
                    "type" => $this->contentType
                ]
            );
        }

        /**
         * @var AbstractModel $model
         */
        $modelName = '\\testS\\models\\' . $typeList[$this->contentType]["model"];
        $model = new $modelName;
        $model = $model->byId($this->contentId)->withRelations()->find();

        if (!$model) {
            throw new ModelException(
                "Unable to find content model {modelName} by ID {id}",
                [
                    "modelName" => $modelName,
                    "id"        => $this->contentId
                ]
            );
        }

        return $model;
    }

    /**
     * Gets content view
     *
     * @return string
     *
     * @throws ModelException
     */
    public function getContentView()
    {
        $typeList = self::getTypesList();

        if (!array_key_exists($this->contentType, $typeList)) {
            throw new ModelException(
                "Unable to find content model. Type is undefined: {type}",
                [
                    "type" => $this->contentType
                ]
            );
        }

        return 'content.' . $typeList[$this->contentType]["view"];
    }

    /**
     * Gets block class
     *
     * @return string
     *
     * @throws ModelException
     */
    public function getBlockClass()
    {
        $typeList = self::getTypesList();

        if (!array_key_exists($this->contentType, $typeList)) {
            throw new ModelException(
                "Unable to find content model. Type is undefined: {type}",
                [
                    "type" => $this->contentType
                ]
            );
        }

        return $typeList[$this->contentType]["selector"] . $this->contentId;
    }

    /**
     * Gets all blocks for sections window structure
     *
     * @return array
     */
    public function getAllBlocksForGridWindow()
    {
        $list = [];
        $typeList = self::getTypesList();

        $models = (new TextModel)->ordered()->findAll();
        if ($models) {
            $list[] = [
                "name"       => $typeList[self::TYPE_TEXT]["name"],
                "isDisabled" => true,
                "type"       => 0,
                "id"         => 0,
            ];
            foreach ($models as $model) {
                $list[] = [
                    "name"       => $model->name,
                    "isDisabled" => false,
                    "type"       => self::TYPE_TEXT,
                    "id"         => $model->id,
                ];
            }
        }

        return $list;
    }

    /**
     * Runs before save
     *
     * @throws ModelException
     */
    protected function beforeSave()
    {
        if ($this->contentType === 0 || $this->contentId === 0) {
            throw new ModelException("Unable to save GridModel because contentType or contentId is null");
        }

        $typeList = self::getTypesList();
        if (!array_key_exists($this->contentType, $typeList)) {
            throw new ModelException(
                "Unable to find content model. Type is undefined: {type}",
                [
                    "type" => $this->contentType
                ]
            );
        }

        $className = "\\testS\\models\\" . $typeList[$this->contentType]["model"];
        $model = new $className;
        if (!$model instanceof AbstractModel
            || !$model->byId($this->contentId)->find()
        ) {
            throw new ModelException(
                "Unable to find model: {className} with ID = {id}",
                [
                    "className" => $className,
                    "id"        => $this->contentId
                ]
            );
        }

        parent::beforeSave();
    }
}