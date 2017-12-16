<?php

namespace testS\applications\components\ValueGenerator;

use testS\applications\components\ValueGenerator;

/**
 * Class for bool value generation
 */
class BoolValue extends ValueGenerator
{

    /**
     * Generates value
     *
     * @return mixed
     */
    public function generate()
    {
        if (is_bool($this->value) === true) {
            return $this->value;
        }

        if (is_int($this->value) === true) {
            if ($this->value > 0) {
                return true;
            }

            return false;
        }

        if (is_string($this->value) === true) {
            $value = trim(strtolower($this->value));
            if ($value === 'true' || $value === '1') {
                return true;
            }
        }

        return false;
    }
}
