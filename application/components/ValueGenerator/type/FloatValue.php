<?php

namespace ss\application\components\ValueGenerator\type;

use ss\application\components\ValueGenerator\_abstract\AbstractType;

/**
 * Class for float value generation
 */
class FloatValue extends AbstractType
{

    /**
     * Generates value
     *
     * @return mixed
     */
    public function generate()
    {
        return (float)$this->value;
    }
}
