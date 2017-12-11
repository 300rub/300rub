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
 * Class for color value generation
 *
 * @category Applications
 * @package  Components_ValueGenerator
 * @author   Mikhail Vasilev <donvasilion@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     -
 */
class Color extends ValueGenerator
{

    /**
     * Generates value
     *
     * @param mixed $value Initial value
     * @param mixed $param Param
     *
     * @return mixed
     */
    public function generate($value, $param)
    {
        $isValid = preg_match(
            '/(.*?)(rgb|rgba)\((\d+),\s*(\d+),\s*(\d+)(?:,\s*(\d+(?:\.\d+)?))?\)/i',
            $value
        );

        if ($isValid) {
            return $value;
        }

        return "";
    }
}