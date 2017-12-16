<?php

namespace testS\applications\components\ValueGenerator;

use testS\applications\App;
use testS\applications\components\ValueGenerator;

/**
 * Class for URL generation
 */
class Url extends ValueGenerator
{

    /**
     * Generates value
     *
     * @return mixed
     */
    public function generate()
    {
        if ($this->param !== '' && $this->value === '') {
            $this->value = $this->param;
        }

        $this->value = App::getInstance()
            ->getLanguage()
            ->getTransliteration($this->value);
        $this->value = str_replace(
            ['_', ' '],
            '-',
            $this->value
        );
        $this->value = strtolower($this->value);
        $this->value = preg_replace(
            '~[^-a-z0-9]+~u',
            '',
            $this->value
        );
        $this->value = trim($this->value, '-');

        return $this->value;
    }
}
