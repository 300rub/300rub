<?php

namespace testS\models;

use testS\components\Db;
use testS\components\Language;
use testS\components\ValueGenerator;

/**
 * Model for working with table "sections"
 *
 * @method SectionModel byId($id)
 * @method SectionModel find()
 * @method SectionModel withRelations()
 *
 * @package testS\models
 */
class SectionModel extends AbstractModel
{

    /**
     * Default page with in px
     */
    const DEFAULT_WIDTH = 980;

    /**
     * Structure
     *
     * @var array
     */
    private $_structure = [];

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "sections";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "seoId"         => [
                self::FIELD_RELATION => "SeoModel"
            ],
            "designBlockId" => [
                self::FIELD_RELATION => "DesignBlockModel"
            ],
            "language"      => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [Language::$aliasList, Language::getActiveId()]
                ],
            ],
            "isMain"        => [
                self::FIELD_TYPE             => self::FIELD_TYPE_BOOL,
                self::FIELD_SKIP_DUPLICATION => true,
                self::FIELD_BEFORE_SAVE      => ["generateIsMain"]
            ],
        ];
    }

    /**
     * Adds isMain = 1 condition to SQL request
     *
     * @param int $language
     *
     * @return UserModel
     */
    public function main($language = null)
    {
        if ($language === null) {
            $language = Language::getActiveId();
        }

        $this->getDb()->addWhere(sprintf("%s.isMain = :isMain", Db::DEFAULT_ALIAS));
        $this->getDb()->addWhere(sprintf("%s.language = :language", Db::DEFAULT_ALIAS));
        $this->getDb()->addParameter("isMain", 1);
        $this->getDb()->addParameter("language", $language);

        return $this;
    }

    /**
     * Generates isMain
     *
     * @param bool $value
     *
     * @return bool
     */
    protected function generateIsMain($value)
    {
        if ($value !== true) {
            return false;
        }

        return $this->main($this->get("language"))->find() === null;
    }

    /**
     * Sets section CSS
     *
     * @return SectionModel
     */
    public function setCss()
    {
        $this->addCss(
            $this->get("designBlockModel"),
            sprintf(".section-%s", $this->getId())
        );

        return $this;
    }

    /**
     * Sets structure, CSS, JS
     *
     * @return SectionModel
     */
    public function setStructureAndStatic()
    {
        if (!$this->get("designBlockModel") instanceof DesignBlockModel) {
            return $this;
        }

        $this->setCss();

        $gridLineIds = [];
        $gridLineModels = (new GridLineModel)
            ->withRelations()
            ->bySectionId($this->getId())
            ->ordered("sort")
            ->findAll();

        if (!$gridLineModels) {
            return $this;
        }

        foreach ($gridLineModels as $gridLineModel) {
            $gridLineIds[] = $gridLineModel->getId();
            $gridLineModel->setCss();
        }

//        $gridModels = (new GridModel)
//            ->in("gridLineId", $gridLineIds)
//            ->ordered(["y", "x"])
//            ->findAll();
//        $lines = [];
//
//        foreach ($gridLineModels as $gridLineModel) {
//            $grids = [];
//
//            foreach ($gridModels as $gridModel) {
//                if ($gridModel->get("gridLineId") === $gridLineModel->getId()) {
//                    $grids[] = $gridModel;
//                }
//            }
//
//            $lines[$gridLineModel->get("sort")] = [
//                "line"  => $gridLineModel,
//                "grids" => $grids
//            ];
//        }
//
//        foreach ($lines as $sort => $data) {
//            $structure["lines"][$sort] = [
//                "line"  => $data["line"],
//                "grids" => $this->_getLineStructure($data["grids"])
//            ];
//        }

        return $this;
    }

    /**
     * Gets line structure
     *
     * @param GridModel[] $grids Grid models
     *
     * @return array
     */
//    private function _getLineStructure($grids)
//    {
//        $structure = [];
//
//        $doubleGrid = [];
//        for ($i = 0; $i < GridModel::GRID_SIZE * 2; $i++) {
//            $doubleGrid[$i] = 0;
//        }
//        foreach ($grids as $grid) {
//            $x = $grid->get("x");
//            for ($i = $x * 2; $i < ($x + $grid->get("width")) * 2 - 1; $i++) {
//                $doubleGrid[$i] = 1;
//            }
//        }
//
//        $borders = [];
//        $flag = 0;
//        foreach ($doubleGrid as $x => $val) {
//            if ($val != $flag) {
//                $borders[] = $x;
//                $flag = $val;
//            }
//        }
//
//        if (!$borders) {
//            return $structure;
//        }
//
//        for ($i = 0; $i < count($borders); $i = $i + 2) {
//            if ($i) {
//                $offset = ($borders[$i] - $borders[$i - 1] - 1) / 2;
//            } else {
//                $offset = $borders[$i] / 2;
//            }
//
//            $gridsList = [];
//            $right = 0;
//            $prevY = 0;
//            foreach ($grids as $grid) {
//                $x = $grid->get("x");
//                $y = $grid->get("y");
//                $width = $grid->get("width");
//
//                if (
//                    $x >= $borders[$i] / 2
//                    && $x < $borders[$i + 1] / 2
//                    && $width <= ($borders[$i + 1] - $borders[$i] + 1) / 2
//                ) {
//                    if ($y > $prevY) {
//                        $right = 0;
//                    }
//                    $gridsList[] = [
//                        "model"  => $grid->getContentModel(),
//                        "view"   => $grid->getContentView(),
//                        "class"  => $grid->getBlockClass(),
//                        "col"    => $width,
//                        "y"      => $y,
//                        "offset" => $x - $borders[$i] / 2 - $right,
//                    ];
//                    $prevY = $y;
//                    $right = $x - $borders[$i] / 2 + $width;
//                }
//            }
//
//            $structure[] = [
//                "col"    => ($borders[$i + 1] - $borders[$i] + 1) / 2,
//                "offset" => $offset,
//                "grids"  => $gridsList,
//            ];
//        }
//
//        return $structure;
//    }
}