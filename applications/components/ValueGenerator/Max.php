<?php

namespace testS\applications\components\ValueGenerator;

use testS\applications\components\ValueGenerator;

/**
 * Class for max value generation
 */
class Max extends ValueGenerator
{

    /**
     * Generates value
     *
     * @param mixed $value Initial value
     * @param mixed $max   Param
     *
     * @return mixed
     */
    public function generate($value, $max)
    {
        if (is_array($max) === true) {
            $operator = '-';
            if (empty($max[2]) === false) {
                $operator = $max[2];
            }

            $max = $this->getValueByOperator(
                $max[0],
                $max[1],
                $operator,
                99999
            );
        }

        if ($value > $max) {
            $value = $max;
        }

        return $value;
    }
}
