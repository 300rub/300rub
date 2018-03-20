<?php

namespace ss\models\blocks\image;

use ss\models\blocks\image\_base\AbstractDesignImageSimpleModel;
use ss\application\App;

/**
 * Model for working with table "designImageSimple"
 */
class DesignImageSimpleModel extends AbstractDesignImageSimpleModel
{

    /**
     * Type
     */
    const TYPE = 'image-simple';

    /**
     * Gets design
     *
     * @param string $selector  CSS selector
     * @param string $namespace Namespace
     *
     * @return array
     */
    public function getDesign($selector, $namespace = null)
    {
        if ($namespace === null) {
            $namespace = 'designImageSimpleModel';
        }

        $language = App::getInstance()->getLanguage();
        $cssId = App::getInstance()
            ->getView()
            ->generateCssId($selector, self::TYPE);

        return [
            $this->get('containerDesignBlockModel')->getDesign(
                $selector,
                $namespace . '.containerDesignBlockModel',
                ['id'],
                $language->getMessage('design', 'imagesContainer')
            ),
            $this->get('imageDesignBlockModel')->getDesign(
                $selector . ' .image-instance',
                $namespace . '.imageDesignBlockModel',
                ['id'],
                $language->getMessage('design', 'imageBlock')
            ),
            [
                'selector'  => $selector,
                'cssId'     => $cssId,
                'type'      => self::TYPE,
                'title'     => $language->getMessage('design', 'image'),
                'namespace' => $namespace,
                'labels'    => self::getLabels(),
                'values'    => [
                    'alignment' => $this->get('alignment')
                ],
            ]
        ];
    }

    /**
     * Gets align value
     *
     * @return string
     */
    public function getAlignValue()
    {
        $values = $this->alignListValues;
        if (array_key_exists($this->get('align'), $values) === true) {
            return $this->alignListValues[$this->get('align')];
        }

        return '';
    }
}
