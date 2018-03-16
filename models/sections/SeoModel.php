<?php

namespace ss\models\sections;

use ss\models\sections\_base\AbstractSeoModel;

/**
 * Model for working with table "seo"
 */
class SeoModel extends AbstractSeoModel
{

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
