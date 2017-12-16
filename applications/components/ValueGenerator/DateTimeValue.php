<?php

namespace testS\applications\components\ValueGenerator;

use testS\applications\components\ValueGenerator;

/**
 * Class for DateTime value generation
 */
class DateTimeValue extends ValueGenerator
{

    /**
     * Generates value
     *
     * @return mixed
     */
    public function generate()
    {
        try {
            return new \DateTime($this->value);
        } catch (\Exception $e) {
            return new \DateTime();
        }
    }
}
