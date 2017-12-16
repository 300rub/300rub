<?php

namespace testS\applications\components\ValueGenerator;

use testS\applications\components\ValueGenerator;

/**
 * Class for float value generation
 */
class FloatValue extends ValueGenerator
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
