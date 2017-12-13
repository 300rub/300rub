<?php

namespace testS\applications\components\ValueGenerator;

use testS\applications\components\ValueGenerator;

/**
 * Class for min -> then value generation
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
        $min          = $parameters[0];
        $defaultValue = $parameters[1];

        if ($value <= $min) {
            return $defaultValue;
        }

        return $value;
    }
}
