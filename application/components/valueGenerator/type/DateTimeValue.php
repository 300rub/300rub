<?php

namespace ss\application\components\valueGenerator\type;

use ss\application\components\valueGenerator\_abstract\AbstractType;

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
