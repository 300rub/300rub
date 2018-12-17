<?php

namespace ss\models\blocks\block;

use ss\application\App;
use ss\models\blocks\block\_abstract\AbstractDesignBlockImageModel;

/**
 * Model for working with table "designBlocks"
 */
class DesignBlockModel extends AbstractDesignBlockImageModel
{

    /**
     * Gets design
     *
     * @param string $selector  CSS selector
     * @param string $namespace Namespace
     * @param array  $except    Fields to except
     * @param string $title     Title
     *
     * @return array
     */
    public function getDesign(
        $selector,
        $namespace = null,
        array $except = null,
        $title = null
    ) {
        if ($title === null) {
            $title = App::getInstance()
                ->getLanguage()
                ->getMessage('design', 'blockDesign');
        }

        if ($namespace === null) {
            $namespace = 'designBlockModel';
        }

        if ($except === null) {
            $except = ['id'];
        }

        return [
            'selector'       => $selector,
            'cssContainerId' => App::getInstance()
                ->getView()
                ->generateCssContainerId($selector, self::TYPE),
            'type'           => self::TYPE,
            'title'          => $title,
            'namespace'      => $namespace,
            'labels'         => $this->getLabels(),
            'values'         => $this->get(null, $except),
            'image'          => $this->getImageOptions(),
        ];
    }

    /**
     * Generates CSS
     *
     * @param string $selector CSS selector
     *
     * @return string
     */
    public function generateCss($selector)
    {
        $this->css = '';
        $this->cssHover = '';

        $this
            ->setMarginCss()
            ->setPaddingCss()
            ->setBackgroundCss()
            ->setBorderRadiusCss()
            ->setBorderCss()
            ->setWidthCss()
            ->setTransitionCss()
            ->setMarginHoverCss()
            ->setPaddingHoverCss()
            ->setBackgroundHoverCss()
            ->setBorderRadiusHoverCss()
            ->setBorderHoverCss();

        $css = '';

        if ($this->css !== '') {
            $css .= sprintf('%s{%s}', $selector, $this->css);
        }

        if ($this->cssHover !== '') {
            $css .= sprintf('%s:hover{%s}', $selector, $this->cssHover);
        }

        return $css;
    }

    /**
     * Gets CSS type
     *
     * @return string
     */
    public function getCssType()
    {
        return 'block';
    }
}
