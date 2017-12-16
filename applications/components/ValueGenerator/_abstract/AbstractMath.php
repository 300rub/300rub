<?php

namespace testS\applications\components\ValueGenerator\_abstract;

use testS\applications\components\ValueGenerator;

/**
 * Class for max value generation
 */
abstract class AbstractMath extends ValueGenerator
{

    /**
     * Gets value by operator
     *
     * @param int    $value1   Value 1
     * @param int    $value2   Value
     * @param string $operator Operator to compare
     * @param int    $default  Default value
     *
     * @return float|int
     */
    protected function getValueByOperator(
        $value1,
        $value2,
        $operator,
        $default = 0
    ) {
        switch ($operator) {
            case '-':
                return ($value1 - $value2);
            case '+':
                return ($value1 + $value2);
            case '*':
                return ($value1 * $value2);
            case '/':
                return ($value1 / $value2);
            default:
                return $default;
        }
    }
}
