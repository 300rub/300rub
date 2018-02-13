<?php

namespace ss\application\components\ValueGenerator\type;

use ss\application\components\ValueGenerator\_abstract\AbstractType;

/**
 * Class for DateTime string value generation
 */
class Iso extends AbstractType
{

    /**
     * Generates value
     *
     * @return mixed
     */
    public function generate()
    {
        if ($this->value instanceof \DateTime) {
            return $this->value->format('Y-m-d H:i:s');
        }

        return date('Y-m-d H:i:s', time());
    }
}
