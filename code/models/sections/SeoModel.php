<?php

namespace ss\models\sections;

use ss\models\sections\_base\AbstractSeoModel;

/**
 * Model for working with table "seo"
 */
class SeoModel extends AbstractSeoModel
{

    /**
     * Max length for alias
     */
    const ALIAS_PREFIX_MAX_LENGTH = 20;

    /**
     * Gets new model
     *
     * @return SeoModel
     */
    public static function model()
    {
        return new self;
    }
}
