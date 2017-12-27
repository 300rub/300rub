<?php

namespace testS\models\blocks\record;

use testS\models\blocks\record\_base\AbstractRecordModel;

/**
 * Model for working with table "records"
 */
class RecordModel extends AbstractRecordModel
{

    /**
     * Gets HTML memcached key
     *
     * @return string
     */
    public function getHtmlMemcachedKey()
    {
        return sprintf('image_%s_html', $this->getId());
    }

    /**
     * Gets CSS memcached key
     *
     * @return string
     */
    public function getCssMemcachedKey()
    {
        return sprintf('image_%s_css', $this->getId());
    }

    /**
     * Gets JS memcached key
     *
     * @return string
     */
    public function getJsMemcachedKey()
    {
        return sprintf('image_%s_js', $this->getId());
    }

    /**
     * Generates HTML
     *
     * @return string
     */
    public function generateHtml()
    {
        return '';
    }

    /**
     * Generates CSS
     *
     * @return array
     */
    public function generateCss()
    {
        return [];
    }

    /**
     * Generates JS
     *
     * @return array
     */
    public function generateJs()
    {
        return [];
    }
}
