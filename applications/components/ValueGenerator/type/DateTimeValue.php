<?php

namespace testS\applications\components\ValueGenerator;

use testS\applications\components\ValueGenerator\_abstract\AbstractType;

/**
 * Class for DateTime value generation
 */
class DateTimeValue extends AbstractType
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
