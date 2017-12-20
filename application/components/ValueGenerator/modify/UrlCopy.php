<?php

namespace testS\application\components\ValueGenerator;

use testS\application\components\ValueGenerator\_abstract\AbstractModifier;

/**
 * Class for URL copy generation
 */
class UrlCopy extends AbstractModifier
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