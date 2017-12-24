<?php

namespace testS\models\blocks\image;

use testS\models\blocks\image\_abstract\AbstractDesignImageSliderModel;
use testS\application\App;

/**
 * Model for working with table "designImageSliders"
 */
class DesignImageSliderModel extends AbstractDesignImageSliderModel
{

    /**
     * Type
     */
    const TYPE = 'image-slider';

    /**
     * Gets design
     *
     * @param string $selector  CSS selector
     * @param string $namespace Name space
     *
     * @return array
     */
    public function getDesign($selector, $namespace = null)
    {
        if ($namespace === null) {
            $namespace = 'designImageSliderModel';
        }

        $language = App::getInstance()->getLanguage();

        return [
            $this->get('containerDesignBlockModel')->getDesign(
                $selector,
                $namespace . '.containerDesignBlockModel',
                ['id'],
                $language->getMessage('design', 'imagesContainer')
            ),
            $this->get('navigationDesignBlockModel')->getDesign(
                $selector . ' .navigation',
                $namespace . '.navigationDesignBlockModel',
                ['id'],
                $language->getMessage('design', 'navigationBlock')
            ),
            $this->get('descriptionDesignBlockModel')->getDesign(
                $selector . ' .description',
                $namespace . '.descriptionDesignBlockModel',
                ['id'],
                $language->getMessage('design', 'descriptionBlock')
            ),
            [
                'selector'  => $selector,
                'id'        => App::getInstance()
                ->getView()
                ->generateCssId($selector, self::TYPE),
                'type'      => self::TYPE,
                'title'     => $language->getMessage('design', 'image'),
                'namespace' => $namespace,
                'labels'    => self::getLabels(),
                'values' => [
                    'effect'
                        => $this->get('effect'),
                    'hasAutoPlay'
                        => $this->get('hasAutoPlay'),
                    'playSpeed'
                        => $this->get('playSpeed'),
                    'navigationAlignment'
                        => $this->get('navigationAlignment'),
                    'descriptionAlignment'
                        => $this->get('descriptionAlignment'),
                ]
            ]
        ];
    }
}
