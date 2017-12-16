<?php

namespace testS\application\components\ValueGenerator;

use testS\application\components\ValueGenerator\_abstract\AbstractModifier;
use testS\application\App;

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
