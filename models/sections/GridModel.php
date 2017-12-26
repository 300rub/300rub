<?php

namespace testS\models\sections;

use testS\models\sections\_abstract\AbstractGridModel;

/**
 * Model for working with table "grids"
 */
class GridModel extends AbstractGridModel
{

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
    public function getPossibleBordersFromTo(
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
}
