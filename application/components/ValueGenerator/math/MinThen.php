<?php

namespace ss\application\components\ValueGenerator\math;

use ss\application\components\ValueGenerator\_abstract\AbstractMath;

/**
 * Class for min -> then value generation
 */
class MinThen extends AbstractMath
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
