<?php

namespace testS\application\components\ValueGenerator\type;

use testS\application\components\ValueGenerator\_abstract\AbstractType;

/**
 * Class for integer generation
 */
class IntValue extends AbstractType
{

    /**
     * Generates value
     *
     * @return mixed
     */
    public function generate()
    {
        return (int)$this->value;
    }
}
