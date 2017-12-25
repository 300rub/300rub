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
    private $_css = [];

    /**
     * JS
     *
     * @var array
     */
    private $_js = [];

    /**
     * Blocks content
     *
     * @var array
     */
    private $_blocksContent = [];

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

        $this->_css = $this->_generateCss();

        $gridLineModels = $this->_getGridLineModels();
        if (count($gridLineModels) === 0) {
            return $this;
        }

        $gridLineIds = [];

        foreach ($gridLineModels as $gridLineModel) {
            $gridLineIds[] = $gridLineModel->getId();
            $this->_css = array_merge(
                $this->_css,
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
            $y = $grid->get('y');
            if ($y > $currentY) {
                $currentY = $y;
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
                $y = $data['y'];

                if (in_array($y, $usedYLines) === true) {
                    continue;
                }

                $currentLines = [];
                $yLast = ($y + $count - 1);
                for ($i = $y; $i <= $yLast; $i++) {
                    $currentLines[] = $i;
                }

                $usedYLines = array_merge($usedYLines, $currentLines);

                $possibleBorders = $data['borders'];

                $borders = [];
                foreach ($possibleBorders as $possibleBorder) {
                    foreach ($this->_yGrids as $gridY => $grids) {
                        if (in_array($gridY, $currentLines) === false
                            || in_array($possibleBorder, $borders) === true
                        ) {
                            continue;
                        }

                        foreach ($grids as $grid) {
                            $gridX = $grid->get('x');
                            $gridWidth = $grid->get('width');
                            if ($gridX === $possibleBorder
                                || ($gridX + $gridWidth) === $possibleBorder
                            ) {
                                $borders[] = $possibleBorder;
                            }
                        }
                    }
                }

                $structureData = [];
                sort($borders);
                $countBorders = (count($borders) - 1);
                for ($i = 0; $i < $countBorders; $i++) {
                    $x = $borders[$i];
                    $width = ($borders[($i + 1)] - $x);

                    if ($width > 0) {
                        $structureData[] = [
                            'type'  => 'container',
                            'x'     => $x,
                            'left'  => (100 / $containerWidth * ($x - $left)),
                            'width' => $width,
                        ];
                    }
                }

                if (count($structureData) === 1) {
                    $left = $structureData[0]['x'];
                    $right
                        = ($structureData[0]['x'] + $structureData[0]['width']);
                    $containerGrids = $this->_getContainerBlocks(
                        $y,
                        $yLast,
                        $left,
                        $right
                    );

                    if (count($containerGrids) > 0) {
                        $structureData = $containerGrids;
                    } else {
                        continue;
                    }
                } else {
                    foreach ($structureData as $key => &$container) {
                        $left = $container['x'];
                        $right = ($container['x'] + $container['width']);
                        $data = $this->_getLineStructure(
                            $y,
                            $yLast,
                            $left,
                            $right
                        );

                        if (count($data) === 0) {
                            unset($structureData[$key]);
                        } else {
                            $container['data'] = $data;
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
        $containerWidth = ($right - $left);

        foreach ($this->_yGrids as $y => $grids) {
            if ($y < $top
                || $y > $bottom
            ) {
                continue;
            }

            foreach ($grids as $grid) {
                $x = $grid->get('x');
                $width = $grid->get('width');
                if ($x >= $left
                    && ($x + $width) <= $right
                ) {
                    $blockId = $grid->get('blockId');

                    $hasBlockId = array_key_exists(
                        $blockId,
                        $this->_blocksContent
                    );
                    if ($hasBlockId === true) {
                        $html = $this->_blocksContent[$blockId]['html'];
                        $css = $this->_blocksContent[$blockId]['css'];
                        $js = $this->_blocksContent[$blockId]['js'];
                    } else {
                        $blockModel = BlockModel::getById($blockId)
                            ->setContent();
                        $html = $blockModel->getHtml();
                        $css = $blockModel->getCss();
                        $js = $blockModel->getJs();

                        $this->_blocksContent[$blockId] = [
                            'html' => $html,
                            'css'  => $css,
                            'js'   => $js,
                        ];
                    }

                    $this->_css = array_merge($this->_css, $css);
                    $this->_js = array_merge($this->_js, $js);

                    $blocks[] = [
                        'type'  => 'block',
                        'id'    => $grid->get('blockId'),
                        'y'     => $y,
                        'left'  => (100 / $containerWidth * ($x - $left)),
                        'width' => $width,
                        'html'  => $html
                    ];
                }
            }
        }

        return $blocks;
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
        $info = [];

        $yList = array_keys($this->_yGrids);

        foreach ($yList as $y) {
            if ($y < $top
                || $y > $bottom
            ) {
                continue;
            }

            $possibleBorders
                = $this->_getPossibleBordersFromTo($y, $left, $right);
            if (count($possibleBorders) === 0) {
                continue;
            }

            if ($y >= $bottom) {
                $info[1][] = [
                    'y'       => $bottom,
                    'borders' => [$left, $right]
                ];
                break;
            }

            $borders = [$left, $right];
            $count = 1;
            for ($i = ($y + 1); $i < $bottom; $i++) {
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

            $info[$count][] = [
                'y'       => $y,
                'borders' => $borders
            ];
        }

        if (count($info) === 1
            && array_key_exists(1, $info) === true
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
