<?php

namespace ss\models\blocks\image;

use ss\models\blocks\image\_base\AbstractDesignImageSliderModel;
use ss\application\App;

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
                'cssId'     => $cssId,
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

    /**
     * Gets a list of effect values
     *
     * @return array
     */
    public function getEffectValues()
    {
        $effect = $this->get('effect');
        if ($effect === '') {
            return [];
        }

        $list = [];
        $effectsNames[] = $effect;

        if (strpos($effect, ';') !== false) {
            $effectsNames = explode(';', $effect);
        }

        $allEffects = require PROJECT_ROOT . '/config/other/slider.php';
        foreach ($allEffects as $effectGroup) {
            foreach ($effectsNames as $effectsName) {
                if (array_key_exists($effectsName, $effectGroup)) {
                    $list[] = $effectGroup[$effectsName];
                }
            }
        }

        return $list;
    }
}
