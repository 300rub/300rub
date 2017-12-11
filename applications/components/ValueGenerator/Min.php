<?php

/**
 * PHP version 7
 *
 * @category Applications
 * @package  Components
 * @author   Mikhail Vasilev <donvasilion@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     -
 */

namespace testS\applications\components\ValueGenerator;

use testS\applications\components\ValueGenerator;

/**
 * Class for min value generation
 *
 * @category Applications
 * @package  Components_ValueGenerator
 * @author   Mikhail Vasilev <donvasilion@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     -
 */
class Min extends ValueGenerator
{

    /**
     * Generates value
     *
     * @param mixed $value Initial value
     * @param mixed $min   Param
     *
     * @return mixed
     */
    public function generate($value, $min)
    {
        if (is_array($min)) {
            $operator = "+";
            if (!empty($min[2])) {
                $operator = $min[2];
            }

            $min = $this->getValueByOperator($min[0], $min[1], $operator, -99999);
        }

        if ($value < $min) {
            $value = $min;
        }

        return $value;
    }
}