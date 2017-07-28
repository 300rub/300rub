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
     * Array of y => blocks
     *
     * @var array
     */
    private $_yBlockLines = [];

    /**
     * Array of possible borders
     *
     * @var array
     */
    private $_yPossibleBorders = [];

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
                ->_setYBlockLines($lineGrids)
                ->_setPossibleYBorders($lineGrids);

            $structure = $this->_getLineStructure();
            //var_dump($structure);
        }

        return $this;
    }

    /**
     * Sets array of grids compacted by Y
     *
     * @param GridModel[] $grids
     *
     * @return SectionModel
     */
    private function _setYBlockLines($grids)
    {
        foreach ($grids as $grid) {
            $this->_yBlockLines[$grid->get("y")][] = $grid;
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
                 * @var BlockModel[] $blocks
                 */
                $borders = [];
                foreach ($possibleBorders as $possibleBorder) {
                    foreach ($this->_yBlockLines as $blockLineY => $blocks) {
                        if (!in_array($blockLineY, $currentLines)
                            || in_array($possibleBorder, $borders)
                        ) {
                            continue;
                        }

                        foreach ($blocks as $block) {
                            $blockX = $block->get("x");
                            $blockWidth = $block->get("width");
                            if ($blockX === $possibleBorder
                                || $blockX + $blockWidth === $possibleBorder
                            ) {
                                $borders[] = $possibleBorder;
                            }
                        }
                    }
                }

                $containers = [];
                sort($borders);
                for ($i = 0; $i < count($borders) - 1; $i++) {
                    $containers[] = [
                        "type"  => "container",
                        "x"     => $borders[$i],
                        "width" => $borders[$i + 1] - $borders[$i],
                    ];
                }

                if (count($containers) === 1) {
                    $left = $containers[0]["x"];
                    $right = $containers[0]["x"] + $containers[0]["width"];
                    $containerBlocks = $this->_getContainerBlocks($y, $yLast, $left, $right);
                    $containers[0]["data"] = count($containerBlocks);
                } else {
                    foreach ($containers as &$container) {
                        $left = $container["x"];
                        $right = $container["x"] + $container["width"];
                        $data = $this->_getLineStructure($y, $yLast, $left, $right);
                        $container["data"] = $data;
                        var_dump($y);
                        var_dump($yLast);
                        var_dump($left);
                        var_dump($right);
                        var_dump($data);
                    }
                }

                $structure[$y] = $containers;
            }
        }

        ksort($structure);

        return $structure;
    }

    private function _getContainerBlocks($top, $bottom, $left, $right)
    {
        $filteredBlocks = [];

        /**
         * @var BlockModel[] $blocks
         */
        foreach ($this->_yBlockLines as $y => $blocks) {
            if ($y < $top
                || $y > $bottom
            ) {
                continue;
            }

            foreach ($blocks as $block) {
                $x = $block->get("x");
                $width = $block->get("width");
                if ($x >= $left
                    && $x + $width <= $right
                ) {
                    $filteredBlocks[] = [
                        "type"  => "block",
                        "id"    => $block->getId(),
                        "x"     => $x,
                        "width" => $width,
                    ];
                }
            }
        }

        return $filteredBlocks;
    }

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

        $yList = array_keys($this->_yBlockLines);
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

            $length = count($yList);
            if ($y === $length - 1) {
                break;
            }

            $borders = [0, GridModel::GRID_SIZE];
            $count = 1;
            for ($i = $y + 1; $i < $length; $i++) {
                $nextPossibleBorders = $this->_getPossibleBordersFromTo($i, $left, $right);
                $checkSame = array_intersect($possibleBorders, $nextPossibleBorders);

                if (count($checkSame) === 2) {
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

        krsort($info);

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