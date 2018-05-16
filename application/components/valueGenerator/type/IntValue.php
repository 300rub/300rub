<?php

namespace ss\application\components\valueGenerator\type;

use ss\application\components\valueGenerator\_abstract\AbstractType;

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
