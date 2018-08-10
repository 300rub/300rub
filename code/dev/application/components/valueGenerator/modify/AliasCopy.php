<?php

namespace ss\application\components\valueGenerator\modify;

use ss\application\components\valueGenerator\_abstract\AbstractModifier;

/**
 * Class for alias copy generation
 */
class AliasCopy extends AbstractModifier
{

    /**
     * Generates value
     *
     * @return mixed
     */
    public function generate()
    {
        return $this->value . '-copy';
    }
}
