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
 * Class for min -> then value generation
 *
 * @category Applications
 * @package  Components_ValueGenerator
 * @author   Mikhail Vasilev <donvasilion@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     -
 */
class MinThen extends ValueGenerator
{

    /**
     * Generates value
     *
     * @param mixed $value      Initial value
     * @param mixed $parameters Param
     *
     * @return mixed
     */
    public function generate($value, $parameters)
    {
        $min = $parameters[0];
        $defaultValue = $parameters[1];

        if ($value <= $min) {
            return $defaultValue;
        }

        return $value;
    }
}