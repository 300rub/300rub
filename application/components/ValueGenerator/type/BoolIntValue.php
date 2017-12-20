<?php

namespace testS\application\components\ValueGenerator;

use testS\application\components\ValueGenerator\_abstract\AbstractType;

/**
 * Class for bool integer (0/1) value generation
 */
class BoolIntValue extends AbstractType
{

    /**
     * Generates value
     *
     * @return mixed
     */
    public function generate()
    {
        if ($this->value === true) {
            return 1;
        }

        if ($this->value === false) {
            return 0;
        }

        $this->value = (int)$this->value;
        if ($this->value >= 1) {
            return 1;
        }

        return 0;
    }
}