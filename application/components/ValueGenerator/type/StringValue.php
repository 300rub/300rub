<?php

namespace ss\application\components\ValueGenerator\type;

use ss\application\components\ValueGenerator\_abstract\AbstractType;

/**
 * Class for string generation
 */
class StringValue extends AbstractType
{

    /**
     * Generates value
     *
     * @return mixed
     */
    public function generate()
    {
        return trim((string)$this->value);
    }
}
