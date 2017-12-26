<?php

namespace testS\models\sections;

use testS\application\App;
use testS\application\components\Db;
use testS\models\blocks\block\BlockModel;
use testS\models\blocks\block\DesignBlockModel;
use testS\models\sections\_abstract\AbstractSectionModel;

/**
 * Model for working with table "sections"
 */
class SectionModel extends AbstractSectionModel
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
    private $_cssList = [];

    /**
     * JS
     *
     * @var array
     */
    private $_jsList = [];

    /**
     * Block HTML
     *
     * @var string
     */
    private $_blockHtml = '';

    /**
     * Block CSS
     *
     * @var array
     */
    private $_blockCss = [];

    /**
     * Block JS
     *
     * @var array
     */
    private $_blockJs = [];

    /**
     * Blocks content
     *
     * @var array
     */
    private $_blocksContent = [];

    /**
     * Same borders info
     *
     * @var array
     */
    private $_sameBordersInfo = [];

    /**
     * Adds isMain = 1 condition to SQL request
     *
     * @param int $language Language ID
     *
     * @return SectionModel
     */
    public function main($language = null)
    {
        if ($language === null) {
            $language = App::getInstance()->getLanguage()->getActiveId();
        }

        $this->getDb()->addWhere(
            sprintf(
                '%s.isMain = :isMain',
                Db::DEFAULT_ALIAS
            )
        );
        $this->getDb()->addWhere(
            sprintf(
                '%s.language = :language',
                Db::DEFAULT_ALIAS
            )
        );
        $this->getDb()->addParameter('isMain', 1);
        $this->getDb()->addParameter('language', $language);

        return $this;
    }

    /**
     * Gets CSS
     *
     * @return array
     */
    public function getCss()
    {
        return $this->_cssList;
    }

    /**
     * Gets JS
     *
     * @return array
     */
    public function getJs()
    {
        return $this->_jsList;
    }

    /**
     * Generates isMain
     *
     * @param bool $value Is main value
     *
     * @return bool
     */
    protected function generateIsMain($value)
    {
        if ($value !== true) {
            return false;
        }

        return $this->main($this->get('language'))->find() === null;
    }

    /**
     * Generates section CSS
     *
     * @return array
     */
    private function _generateCss()
    {
        return App::getInstance()->getView()->generateCss(
            $this->get('designBlockModel'),
            sprintf('.section-%s', $this->getId())
        );
    }

    /**
     * Gets grid line models
     *
     * @return GridLineModel[]
     */
    private function _getGridLineModels()
    {
        $gridLineModels = new GridLineModel();
        return $gridLineModels
            ->bySectionId($this->getId())
            ->ordered('sort')
            ->withRelations()
            ->findAll();
    }

    /**
     * Sets structure, CSS, JS
     *
     * @return SectionModel
     */
    public function setStructureAndStatic()
    {
        $designBlockModel = $this->get('designBlockModel');
        if ($designBlockModel instanceof DesignBlockModel === false) {
            return $this;
        }

        $this->_cssList = $this->_generateCss();

        $gridLineModels = $this->_getGridLineModels();
        if (count($gridLineModels) === 0) {
            return $this;
        }

        $gridLineIds = [];

        foreach ($gridLineModels as $gridLineModel) {
            $gridLineIds[] = $gridLineModel->getId();
            $this->_cssList = array_merge(
                $this->_cssList,
                $gridLineModel->generateCss()
            );
        }

        $gridModels = new GridModel();
        $gridModels
            ->addIn('gridLineId', $gridLineIds)
            ->ordered(['y', 'x']);
        $gridModels = $gridModels->findAll();

        foreach ($gridLineModels as $gridLineModel) {
            $lineGrids = [];

            foreach ($gridModels as $gridModel) {
                if ($gridModel->get('gridLineId') === $gridLineModel->getId()) {
                    $lineGrids[] = $gridModel;
                }
            }

            $this
                ->_setyGrids($lineGrids)
                ->_setPossibleBorders($lineGrids);

            $this->_structure[$gridLineModel->getId()]
                = $this->_getLineStructure();
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
     * @param GridModel[] $grids Grid model
     *
     * @return SectionModel
     */
    private function _setyGrids($grids)
    {
        foreach ($grids as $grid) {
            $this->_yGrids[$grid->get('y')][] = $grid;
        }

        return $this;
    }

    /**
     * Sets possible borders for one line
     *
     * @param GridModel[] $grids Grid model
     *
     * @return SectionModel
     */
    private function _setPossibleBorders($grids)
    {
        $borders = [];
        $currentY = 0;
        $last = 0;

        foreach ($grids as $grid) {
            $yValue = $grid->get('y');
            if ($yValue > $currentY) {
                $currentY = $yValue;
            }

            $x = $grid->get('x');
            $width = $grid->get('width');
            $end = ($x + $width);
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

            $last = $values[(count($values) - 1)];

            if ($last < GridModel::GRID_SIZE) {
                for ($i = ($last + 1); $i <= GridModel::GRID_SIZE; $i++) {
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
     * @param int $top    Top
     * @param int $bottom Bottom
     * @param int $left   Left
     * @param int $right  Right
     *
     * @return array
     */
    private function _getLineStructure(
        $top = 0,
        $bottom = 999,
        $left = 0,
        $right = GridModel::GRID_SIZE
    ) {
        $usedYLines = [];
        $structure = [];
        $containerWidth = ($right - $left);

        $bordersInfo = $this->_getSameBordersInfo($top, $bottom, $left, $right);
        foreach ($bordersInfo as $count => $countData) {
            foreach ($countData as $data) {
                $yValue = $data['y'];

                if (in_array($yValue, $usedYLines) === true) {
                    continue;
                }

                $currentLines = [];
                $yLast = ($yValue + $count - 1);
                for ($i = $yValue; $i <= $yLast; $i++) {
                    $currentLines[] = $i;
                }

                $usedYLines = array_merge($usedYLines, $currentLines);

                $structureData = $this->_getStructureData(
                    $yValue,
                    $yLast,
                    $containerWidth,
                    $left,
                    $this->_getBorders($data, $currentLines)
                );

                if (count($structureData) > 0) {
                    $structure[$yValue] = $structureData;
                }
            }
        }

        ksort($structure);

        return $structure;
    }

    /**
     * Gets borders
     *
     * @param array $data         Count data
     * @param array $currentLines Current lines
     *
     * @return array
     */
    private function _getBorders($data, $currentLines)
    {
        $borders = [];

        foreach ($data['borders'] as $possibleBorder) {
            foreach ($this->_yGrids as $gridY => $grids) {
                if (in_array($gridY, $currentLines) === false
                    || in_array($possibleBorder, $borders) === true
                ) {
                    continue;
                }

                $borders = array_merge(
                    $borders,
                    $this->_getGridBorders($grids, $possibleBorder)
                );
            }
        }

        return $borders;
    }

    /**
     * Gets grid borders
     *
     * @param GridModel[] $grids          Grid models
     * @param integer     $possibleBorder Possible border
     *
     * @return array
     */
    private function _getGridBorders($grids, $possibleBorder)
    {
        $borders = [];

        foreach ($grids as $grid) {
            $gridX = $grid->get('x');
            $gridWidth = $grid->get('width');
            if ($gridX === $possibleBorder
                || ($gridX + $gridWidth) === $possibleBorder
            ) {
                $borders[] = $possibleBorder;
            }
        }

        return $borders;
    }

    /**
     * Gets structure date
     *
     * @param integer $yValue         Current Y value
     * @param integer $yLast          Last Y value
     * @param integer $containerWidth Container width
     * @param integer $left           Left
     * @param array   $borders        Borders
     *
     * @return array
     */
    private function _getStructureData(
        $yValue,
        $yLast,
        $containerWidth,
        $left,
        $borders
    ) {
        $structureData = [];
        sort($borders);
        $countBorders = (count($borders) - 1);
        for ($i = 0; $i < $countBorders; $i++) {
            $xValue = $borders[$i];
            $width = ($borders[($i + 1)] - $xValue);

            if ($width > 0) {
                $structureData[] = [
                    'type'  => 'container',
                    'x'     => $xValue,
                    'left'  => (100 / $containerWidth * ($xValue - $left)),
                    'width' => $width,
                ];
            }
        }

        if (count($structureData) === 1) {
            $left = $structureData[0]['x'];
            $right
                = ($structureData[0]['x'] + $structureData[0]['width']);
            $containerGrids = $this->_getContainerBlocks(
                $yValue,
                $yLast,
                $left,
                $right
            );

            return $containerGrids;
        }

        foreach ($structureData as $key => &$container) {
            $left = $container['x'];
            $right = ($container['x'] + $container['width']);
            $data = $this->_getLineStructure(
                $yValue,
                $yLast,
                $left,
                $right
            );

            if (count($data) === 0) {
                unset($structureData[$key]);
            }

            if (count($data) > 0) {
                $container['data'] = $data;
            }
        }

        return $structureData;
    }

    /**
     * Gets blocks from container
     *
     * @param int $top    Top
     * @param int $bottom Bottom
     * @param int $left   Left
     * @param int $right  Right
     *
     * @return array
     */
    private function _getContainerBlocks($top, $bottom, $left, $right)
    {
        $blocks = [];

        foreach ($this->_yGrids as $yValue => $grids) {
            if ($yValue < $top
                || $yValue > $bottom
            ) {
                continue;
            }

            foreach ($grids as $grid) {
                $block = $this->_getContainerBlock(
                    $grid,
                    $yValue,
                    $left,
                    $right
                );

                if (count($block) > 0) {
                    $blocks[] = $block;
                }
            }
        }

        return $blocks;
    }

    /**
     * Sets block static
     *
     * @param GridModel $grid Grid model
     *
     * @return SectionModel
     */
    private function _setBlockStatic($grid)
    {
        $blockId = $grid->get('blockId');

        $hasBlockId = array_key_exists(
            $blockId,
            $this->_blocksContent
        );
        if ($hasBlockId === true) {
            $this->_blockHtml = $this->_blocksContent[$blockId]['html'];
            $this->_blockCss = $this->_blocksContent[$blockId]['css'];
            $this->_blockJs = $this->_blocksContent[$blockId]['js'];
            return $this;
        }

        $blockModel = BlockModel::getById($blockId)
            ->setContent();
        $this->_blockHtml = $blockModel->getHtml();
        $this->_blockCss = $blockModel->getCss();
        $this->_blockJs = $blockModel->getJs();

        $this->_blocksContent[$blockId] = [
            'html' => $this->_blockHtml,
            'css'  => $this->_blockCss,
            'js'   => $this->_blockJs,
        ];

        return $this;
    }

    /**
     * Gets container block
     *
     * @param GridModel $grid   Grim model
     * @param int       $yValue Y value
     * @param int       $left   Left
     * @param int       $right  Right
     *
     * @return array
     */
    private function _getContainerBlock($grid, $yValue, $left, $right)
    {
        $containerWidth = ($right - $left);

        $xValue = $grid->get('x');
        $width = $grid->get('width');
        if ($xValue < $left
            || ($xValue + $width) > $right
        ) {
            return [];
        }

        $this->_setBlockStatic($grid);

        $this->_cssList = array_merge($this->_cssList, $this->_blockCss);
        $this->_jsList = array_merge($this->_jsList, $this->_blockJs);

        return [
            'type'  => 'block',
            'id'    => $grid->get('blockId'),
            'y'     => $yValue,
            'left'  => (100 / $containerWidth * ($xValue - $left)),
            'width' => $width,
            'html'  => $this->_blockHtml
        ];
    }

    /**
     * Gets the same borders
     *
     * @param int $top    Top
     * @param int $bottom Bottom
     * @param int $left   Left
     * @param int $right  Right
     *
     * @return array
     */
    private function _getSameBordersInfo($top, $bottom, $left, $right)
    {
        $this->_sameBordersInfo = [];

        $yList = array_keys($this->_yGrids);

        foreach ($yList as $yValue) {
            if ($yValue < $top
                || $yValue > $bottom
            ) {
                continue;
            }

            if ($yValue >= $bottom) {
                $info[1][] = [
                    'y'       => $bottom,
                    'borders' => [$left, $right]
                ];
                break;
            }

            $this->_setSameBorderInfo($yValue, $bottom, $left, $right);
        }

        if (count($this->_sameBordersInfo) === 1
            && array_key_exists(1, $this->_sameBordersInfo) === true
        ) {
            return [
                ($bottom - $top + 1) => [
                    0 => [
                        'y'       => $top,
                        'borders' => [$left, $right]
                    ]
                ]
            ];
        }

        krsort($info);

        return $info;
    }

    /**
     * Sets borders for one line
     *
     * @param int $yValue Line number
     * @param int $bottom Bottom
     * @param int $left   Left
     * @param int $right  Right
     *
     * @return SectionModel
     */
    private function _setSameBorderInfo($yValue, $bottom, $left, $right)
    {
        $possibleBorders
            = $this->_getPossibleBordersFromTo($yValue, $left, $right);
        if (count($possibleBorders) === 0) {
            return $this;
        }

        $borders = [$left, $right];
        $count = 1;
        for ($i = ($yValue + 1); $i < $bottom; $i++) {
            $nextPossibleBorders
                = $this->_getPossibleBordersFromTo($i, $left, $right);
            $checkSame
                = array_intersect($possibleBorders, $nextPossibleBorders);

            if (count($checkSame) <= 2) {
                break;
            }

            $borders = $checkSame;
            $possibleBorders = $checkSame;
            $count++;
        }

        $borders = array_unique($borders);
        sort($borders);

        $this->_sameBordersInfo[$count][] = [
            'y'       => $yValue,
            'borders' => $borders
        ];

        return $this;
    }

    /**
     * Gets possible borders
     *
     * @param int $yValue Y
     * @param int $left   Left
     * @param int $right  Right
     *
     * @return int[]
     */
    private function _getPossibleBordersFromTo($yValue, $left, $right)
    {
        $possibleBorders = [];

        if (array_key_exists($yValue, $this->_yPossibleBorders) === false) {
            return [];
        }

        foreach ($this->_yPossibleBorders[$yValue] as $border) {
            if ($border >= $left
                && $border <= $right
            ) {
                $possibleBorders[] = $border;
            }
        }

        return $possibleBorders;
    }
}
