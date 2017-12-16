<?php

namespace testS\applications\components\ValueGenerator;

use testS\applications\components\ValueGenerator\_abstract\AbstractModifier;

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
