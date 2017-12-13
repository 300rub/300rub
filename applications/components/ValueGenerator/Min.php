<?php

namespace testS\applications\components\ValueGenerator;

use testS\applications\components\ValueGenerator;

/**
 * Class for min value generation
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
        if (is_array($min) === true) {
            $operator = '+';
            if (empty($min[2]) === false) {
                $operator = $min[2];
            }

            $min = $this->getValueByOperator(
                $min[0],
                $min[1],
                $operator,
                -99999
            );
        }

        if ($value < $min) {
            $value = $min;
        }

        return $value;
    }
}
