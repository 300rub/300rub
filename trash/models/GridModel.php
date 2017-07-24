<?php
//
//* @property int           $gridLineId
//* @property int           $width
//* @property int           $x
//* @property int           $y
//    @property GridLineModel $gridLineModel

//
///**
// * Adds order by line & y & x to SQL request
// *
// * @return GridModel
// */
//public function orderedWithLines()
//{
//    $this->getDb()->setOrder("gridLineModel.sort, y, x");
//    return $this;
//}
//
//
///**
// * Gets line structure
// *
// * @param GridModel[] $grids Grid models
// *
// * @return array
// */
//private function _getLineStructure($grids)
//{
//    $structure = [];
//
//    $doubleGrid = [];
//    for ($i = 0; $i < self::GRID_SIZE * 2; $i++) {
//        $doubleGrid[$i] = 0;
//    }
//    foreach ($grids as $grid) {
//        for ($i = $grid->x * 2; $i < ($grid->x + $grid->width) * 2 - 1; $i++) {
//            $doubleGrid[$i] = 1;
//        }
//    }
//
//    $borders = [];
//    $flag = 0;
//    foreach ($doubleGrid as $x => $val) {
//        if ($val != $flag) {
//            $borders[] = $x;
//            $flag = $val;
//        }
//    }
//
//    if (!$borders) {
//        return $structure;
//    }
//
//    for ($i = 0; $i < count($borders); $i = $i + 2) {
//        if ($i) {
//            $offset = ($borders[$i] - $borders[$i - 1] - 1) / 2;
//        } else {
//            $offset = $borders[$i] / 2;
//        }
//
//        $gridsList = [];
//        $right = 0;
//        $prevY = 0;
//        foreach ($grids as $grid) {
//            if (
//                $grid->x >= $borders[$i] / 2
//                && $grid->x < $borders[$i + 1] / 2
//                && $grid->width <= ($borders[$i + 1] - $borders[$i] + 1) / 2
//            ) {
//                if ($grid->y > $prevY) {
//                    $right = 0;
//                }
//                $gridsList[] = [
//                    "model"  => $grid->getContentModel(),
//                    "view"   => $grid->getContentView(),
//                    "class"  => $grid->getBlockClass(),
//                    "col"    => $grid->width,
//                    "y"      => $grid->y,
//                    "offset" => $grid->x - $borders[$i] / 2 - $right,
//                ];
//                $prevY = $grid->y;
//                $right = $grid->x - $borders[$i] / 2 + $grid->width;
//            }
//        }
//
//        $structure[] = [
//            "col"    => ($borders[$i + 1] - $borders[$i] + 1) / 2,
//            "offset" => $offset,
//            "grids"  => $gridsList,
//        ];
//    }
//
//    return $structure;
//}
//
///**
// * Adds section ID to SQL request
// *
// * @param int $sectionId Section ID
// *
// * @return GridModel
// */
//public function bySectionId($sectionId)
//{
//    $this->withRelations();
//    $this->getDb()->addWhere("gridLineModel.sectionId = :sectionId");
//    $this->getDb()->addParameter("sectionId", $sectionId);
//
//    return $this;
//}
//
///**
// * Adds line ID to SQL request
// *
// * @param int $lineId Line ID
// *
// * @return GridModel
// */
//public function byLineId($lineId)
//{
//    $this->getDb()->addWhere("gridLineId = :lineId");
//    $this->getDb()->addParameter("lineId", $lineId);
//
//    return $this;
//}
//
///**
// * Adds type to SQL request
// *
// * @param int $type Type
// *
// * @return GridModel
// */
//public function byType($type)
//{
//    $this->getDb()->addWhere("contentType = :type");
//    $this->getDb()->addParameter("type", $type);
//
//    return $this;
//}
//
///**
// * Gets all grids for sections structure window
// *
// * @param int $sectionId Section ID
// *
// * @return array
// */
//public function getAllGridsForGridWindow($sectionId)
//{
//    $list = [];
//    $typeList = self::getTypesList();
//
//    $grids = $this->bySectionId($sectionId)->orderedWithLines()->findAll();
//    foreach ($grids as $grid) {
//        /**
//         * @var object $model
//         */
//        $modelName = "\\models\\" . $typeList[$grid->contentType]["model"];
//        $model = new $modelName;
//        $model = $model->byId($grid->contentId)->find();
//        $list[intval($grid->gridLineModel->sort)]["id"] = $grid->gridLineModel->id;
//        $list[intval($grid->gridLineModel->sort)]["grids"][] = [
//            "id"    => $grid->contentId,
//            "x"     => $grid->x,
//            "y"     => $grid->y,
//            "width" => $grid->width,
//            "type"  => $grid->contentType,
//            "name"  => $model->name,
//        ];
//    }
//
//    return $list;
//}
//
///**
// * Updates grid'd structure for section
// *
// * @param int   $sectionId Section ID
// * @param array $data      Structure data
// *
// * @throws ContentException
// * @throws ModelException
// */
//public function updateGridForSection($sectionId, $data)
//{
//    $oldGrids = $this->bySectionId($sectionId)->findAll();
//    $gridLines = (new GridLineModel)->bySectionId($sectionId)->findAll();
//    $oldGridLines = [];
//    foreach ($gridLines as $gridLine) {
//        $oldGridLines[$gridLine->id] = $gridLine;
//    }
//
//    $lineNumber = 1;
//    foreach ($data as $content) {
//        if (!empty($content["id"])) {
//            $gridLineModel = (new GridLineModel)->byId($content["id"])->find();
//            if (!$gridLineModel) {
//                throw new ContentException(
//                    "Unable to find GridLineModel with ID = {id}",
//                    [
//                        "id" => $content["id"]
//                    ]
//                );
//            }
//
//            $gridLineModel->sort = $lineNumber;
//            if (!$gridLineModel->save()) {
//                throw new ModelException("Unable to save GridLineModel");
//            }
//
//            if (array_key_exists($content["id"], $oldGridLines)) {
//                unset($oldGridLines[$content["id"]]);
//            }
//        } else {
//            $gridLineModel = new GridLineModel();
//            $gridLineModel->sectionId = $sectionId;
//            $gridLineModel->sort = $lineNumber;
//            if (!$gridLineModel->save()) {
//                throw new ModelException("Unable to save GridLineModel");
//            }
//        }
//
//        if (isset($content["items"]) && !is_array($content["items"])) {
//            throw new ContentException("Unable to find items from content or items are not array");
//        }
//
//        foreach ($content["items"] as $item) {
//            $model = new self;
//            $model->gridLineId = $gridLineModel->id;
//            $model->x = $item["x"];
//            $model->y = $item["y"];
//            $model->width = $item["width"];
//            $model->contentType = $item["type"];
//            $model->contentId = $item["id"];
//            if (!$model->save()) {
//                throw new ModelException("Unable to save GridModel");
//            }
//        }
//
//        $lineNumber++;
//    }
//
//    foreach ($oldGrids as $grid) {
//        $grid->delete();
//    }
//
//    /**
//     * @var \testS\models\GridLineModel[] $oldGridLines
//     */
//    foreach ($oldGridLines as $oldGridLine) {
//        $oldGridLine->delete();
//    }
//}
//
//
//
///**
// * Gets content model
// *
// * @return AbstractModel
// *
// * @throws ModelException
// */
//public function getContentModel()
//{
//    $typeList = self::getTypesList();
//
//    if (!array_key_exists($this->contentType, $typeList)) {
//        throw new ModelException(
//            "Unable to find content model. Type is undefined: {type}",
//            [
//                "type" => $this->contentType
//            ]
//        );
//    }
//
//    /**
//     * @var AbstractModel $model
//     */
//    $modelName = '\\testS\\models\\' . $typeList[$this->contentType]["model"];
//    $model = new $modelName;
//    $model = $model->byId($this->contentId)->withRelations()->find();
//
//    if (!$model) {
//        throw new ModelException(
//            "Unable to find content model {modelName} by ID {id}",
//            [
//                "modelName" => $modelName,
//                "id"        => $this->contentId
//            ]
//        );
//    }
//
//    return $model;
//}
//
///**
// * Gets content view
// *
// * @return string
// *
// * @throws ModelException
// */
//public function getContentView()
//{
//    $typeList = self::getTypesList();
//
//    if (!array_key_exists($this->contentType, $typeList)) {
//        throw new ModelException(
//            "Unable to find content model. Type is undefined: {type}",
//            [
//                "type" => $this->contentType
//            ]
//        );
//    }
//
//    return 'content.' . $typeList[$this->contentType]["view"];
//}
//
///**
// * Gets block class
// *
// * @return string
// *
// * @throws ModelException
// */
//public function getBlockClass()
//{
//    $typeList = self::getTypesList();
//
//    if (!array_key_exists($this->contentType, $typeList)) {
//        throw new ModelException(
//            "Unable to find content model. Type is undefined: {type}",
//            [
//                "type" => $this->contentType
//            ]
//        );
//    }
//
//    return $typeList[$this->contentType]["selector"] . $this->contentId;
//}
//
///**
// * Gets all blocks for sections window structure
// *
// * @return array
// */
//public function getAllBlocksForGridWindow()
//{
//    $list = [];
//    $typeList = self::getTypesList();
//
//    $models = (new TextModel)->ordered()->findAll();
//    if ($models) {
//        $list[] = [
//            "name"       => $typeList[self::TYPE_TEXT]["name"],
//            "isDisabled" => true,
//            "type"       => 0,
//            "id"         => 0,
//        ];
//        foreach ($models as $model) {
//            $list[] = [
//                "name"       => $model->name,
//                "isDisabled" => false,
//                "type"       => self::TYPE_TEXT,
//                "id"         => $model->id,
//            ];
//        }
//    }
//
//    return $list;
//}