<?php

namespace testS\application\components\ValueGenerator;

use testS\application\components\ValueGenerator\_abstract\AbstractModifier;

/**
 * Class for generation of value with clear strip tags
 */
class ClearStripTags extends AbstractModifier
{

    /**
     * Generates value
     *
     * @return mixed
     */
    public function generate()
    {
        return trim(
            strip_tags(
                preg_replace(
                    '/<script\b[^>]*>(.*?)<\/script>/is',
                    '',
                    $this->value
                )
            )
        );
    }
}