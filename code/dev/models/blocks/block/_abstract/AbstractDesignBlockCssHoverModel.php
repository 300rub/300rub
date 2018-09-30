<?php

namespace ss\models\blocks\block\_abstract;

use ss\models\blocks\block\_base\AbstractDesignBlockModel;

/**
 * Model for working with table "designBlocks"
 */
abstract class AbstractDesignBlockCssHoverModel extends AbstractDesignBlockModel
{

    /**
     * CSS Hover
     *
     * @var string
     */
    protected $cssHover = '';

    /**
     * Gets gradient direction
     *
     * @param bool $isHover Is hover flag
     *
     * @return array
     */
    protected function getGradientDirection($isHover)
    {
        $gradientDirection = $this->get('gradientDirection');
        if ($isHover === true) {
            $gradientDirection = $this->get('gradientDirectionHover');
        }

        $hasDirection = array_key_exists(
            $gradientDirection,
            self::$gradientDirections
        );

        if ($hasDirection === true) {
            return self::$gradientDirections[$gradientDirection];
        }

        return self::$gradientDirections[self::GRADIENT_DIRECTION_HORIZONTAL];
    }

    /**
     * Gets border style
     *
     * @param bool $isHover Is hover flag
     *
     * @return string
     */
    protected function getBorderStyle($isHover)
    {
        $borderStyle = $this->get('borderStyle');
        if ($isHover === true) {
            $borderStyle = $this->get('borderStyleHover');
        }

        if (array_key_exists($borderStyle, self::$borderStyles) === true) {
            return self::$borderStyles[$borderStyle];
        }

        return self::$borderStyles[self::BORDER_STYLE_SOLID];
    }

    /**
     * Sets margin hover CSS
     *
     * @return AbstractDesignBlockCssHoverModel
     */
    protected function setMarginHoverCss()
    {
        if ($this->get('hasMarginHover') === false) {
            return $this;
        }

        $marginTop = $this->get('marginTopHover');
        $marginRight = $this->get('marginRightHover');
        $marginBottom = $this->get('marginBottomHover');
        $marginLeft = $this->get('marginLeftHover');
        if ($marginTop === 0
            && $marginRight === 0
            && $marginBottom === 0
            && $marginLeft === 0
        ) {
            return $this;
        }

        if ($marginTop !== 0) {
            $marginTop .= 'px';
        }

        if ($marginRight !== 0) {
            $marginRight .= 'px';
        }

        if ($marginBottom !== 0) {
            $marginBottom .= 'px';
        }

        if ($marginLeft !== 0) {
            $marginLeft .= 'px';
        }

        $this->cssHover .= sprintf(
            'margin:%s %s %s %s;',
            $marginTop,
            $marginRight,
            $marginBottom,
            $marginLeft
        );

        return $this;
    }

    /**
     * Sets padding hover CSS
     *
     * @return AbstractDesignBlockCssHoverModel
     */
    protected function setPaddingHoverCss()
    {
        if ($this->get('hasPaddingHover') === false) {
            return $this;
        }

        $paddingTop = $this->get('paddingTopHover');
        $paddingRight = $this->get('paddingRightHover');
        $paddingBottom = $this->get('paddingBottomHover');
        $paddingLeft = $this->get('paddingLeftHover');
        if ($paddingTop === 0
            && $paddingRight === 0
            && $paddingBottom === 0
            && $paddingLeft === 0
        ) {
            return $this;
        }

        if ($paddingTop !== 0) {
            $paddingTop .= 'px';
        }

        if ($paddingRight !== 0) {
            $paddingRight .= 'px';
        }

        if ($paddingBottom !== 0) {
            $paddingBottom .= 'px';
        }

        if ($paddingLeft !== 0) {
            $paddingLeft .= 'px';
        }

        $this->cssHover .= sprintf(
            'padding:%s %s %s %s;',
            $paddingTop,
            $paddingRight,
            $paddingBottom,
            $paddingLeft
        );

        return $this;
    }

