<?php

namespace ss\models\blocks\text;

use ss\models\blocks\text\_base\AbstractTextInstanceFileMapModel;

/**
 * Model for working with table "textInstanceFileMap"
 */
class TextInstanceFileMapModel extends AbstractTextInstanceFileMapModel
{

    /**
     * Gets TextInstanceFileMapModel
     *
     * @return TextInstanceFileMapModel
     */
    public static function model()
    {
        return new self;
    }
}
