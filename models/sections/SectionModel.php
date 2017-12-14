<?php

namespace testS\models;

use testS\components\Db;
use testS\components\Language;
use testS\components\ValueGenerator;
use testS\components\View;

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
     * Array of y => grids
     *
     * @var array
     */
    private $_yGrids = [];

    /**
     * Array of possible borders
     *
     * @var array
     */
    private $_yPossibleBorders = [];

    /**
     * Stricture
     *
     * @var array
     */
    private $_structure = [];

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
     * @return SectionModel
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
     * Generates section CSS
     *
     * @return array
     */
    private function _generateCss()
    {
        return View::generateCss(
            $this->get("designBlockModel"),
            sprintf(".section-%s", $this->getId())
        );
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

        $this->_css = $this->_generateCss();

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
            $this->_css = array_merge(
                $this->_css,
                $gridLineModel->generateCss()
            );
        }

        $gridModels = (new GridModel)
            ->in("gridLineId", $gridLineIds)
            ->ordered(["y", "x"])
            ->findAll();

        foreach ($gridLineModels as $gridLineModel) {
            $lineGrids = [];

            foreach ($gridModels as $gridModel) {
                if ($gridModel->get("gridLineId") === $gridLineModel->getId()) {
                    $lineGrids[] = $gridModel;
                }
            }

            $this
                ->_setyGrids($lineGrids)
                ->_setPossibleYBorders($lineGrids);

            $this->_structure[$gridLineModel->getId()] = $this->_getLineStructure();
        }

        return $this;
    }

    /**
     * Gets structure
     *
     * @return array
     */
    public function getStructure()
    {
        return $this->_structure;
    }

    /**
     * Sets array of grids compacted by Y
     *
     * @param GridModel[] $grids
     *
     * @return SectionModel
     */
    private function _setyGrids($grids)
    {
        foreach ($grids as $grid) {
            $this->_yGrids[$grid->get("y")][] = $grid;
        }

        return $this;
    }

    /**
     * Sets possible borders for Y line
     *
     * @param GridModel[] $grids
     *
     * @return SectionModel
     */
    private function _setPossibleYBorders($grids)
    {
        $borders = [];
        $currentY = 0;
        $last = 0;

        foreach ($grids as $grid) {
            $y = $grid->get("y");
            if ($y > $currentY) {
                $currentY = $y;
            }

            $x = $grid->get("x");
            $width = $grid->get("width");
            $end = $x + $width;
            $borders[$currentY][] = $x;
            $borders[$currentY][] = $end;

            if ($x > $last) {
                for ($i = $last; $i < $x; $i++) {
                    $borders[$currentY][] = $i;
                }
            }

            $last = $end;
        }

        foreach ($borders as $y => $values) {
            $values = array_unique($values);
            sort($values);

            $last = $values[count($values) - 1];

            if ($last < GridModel::GRID_SIZE) {
                for ($i = $last + 1; $i <= GridModel::GRID_SIZE; $i++) {
                    $values[] = $i;
                }
            }

            $this->_yPossibleBorders[$y] = $values;
        }

        return $this;
    }

    /**
     * Gets line structure
     *
     * @param int $top
     * @param int $bottom
     * @param int $left
     * @param int $right
     *
     * @return array
     */
    private function _getLineStructure($top = 0, $bottom = 999, $left = 0, $right = GridModel::GRID_SIZE)
    {
        $usedYLines = [];
        $structure = [];
        $containerWidth = $right - $left;

        $bordersInfo = $this->_getSameBordersInfo($top, $bottom, $left, $right);
        foreach ($bordersInfo as $count => $countData) {
            foreach ($countData as $data) {
                $y = $data["y"];

                if (in_array($y, $usedYLines)) {
                    continue;
                }

                $currentLines = [];
                $yLast = $y + $count - 1;
                for ($i = $y; $i <= $yLast; $i++) {
                    $currentLines[] = $i;
                }
                $usedYLines = array_merge($usedYLines, $currentLines);

                $possibleBorders = $data["borders"];

                /**
                 * @var GridModel[] $grids
                 */
                $borders = [];
                foreach ($possibleBorders as $possibleBorder) {
                    foreach ($this->_yGrids as $gridY => $grids) {
                        if (!in_array($gridY, $currentLines)
                            || in_array($possibleBorder, $borders)
                        ) {
                            continue;
                        }

                        foreach ($grids as $grid) {
                            $gridX = $grid->get("x");
                            $gridWidth = $grid->get("width");
                            if ($gridX === $possibleBorder
                                || $gridX + $gridWidth === $possibleBorder
                            ) {
                                $borders[] = $possibleBorder;
                            }
                        }
                    }
                }

                $structureData = [];
                sort($borders);
                for ($i = 0; $i < count($borders) - 1; $i++) {
                    $x = $borders[$i];
                    $width = $borders[$i + 1] - $x;

                    if ($width > 0) {
                        $structureData[] = [
                            "type"  => "container",
                            "x"     => $x,
                            "left"  => 100 / $containerWidth * ($x - $left),
                            "width" => $width,
                        ];
                    }
                }

                if (count($structureData) === 1) {
                    $left = $structureData[0]["x"];
                    $right = $structureData[0]["x"] + $structureData[0]["width"];
                    $containerGrids = $this->_getContainerBlocks($y, $yLast, $left, $right);

                    if (count($containerGrids) > 0) {
                        $structureData = $containerGrids;
                    } else {
                        continue;
                    }
                } else {
                    foreach ($structureData as $key => &$container) {
                        $left = $container["x"];
                        $right = $container["x"] + $container["width"];
                        $data = $this->_getLineStructure($y, $yLast, $left, $right);

                        if (count($data) === 0) {
                            unset($structureData[$key]);
                        } else {
                            $container["data"] = $data;
                        }
                    }
                }

                if (count($structureData) > 0) {
                    $structure[$y] = $structureData;
                }
            }
        }

        ksort($structure);

        return $structure;
    }

    /**
     * Gets blocks from container
     *
     * @param int $top
     * @param int $bottom
     * @param int $left
     * @param int $right
     *
     * @return array
     */
    private function _getContainerBlocks($top, $bottom, $left, $right)
    {
        $blocks = [];
        $containerWidth = $right - $left;

        /**
         * @var GridModel[] $grids
         */
        foreach ($this->_yGrids as $y => $grids) {
            if ($y < $top
                || $y > $bottom
            ) {
                continue;
            }

            foreach ($grids as $grid) {
                $x = $grid->get("x");
                $width = $grid->get("width");
                if ($x >= $left
                    && $x + $width <= $right
                ) {
                    $blockId = $grid->get("blockId");

                    if (array_key_exists($blockId, $this->_blocksContent)) {
                        $html = $this->_blocksContent[$blockId]["html"];
                        $css = $this->_blocksContent[$blockId]["css"];
                        $js = $this->_blocksContent[$blockId]["js"];
                    } else {
                        $blockModel = BlockModel::getById($blockId);
                        $blockModel->setContent();
                        $html = $blockModel->getHtml();
                        $css = $blockModel->getCss();
                        $js = $blockModel->getJs();

                        $this->_blocksContent[$blockId] = [
                            "html" => $html,
                            "css"  => $css,
                            "js"   => $js,
                        ];
                    }

                    $this->_css = array_merge($this->_css, $css);
                    $this->_js = array_merge($this->_js, $js);

                    $blocks[] = [
                        "type"  => "block",
                        "id"    => $grid->get("blockId"),
                        "y"     => $y,
                        "left"  => 100 / $containerWidth * ($x - $left),
                        "width" => $width,
                        "html"  => $html
                    ];
                }
            }
        }

        return $blocks;
    }

    private $_blocksContent = [];

    /**
     * Gets the same borders
     *
     * @param int $top
     * @param int $bottom
     * @param int $left
     * @param int $right
     *
     * @return array
     */
    private function _getSameBordersInfo($top, $bottom, $left, $right)
    {
        $info = [];

        $yList = array_keys($this->_yGrids);

        foreach ($yList as $y) {
            if ($y < $top
                || $y > $bottom
            ) {
                continue;
            }

            $possibleBorders = $this->_getPossibleBordersFromTo($y, $left, $right);
            if (count($possibleBorders) === 0) {
                continue;
            }

            if ($y >= $bottom) {
                $info[1][] = [
                    "y"       => $bottom,
                    "borders" => [$left, $right]
                ];
                break;
            }

            $borders = [$left, $right];
            $count = 1;
            for ($i = $y + 1; $i < $bottom; $i++) {
                $nextPossibleBorders = $this->_getPossibleBordersFromTo($i, $left, $right);
                $checkSame = array_intersect($possibleBorders, $nextPossibleBorders);

                if (count($checkSame) <= 2) {
                    break;
                }

                $borders = $checkSame;
                $possibleBorders = $checkSame;
                $count++;
            }

            $borders = array_unique($borders);
            sort($borders);

            $info[$count][] = [
                "y"       => $y,
                "borders" => $borders
            ];
        }

        if (count($info) === 1
            && array_key_exists(1, $info)
        ) {
            return [
                $bottom - $top + 1 => [
                    0 => [
                        "y"       => $top,
                        "borders" => [$left, $right]
                    ]
                ]
            ];
        } else {
            krsort($info);
        }

        return $info;
    }

    /**
     * Gets possible borders
     *
     * @param int $y
     * @param int $left
     * @param int $right
     *
     * @return int[]
     */
    private function _getPossibleBordersFromTo($y, $left, $right)
    {
        $possibleBorders = [];

        if (!array_key_exists($y, $this->_yPossibleBorders)) {
            return [];
        }

        foreach ($this->_yPossibleBorders[$y] as $border) {
            if ($border >= $left
                && $border <= $right
            ) {
                $possibleBorders[] = $border;
            }
        }

        return $possibleBorders;
    }
}