    /**
     * Sets background hover CSS
     *
     * @return AbstractDesignBlockCssHoverModel
     */
    protected function setBackgroundHoverCss()
    {
        if ($this->get('hasBackgroundHover') === false) {
            return $this;
        }

        $backgroundColorFrom = $this->get('backgroundColorFromHover');
        $backgroundColorTo = $this->get('backgroundColorToHover');

        if ($this->get('hasBackgroundGradient') === false) {
            $backgroundColorTo = '';
        }

        if ($this->get('hasBackgroundGradient') === true) {
            if ($backgroundColorFrom !== ''
                && $backgroundColorTo === ''
            ) {
                $backgroundColorTo = $backgroundColorFrom;
            }

            if ($backgroundColorFrom === ''
                && $backgroundColorTo !== ''
            ) {
                $backgroundColorFrom = $backgroundColorTo;
            }
        }

        if ($backgroundColorFrom !== ''
            && $backgroundColorTo === ''
        ) {
            $this->cssHover
                .= sprintf('background-color:%s;', $backgroundColorFrom);
            return $this;
        }

        if ($backgroundColorFrom === ''
            && $backgroundColorTo !== ''
        ) {
            $this->cssHover
                .= sprintf('background-color:%s;', $backgroundColorTo);
            return $this;
        }

        if ($backgroundColorFrom === ''
            || $backgroundColorTo === ''
        ) {
            return $this;
        }

        $gradientDirection = $this->getGradientDirection(true);
        $this->cssHover .= sprintf('background:%s;', $backgroundColorFrom);
        $this->cssHover .= sprintf(
            'background:-moz-linear-gradient(%s, %s 0%%, %s 100%%);',
            $gradientDirection['mozLinear'],
            $backgroundColorFrom,
            $backgroundColorTo
        );
        $this->cssHover .= sprintf(
            'background:-webkit-gradient(%s, color-stop(0%%, %s), ' .
            'color-stop(100%%, %s));',
            $gradientDirection['webkit'],
            $backgroundColorFrom,
            $backgroundColorTo
        );
        $this->cssHover .= sprintf(
            'background:-webkit-linear-gradient(%s, %s 0%%, %s 100%%);',
            $gradientDirection['webkitLinear'],
            $backgroundColorFrom,
            $backgroundColorTo
        );
        $this->cssHover .= sprintf(
            'background:-o-linear-gradient(%s, %s 0%%, %s 100%%);',
            $gradientDirection['oLinear'],
            $backgroundColorFrom,
            $backgroundColorTo
        );
        $this->cssHover .= sprintf(
            'background:-ms-linear-gradient(%s, %s 0%%, %s 100%%);',
            $gradientDirection['msLinear'],
            $backgroundColorFrom,
            $backgroundColorTo
        );
        $this->cssHover .= sprintf(
            'background:linear-gradient(%s, %s 0%%, %s 100%%);',
            $gradientDirection['linear'],
            $backgroundColorFrom,
            $backgroundColorTo
        );
        $this->cssHover .= sprintf(
            "filter:progid:DXImageTransform.Microsoft.gradient' .
            '(startColorstr='%s', endColorstr='%s',GradientType=%s);",
            $backgroundColorFrom,
            $backgroundColorTo,
            $gradientDirection['ie']
        );

        return $this;
    }

    /**
     * Sets border radius hover CSS
     *
     * @return AbstractDesignBlockCssHoverModel
     */
    protected function setBorderRadiusHoverCss()
    {
        if ($this->get('hasBorderHover') === false) {
            return $this;
        }

        $borderTopLeft = $this->get('borderTopLeftRadiusHover');
        $borderTopRight = $this->get('borderTopRightRadiusHover');
        $borderBottomRight = $this->get('borderBottomRightRadiusHover');
        $borderBottomLeft = $this->get('borderBottomLeftRadiusHover');

        if ($borderTopLeft !== 0) {
            $borderTopLeft .= 'px';
        }

        if ($borderTopRight !== 0) {
            $borderTopRight .= 'px';
        }

        if ($borderBottomRight !== 0) {
            $borderBottomRight .= 'px';
        }

        if ($borderBottomLeft !== 0) {
            $borderBottomLeft .= 'px';
        }

        $this->cssHover .= sprintf(
            '-webkit-border-radius:%s %s %s %s;',
            $borderTopLeft,
            $borderTopRight,
            $borderBottomRight,
            $borderBottomLeft
        );
        $this->cssHover .= sprintf(
            '-moz-border-radius:%s %s %s %s;',
            $borderTopLeft,
            $borderTopRight,
            $borderBottomRight,
            $borderBottomLeft
        );
        $this->cssHover .= sprintf(
            'border-radius:%s %s %s %s;',
            $borderTopLeft,
            $borderTopRight,
            $borderBottomRight,
            $borderBottomLeft
        );

        return $this;
    }

    /**
     * Sets border hover CSS
     *
     * @return AbstractDesignBlockCssHoverModel
     */
    protected function setBorderHoverCss()
    {
        if ($this->get('hasBorderHover') === false) {
            return $this;
        }

        $borderTopWidth = $this->get('borderTopWidthHover');
        $borderRightWidth = $this->get('borderRightWidthHover');
        $borderBottomWidth = $this->get('borderBottomWidthHover');
        $borderLeftWidth = $this->get('borderLeftWidthHover');

        if ($borderTopWidth !== 0) {
            $borderTopWidth .= 'px';
        }

        if ($borderRightWidth !== 0) {
            $borderRightWidth .= 'px';
        }

        if ($borderBottomWidth !== 0) {
            $borderBottomWidth .= 'px';
        }

        if ($borderLeftWidth !== 0) {
            $borderLeftWidth .= 'px';
        }

        $this->cssHover .= sprintf(
            'border-width:%s %s %s %s;',
            $borderTopWidth,
            $borderRightWidth,
            $borderBottomWidth,
            $borderLeftWidth
        );

        $this->cssHover .= sprintf(
            'border-style:%s;',
            $this->getBorderStyle(true)
        );

        $borderColor = $this->get('borderColorHover');
        if ($borderColor === '') {
            $borderColor = 'transparent';
        }

        $this->cssHover .= sprintf(
            'border-color:%s;',
            $borderColor
        );

        return $this;
    }
}
