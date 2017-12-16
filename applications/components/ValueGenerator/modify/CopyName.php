<?php

namespace testS\applications\components\ValueGenerator;

use testS\applications\components\ValueGenerator\_abstract\AbstractModifier;
use testS\applications\App;

/**
 * Class for name copy value generation
 */
class CopyName extends AbstractModifier
{

    /**
     * Generates value
     *
     * @return mixed
     */
    public function generate()
    {
        return sprintf(
            '%s (%s)',
            $this->value,
            App::getInstance()->getLanguage()->getMessage('common', 'copy')
        );
    }
}
