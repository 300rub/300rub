<?php

namespace ss\models\blocks\text;

use ss\models\blocks\text\_abstract\AbstractDesignTextCssModel;
use ss\application\App;

/**
 * Model for working with table "designTexts"
 */
class DesignTextModel extends AbstractDesignTextCssModel
{

    /**
     * Type
     */
    const TYPE = 'text';

    /**
     * Gets labels
     *
     * @return array
     */
    public static function getLabels()
    {
        $language = App::getInstance()->getLanguage();

        return [
            'mouseHoverEffect'
            => $language->getMessage('design', 'mouseHoverEffect'),
            'textExample'
            => $language->getMessage('design', 'textExample'),
        ];
    }

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
                ->getMessage('design', 'textDesign');
        }

        if ($namespace === null) {
            $namespace = 'designTextModel';
        }

        if ($except === null) {
            $except = ['id'];
        }

        $values = $this->get(null, $except);
        if (array_key_exists('size', $values) === true
            && $values['size'] === 0
        ) {
            $values['size'] = self::DEFAULT_SIZE;
        }

        return [
            'selector'  => $selector,
            'cssId'     => App::getInstance()
                ->getView()
                ->generateCssId($selector, self::TYPE),
            'type'      => self::TYPE,
            'title'     => $title,
            'namespace' => $namespace,
            'labels'    => self::getLabels(),
            'values'    => $values,
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
            ->setFamilyCss()
            ->setSizeCss()
            ->setColorCss()
            ->setIsItalic()
            ->setIsBold()
            ->setAlignCss()
            ->setDecorationCss()
            ->setTransformCss()
            ->setLetterSpacingCss()
            ->setLineHeightCss();

        if ($this->get('hasHover') === true) {
            $this
                ->setSizeHoverCss()
                ->setColorHoverCss()
                ->setIsItalicHoverCss()
                ->setIsBoldHoverCss()
                ->setDecorationHoverCss()
                ->setTransformHoverCss()
                ->setLetterSpacingHoverCss()
                ->setLineHeightHoverCss();
        }

        $css = '';

        if ($this->css !== '') {
            $css .= sprintf('%s{%s}', $selector, $this->css);
        }

        if ($this->cssHover !== '') {
            $css .= sprintf('%s:hover{%s}', $selector, $this->cssHover);
        }

        return $css;
    }
}
