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
     * @return mixed
     */
    public function generate()
    {
        if ($this->value <= $this->param[0]) {
            return $this->param[1];
        }

        return $this->value;
    }
}
