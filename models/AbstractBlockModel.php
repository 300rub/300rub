<?php

namespace testS\models;

use testS\applications\App;
use testS\components\exceptions\NotFoundException;

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