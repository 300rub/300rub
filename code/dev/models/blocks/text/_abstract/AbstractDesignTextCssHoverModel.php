<?php

namespace ss\models\blocks\text\_abstract;

use ss\models\blocks\text\_base\AbstractDesignTextModel;

/**
 * Model for working with table "designTexts"
 */
abstract class AbstractDesignTextCssHoverModel extends AbstractDesignTextModel
{

    /**
     * Css
     *
     * @var string
     */
    protected $cssHover = '';

    /**
     * Gets text decoration
     *
     * @param bool $isHover Hover flag
     *
     * @return string
     */
    protected function getDecoration($isHover)
    {
        $decoration = $this->get('decoration');
        if ($isHover === true) {
            $decoration = $this->get('decorationHover');
        }

        if (array_key_exists($decoration, self::$textDecorationList) === true) {
            return self::$textDecorationList[$decoration];
        }

        return self::$textDecorationList[self::TEXT_DECORATION_NONE];
    }

    /**
     * Gets text transform
     *
     * @param bool $isHover Hover flag
     *
     * @return string
     */
    protected function getTransform($isHover)
    {
        $transform = $this->get('transform');
        if ($isHover === true) {
            $transform = $this->get('transformHover');
        }

        if (array_key_exists($transform, self::$textTransformList) === true) {
            return self::$textTransformList[$transform];
        }

        return self::$textTransformList[self::TEXT_TRANSFORM_NONE];
    }

    /**
     * Sets sizeHover
     *
     * @return AbstractDesignTextCssHoverModel
     */
    protected function setSizeHoverCss()
    {
        $sizeHover = $this->get('sizeHover');
        if ($sizeHover !== $this->get('size')) {
            if ($sizeHover === 0) {
                $sizeHover = self::DEFAULT_SIZE;
            }

            $this->cssHover .= sprintf('font-size:%spx;', $sizeHover);
        }

        return $this;
    }

    /**
     * Sets colorHover
     *
     * @return AbstractDesignTextCssHoverModel
     */
    protected function setColorHoverCss()
    {
        $colorHover = $this->get('colorHover');
        if ($colorHover !== ''
            && $colorHover !== $this->get('color')
        ) {
            $this->cssHover .= sprintf('color:%s;', $colorHover);
        }

        return $this;
    }

    /**
     * Sets isItalicHover
     *
     * @return AbstractDesignTextCssHoverModel
     */
    protected function setIsItalicHoverCss()
    {
        $isItalicHover = $this->get('isItalicHover');
        if ($isItalicHover !== $this->get('isItalic')) {
            if ($isItalicHover === true) {
                $this->cssHover .= 'font-style:italic;';
                return $this;
            }

            $this->cssHover .= 'font-style:normal;';
        }

        return $this;
    }

    /**
     * Sets isBoldHover
     *
     * @return AbstractDesignTextCssHoverModel
     */
    protected function setIsBoldHoverCss()
    {
        $isBoldHover = $this->get('isBoldHover');
        if ($isBoldHover !== $this->get('isBold')) {
            if ($isBoldHover === true) {
                $this->cssHover .= 'font-weight:bold;';
                return $this;
            }

            $this->cssHover .= 'font-weight:normal;';
        }

        return $this;
    }

    /**
     * Sets decorationHover
     *
     * @return AbstractDesignTextCssHoverModel
     */
    protected function setDecorationHoverCss()
    {
        $decorationHover = $this->get('decorationHover');
        if ($this->get('decoration') !== $decorationHover) {
            $this->cssHover .= sprintf(
                'text-decoration:%s;',
                $this->getDecoration(true)
            );
        }

        return $this;
    }

    /**
     * Sets transformHover
     *
     * @return AbstractDesignTextCssHoverModel
     */
    protected function setTransformHoverCss()
    {
        $transformHover = $this->get('transformHover');
        if ($this->get('transform') !== $transformHover) {
            $this->cssHover .= sprintf(
                'text-transform:%s;',
                $this->getTransform(true)
            );
        }

        return $this;
    }

    /**
     * Sets letterSpacingHover
     *
     * @return AbstractDesignTextCssHoverModel
     */
    protected function setLetterSpacingHoverCss()
    {
        $letterSpacingHover = $this->get('letterSpacingHover');
        if ($this->get('letterSpacing') !== $letterSpacingHover) {
            $this->cssHover .= sprintf(
                'letter-spacing:%spx;',
                $letterSpacingHover
            );
        }

        return $this;
    }

    /**
     * Sets lineHeightHover
     *
     * @return AbstractDesignTextCssHoverModel
     */
    protected function setLineHeightHoverCss()
    {
        $lineHeightHover = $this->get('lineHeightHover');
        if ($lineHeightHover !== $this->get('lineHeight')) {
            $finalLineHeight = (1.4 + $lineHeightHover / 100);
            $this->cssHover .= sprintf('line-height:%s;', $finalLineHeight);
        }

        return $this;
    }
}
