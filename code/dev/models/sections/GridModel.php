<?php

namespace ss\models\sections;

use ss\models\sections\_base\AbstractGridModel;

/**
 * Model for working with table "grids"
 */
class GridModel extends AbstractGridModel
{

    /**
     * Same borders info
     *
     * @var array
     */
    private $_sameBordersInfo = [];

    /**
     * Sets possible borders for one [Y line => borders]
     *
     * @param GridModel[] $grids Grid model
     *
     * @return array
     */
    public function getPossibleBorders($grids)
    {
        $borders = [];
        $currentY = 0;
        $last = 0;
        $possibleBorders = [];

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

            if ($last < self::GRID_SIZE) {
                for ($i = ($last + 1); $i <= self::GRID_SIZE; $i++) {
                    $values[] = $i;
                }
            }

            $possibleBorders[$y] = $values;
        }

        return $possibleBorders;
    }

    /**
     * Gets possible borders from left to right for Y line
     *
     * @param array $possibleBorders All possible borders
     * @param int   $yValue          Y line
     * @param int   $left            Left
     * @param int   $right           Right
     *
     * @return int[]
     */
    private function _getPossibleBordersFromTo(
        $possibleBorders,
        $yValue,
        $left,
        $right
    ) {
        $bordersFromTo = [];

        if (array_key_exists($yValue, $possibleBorders) === false) {
            return [];
        }

        foreach ($possibleBorders[$yValue] as $border) {
            if ($border >= $left
                && $border <= $right
            ) {
                $bordersFromTo[] = $border;
            }
        }

        return $bordersFromTo;
    }

    /**
     * Gets borders
     *
     * @param array $yGrids       Y => Grids
     * @param array $borders      Count data
     * @param array $currentLines Current lines
     *
     * @return array
     */
    public function getBorders($yGrids, $borders, $currentLines)
    {
        $filteredBorders = [];

        foreach ($borders as $possibleBorder) {
            foreach ($yGrids as $gridY => $grids) {
                if (in_array($gridY, $currentLines) === false
                    || in_array($possibleBorder, $filteredBorders) === true
                ) {
                    continue;
                }

                $filteredBorders = array_merge(
                    $filteredBorders,
                    $this->_getGridBordersForY($grids, $possibleBorder)
                );
            }
        }

        if (count($filteredBorders) < 2) {
            $filteredBorders = [0, self::GRID_SIZE];
        }

        return $filteredBorders;
    }

    /**
     * Gets grid borders for Y line
     *
     * @param GridModel[] $grids          Grid models
     * @param integer     $possibleBorder Possible border
     *
     * @return array
     */
    private function _getGridBordersForY($grids, $possibleBorder)
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
     * Gets the same borders
     *
     * @param array $possibleBorders Possible borders
     * @param array $yGrids          Y line => Grids
     * @param int   $top             Top
     * @param int   $bottom          Bottom
     * @param int   $left            Left
     * @param int   $right           Right
     *
     * @return array
     */
    public function getSameBordersInfo(
        $possibleBorders,
        $yGrids,
        $top,
        $bottom,
        $left,
        $right
    ) {
        $this->_sameBordersInfo = [];

        $yList = array_keys($yGrids);

        foreach ($yList as $yValue) {
            if ($yValue < $top
                || $yValue > $bottom
            ) {
                continue;
            }

            if ($yValue >= $bottom) {
                $this->_sameBordersInfo[1][] = [
                    'y'       => $bottom,
                    'borders' => [$left, $right]
                ];
                break;
            }

            $this->_setSameBorderInfo(
                $possibleBorders,
                $yValue,
                $bottom,
                $left,
                $right
            );
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

        krsort($this->_sameBordersInfo);

        return $this->_sameBordersInfo;
    }

    /**
     * Sets borders for one line
     *
     * @param array $possibleBorders Possible borders
     * @param int   $yValue          Line number
     * @param int   $bottom          Bottom
     * @param int   $left            Left
     * @param int   $right           Right
     *
     * @return GridModel
     */
    private function _setSameBorderInfo(
        $possibleBorders,
        $yValue,
        $bottom,
        $left,
        $right
    ) {
        $bordersFromTo = $this->_getPossibleBordersFromTo(
            $possibleBorders,
            $yValue,
            $left,
            $right
        );
        if (count($bordersFromTo) === 0) {
            return $this;
        }

        $borders = [$left, $right];
        $count = 1;
        for ($i = ($yValue + 1); $i < $bottom; $i++) {
            $nextPossibleBorders = $this
                ->_getPossibleBordersFromTo(
                    $possibleBorders,
                    $i,
                    $left,
                    $right
                );

            $checkSame
                = array_intersect($bordersFromTo, $nextPossibleBorders);

            if (count($checkSame) <= 2) {
                break;
            }

            $borders = $checkSame;
            $bordersFromTo = $checkSame;
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
     * Gets new model
     *
     * @return GridModel
     */
    public static function model()
    {
        return new self;
    }
}
