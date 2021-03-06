<?php

namespace ss\models\blocks\_abstract;

use ss\models\_abstract\AbstractModel;

/**
 * Abstract class for working with design models
 */
abstract class AbstractDesignModel extends AbstractModel
{

    /**
     * Generates CSS
     *
     * @param string $selector CSS selector
     *
     * @return string
     */
    abstract public function generateCss($selector);

    /**
     * Gets CSS type
     *
     * @return string
     */
    abstract public function getCssType();
}
