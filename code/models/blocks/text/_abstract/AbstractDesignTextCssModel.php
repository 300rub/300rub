<?php

namespace ss\models\blocks\text\_abstract;

use ss\models\blocks\text\_abstract\AbstractDesignTextCssHoverModel as Hover;

/**
 * Model for working with table "designTexts"
 */
abstract class AbstractDesignTextCssModel extends Hover
{

    /**
     * Css
     *
     * @var string
     */
    protected $css = '';

    /**
     * Sets family
     *
     * @return AbstractDesignTextCssModel
     */
    protected function setFamilyCss()
    {
        $family = $this->get('family');
        if ($family !== self::FAMILY_OPEN_SANS
            && array_key_exists($family, self::$familyList) === true
        ) {
            $this->css .= sprintf(
                'font-family:%s;',
                self::$familyList[$family]['family']
            );
        }

        return $this;
    }

    /**
     * Sets size
     *
     * @return AbstractDesignTextCssModel
     */
    protected function setSizeCss()
    {
        $size = $this->get('size');
        if ($size !== 0 && $size !== self::DEFAULT_SIZE) {
            $this->css .= sprintf('font-size:%spx;', $size);
        }

        return $this;
    }

    /**
     * Sets color
     *
     * @return AbstractDesignTextCssModel
     */
    protected function setColorCss()
    {
        $color = $this->get('color');
        if ($color !== '') {
            $this->css .= sprintf('color:%s;', $color);
        }

        return $this;
    }

    /**
     * Sets isItalic
     *
     * @return AbstractDesignTextCssModel
     */
    protected function setIsItalic()
    {
        $isItalic = $this->get('isItalic');
        if ($isItalic === true) {
            $this->css .= 'font-style:italic;';
        }

        return $this;
    }

    /**
     * Sets isBold
     *
     * @return AbstractDesignTextCssModel
     */
    protected function setIsBold()
    {
        $isBold = $this->get('isBold');
        if ($isBold === true) {
            $this->css .= 'font-weight:bold;';
        }

        return $this;
    }

    /**
     * Sets align
     *
     * @return AbstractDesignTextCssModel
     */
    protected function setAlignCss()
    {
        $align = $this->get('align');
        if ($align !== self::TEXT_ALIGN_LEFT
            && array_key_exists($align, self::$textAlignList) === true
        ) {
            $this->css .= sprintf(
                'text-align:%s;',
                self::$textAlignList[$align]
            );
        }

        return $this;
    }

    /**
     * Sets decoration
     *
     * @return AbstractDesignTextCssModel
     */
    protected function setDecorationCss()
    {
        $decoration = $this->get('decoration');
        if ($decoration !== self::TEXT_DECORATION_NONE) {
            $this->css .= sprintf(
                'text-decoration:%s;',
                $this->getDecoration(false)
            );
        }

        return $this;
    }

    /**
     * Sets transform
     *
     * @return AbstractDesignTextCssModel
     */
    protected function setTransformCss()
    {
        $transform = $this->get('transform');
        if ($transform !== self::TEXT_TRANSFORM_NONE) {
            $this->css .= sprintf(
                'text-transform:%s;',
                $this->getTransform(false)
            );
        }

        return $this;
    }

    /**
     * Sets letterSpacing
     *
     * @return AbstractDesignTextCssModel
     */
    protected function setLetterSpacingCss()
    {
        $letterSpacing = $this->get('letterSpacing');
        if ($letterSpacing !== 0) {
            $this->css .= sprintf('letter-spacing:%spx;', $letterSpacing);
        }

        return $this;
    }

    /**
     * Sets lineHeight
     *
     * @return AbstractDesignTextCssModel
     */
    protected function setLineHeightCss()
    {
        $lineHeight = $this->get('lineHeight');
        if ($lineHeight !== 0) {
            $finalLineHeight = (1.4 + $lineHeight / 100);
            $this->css .= sprintf('line-height:%s;', $finalLineHeight);
        }

        return $this;
    }
}
