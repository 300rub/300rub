<?php

namespace ss\application\components\valueGenerator\modify;

use ss\application\components\valueGenerator\_abstract\AbstractModifier;
use ss\application\App;

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
