<?php

namespace testS\applications\components\ValueGenerator;

use testS\applications\components\ValueGenerator;
use testS\applications\App;

/**
 * Class for name copy value generation
 */
class CopyName extends ValueGenerator
{

    /**
     * Generates value
     *
     * @param mixed $value Initial value
     * @param mixed $param Param
     *
     * @return mixed
     */
    public function generate($value, $param)
    {
        return sprintf(
            '%s (%s)',
            $value,
            App::getInstance()->getLanguage()->getMessage('common', 'copy')
        );
    }
}
