<?php

namespace testS\models;

use testS\components\exceptions\CommonException;
use testS\components\View;

/**
 * Abstract class for working with block models
 *
 * @package testS\models
 */
abstract class AbstractBlockModel extends AbstractContentModel
{

    /**
     * Gets HTML
     *
     * @param array $options
     *
     * @return AbstractContentModel
     */
    abstract public function getHtml($options = []);
}