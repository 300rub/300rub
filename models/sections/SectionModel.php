<?php

namespace testS\models\sections;

use testS\application\App;
use testS\models\blocks\block\BlockModel;
use testS\models\blocks\block\DesignBlockModel;
use testS\models\sections\_base\AbstractSectionModel;

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
    private $_possibleBorders = [];

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

        $gridModelForBorders = new GridModel();

        foreach ($gridLineModels as $gridLineModel) {
            $lineGrids = [];

            foreach ($gridModels as $gridModel) {
                if ($gridModel->get('gridLineId') === $gridLineModel->getId()) {
                    $lineGrids[] = $gridModel;
                }
            }

            $this->_setyGrids($lineGrids);

            $this->_possibleBorders
                = $gridModelForBorders->getPossibleBorders($lineGrids);

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
        $gridModelForBorders = new GridModel();

        $bordersInfo = $gridModelForBorders->getSameBordersInfo(
            $this->_possibleBorders,
            $this->_yGrids,
            $top,
            $bottom,
            $left,
            $right
        );

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
                    $gridModelForBorders->getBorders(
                        $this->_yGrids,
                        $data['borders'],
                        $currentLines
                    )
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

        $blockModel = BlockModel::model()
            ->getById($blockId)
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
}
