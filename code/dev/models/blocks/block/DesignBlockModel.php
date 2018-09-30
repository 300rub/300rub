<?php

namespace ss\models\blocks\block;

use ss\application\App;
use ss\models\blocks\block\_base\AbstractDesignBlockModel;

/**
 * Model for working with table "designBlocks"
 */
class DesignBlockModel extends AbstractDesignBlockModel
{

    /**
     * Gets gradient direction
     *
     * @param bool $isHover Is hover flag
     *
     * @return array
     */
    public function getGradientDirection($isHover)
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
    public function getBorderStyle($isHover)
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
            'selector'  => $selector,
            'cssId'     => App::getInstance()
                ->getView()
                ->generateCssId($selector, self::TYPE),
            'type'      => self::TYPE,
            'title'     => $title,
            'namespace' => $namespace,
            'labels'    => self::getLabels(),
            'values'    => $this->get(null, $except),
        ];
    }

    /**
     * CSS
     *
     * @var string
     */
    private $_css = '';

    /**
     * CSS Hover
     *
     * @var string
     */
    private $_cssHover = '';

    /**
     * Generates CSS
     *
     * @param string $selector CSS selector
     *
     * @return string
     */
    public function generateCss($selector)
    {
        $this->_css = '';
        $this->_cssHover = '';

        $this
            ->_setMarginCss()
            ->_setPaddingCss()
            ->_setBackgroundCss()
            ->_setBorderRadiusCss()
            ->_setBorderCss()
            ->_setWidthCss()
            ->_setTransitionCss()
            ->_setMarginHoverCss()
            ->_setPaddingHoverCss()
            ->_setBackgroundHoverCss()
            ->_setBorderRadiusHoverCss()
            ->_setBorderHoverCss();

        $css = '';

        if ($this->_css !== '') {
            $css .= sprintf('%s{%s}', $selector, $this->_css);
        }

        if ($this->_cssHover !== '') {
            $css .= sprintf('%s:hover{%s}', $selector, $this->_cssHover);
        }

        return $css;
    }

    /**
     * Sets Margin CSS
     *
     * @return DesignBlockModel
     */
    private function _setMarginCss()
    {
        $marginTop = $this->get('marginTop');
        $marginRight = $this->get('marginRight');
        $marginBottom = $this->get('marginBottom');
        $marginLeft = $this->get('marginLeft');
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

        $this->_css .= sprintf(
            'margin:%s %s %s %s;',
            $marginTop,
            $marginRight,
            $marginBottom,
            $marginLeft
        );

        return $this;
    }

    /**
     * Sets Padding CSS
     *
     * @return DesignBlockModel
     */
    private function _setPaddingCss()
    {
        $paddingTop = $this->get('paddingTop');
        $paddingRight = $this->get('paddingRight');
        $paddingBottom = $this->get('paddingBottom');
        $paddingLeft = $this->get('paddingLeft');
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

        $this->_css .= sprintf(
            'padding:%s %s %s %s;',
            $paddingTop,
            $paddingRight,
            $paddingBottom,
            $paddingLeft
        );

        return $this;
    }

    /**
     * Sets Background CSS
     *
     * @return DesignBlockModel
     */
    private function _setBackgroundCss()
    {
        $backgroundColorFrom = $this->get('backgroundColorFrom');
        $backgroundColorTo = $this->get('backgroundColorTo');
        if ($this->get('hasBackgroundGradient') === false) {
            $backgroundColorTo = '';
        }

        if ($backgroundColorFrom !== ''
            && $backgroundColorTo === ''
        ) {
            $this->_css
                .= sprintf('background-color:%s;', $backgroundColorFrom);
            return $this;
        }

        if ($backgroundColorFrom === ''
            && $backgroundColorTo !== ''
        ) {
            $this->_css
                .= sprintf('background-color:%s;', $backgroundColorTo);
            return $this;
        }

        if ($backgroundColorFrom === ''
            || $backgroundColorTo === ''
        ) {
            return $this;
        }

        $gradientDirection = $this->getGradientDirection(false);
        $this->_css .= sprintf('background:%s;', $backgroundColorFrom);
        $this->_css .= sprintf(
            'background:-moz-linear-gradient(%s, %s 0%%, %s 100%%);',
            $gradientDirection['mozLinear'],
            $backgroundColorFrom,
            $backgroundColorTo
        );
        $this->_css .= sprintf(
            'background:-webkit-gradient(%s, color-stop(0%%, %s), ' .
            'color-stop(100%%, %s));',
            $gradientDirection['webkit'],
            $backgroundColorFrom,
            $backgroundColorTo
        );
        $this->_css .= sprintf(
            'background:-webkit-linear-gradient(%s, %s 0%%, %s 100%%);',
            $gradientDirection['webkitLinear'],
            $backgroundColorFrom,
            $backgroundColorTo
        );
        $this->_css .= sprintf(
            'background:-o-linear-gradient(%s, %s 0%%, %s 100%%);',
            $gradientDirection['oLinear'],
            $backgroundColorFrom,
            $backgroundColorTo
        );
        $this->_css .= sprintf(
            'background:-ms-linear-gradient(%s, %s 0%%, %s 100%%);',
            $gradientDirection['msLinear'],
            $backgroundColorFrom,
            $backgroundColorTo
        );
        $this->_css .= sprintf(
            'background:linear-gradient(%s, %s 0%%, %s 100%%);',
            $gradientDirection['linear'],
            $backgroundColorFrom,
            $backgroundColorTo
        );
        $this->_css .= sprintf(
            "filter:progid:DXImageTransform.Microsoft.gradient' .
            '(startColorstr='%s', endColorstr='%s',GradientType=%s);",
            $backgroundColorFrom,
            $backgroundColorTo,
            $gradientDirection['ie']
        );

        return $this;
    }

    /**
     * Sets BorderRadius CSS
     *
     * @return DesignBlockModel
     */
    private function _setBorderRadiusCss()
    {
        $borderTopLeftRadius = $this->get('borderTopLeftRadius');
        $borderTopRightRadius = $this->get('borderTopRightRadius');
        $borderBottomRightRadius = $this->get('borderBottomRightRadius');
        $borderBottomLeftRadius = $this->get('borderBottomLeftRadius');
        if ($borderTopLeftRadius === 0
            && $borderTopRightRadius === 0
            && $borderBottomRightRadius === 0
            && $borderBottomLeftRadius === 0
        ) {
            return $this;
        }

        if ($borderTopLeftRadius !== 0) {
            $borderTopLeftRadius .= 'px';
        }

        if ($borderTopRightRadius !== 0) {
            $borderTopRightRadius .= 'px';
        }

        if ($borderBottomRightRadius !== 0) {
            $borderBottomRightRadius .= 'px';
        }

        if ($borderBottomLeftRadius !== 0) {
            $borderBottomLeftRadius .= 'px';
        }

        $this->_css .= sprintf(
            '-webkit-border-radius:%s %s %s %s;',
            $borderTopLeftRadius,
            $borderTopRightRadius,
            $borderBottomRightRadius,
            $borderBottomLeftRadius
        );
        $this->_css .= sprintf(
            '-moz-border-radius:%s %s %s %s;',
            $borderTopLeftRadius,
            $borderTopRightRadius,
            $borderBottomRightRadius,
            $borderBottomLeftRadius
        );
        $this->_css .= sprintf(
            'border-radius:%s %s %s %s;',
            $borderTopLeftRadius,
            $borderTopRightRadius,
            $borderBottomRightRadius,
            $borderBottomLeftRadius
        );

        return $this;
    }

    /**
     * Sets border CSS
     *
     * @return DesignBlockModel
     */
    private function _setBorderCss()
    {
        $borderTopWidth = $this->get('borderTopWidth');
        $borderRightWidth = $this->get('borderRightWidth');
        $borderBottomWidth = $this->get('borderBottomWidth');
        $borderLeftWidth = $this->get('borderLeftWidth');
        if ($borderTopWidth === 0
            && $borderRightWidth === 0
            && $borderBottomWidth === 0
            && $borderLeftWidth === 0
        ) {
            return $this;
        }

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

        $this->_css .= sprintf(
            'border-width:%s %s %s %s;',
            $borderTopWidth,
            $borderRightWidth,
            $borderBottomWidth,
            $borderLeftWidth
        );

        $this->_css .= sprintf(
            'border-style:%s;',
            $this->getBorderStyle(false)
        );
        $borderColor = $this->get('borderColor');
        if ($borderColor === '') {
            $borderColor = 'transparent';
        }

        $this->_css .= sprintf(
            'border-color:%s;',
            $borderColor
        );

        return $this;
    }

    /**
     * Sets width CSS
     *
     * @return DesignBlockModel
     */
    private function _setWidthCss()
    {
        $width = $this->get('width');
        if ($width === 0) {
            return $this;
        }

        if ($width <= 100) {
            $width .= '%';
        } else {
            $width .= 'px';
        }

        $this->_css .= sprintf(
            'width:%s;',
            $width
        );

        return $this;
    }

    /**
     * Sets transition CSS
     *
     * @return DesignBlockModel
     */
    private function _setTransitionCss()
    {
        $transitions = [];
        if ($this->get('hasMarginHover') === true
            && $this->get('hasMarginAnimation') === true
        ) {
            $transitions[] = 'margin .3s';
        }

        if ($this->get('hasPaddingHover') === true
            && $this->get('hasPaddingAnimation') === true
        ) {
            $transitions[] = 'padding .3s';
        }

        if ($this->get('hasBackgroundGradient') === false
            && $this->get('hasBackgroundHover') === true
            && $this->get('hasBackgroundAnimation') === true
        ) {
            $transitions[] = 'background-color .3s';
        }

        if ($this->get('hasBorderHover') === true
            && $this->get('hasBorderAnimation') === true
        ) {
            $transitions[] = 'border-radius .3s';
            $transitions[] = 'border-width .3s';
            $transitions[] = 'border-color .3s';
        }

        $transition = implode(',', $transitions);
        if ($transition === '') {
            return $this;
        }

        $this->_css .= sprintf('-webkit-transition:%s;', $transition);
        $this->_css .= sprintf('-ms-transition:%s;', $transition);
        $this->_css .= sprintf('-o-transition:%s;', $transition);
        $this->_css .= sprintf('transition:%s;', $transition);

        return $this;
    }

    /**
     * Sets margin hover CSS
     *
     * @return DesignBlockModel
     */
    private function _setMarginHoverCss()
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

        $this->_cssHover .= sprintf(
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
     * @return DesignBlockModel
     */
    private function _setPaddingHoverCss()
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

        $this->_cssHover .= sprintf(
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
     * @return DesignBlockModel
     */
    private function _setBackgroundHoverCss()
    {
        if ($this->get('hasBackgroundHover') === false) {
            return $this;
        }

        $backgroundColorFrom = $this->get('backgroundColorFromHover');
        $backgroundColorTo = $this->get('backgroundColorToHover');
        if ($this->get('hasBackgroundGradient') === false) {
            $backgroundColorTo = '';
        } else {
            if ($backgroundColorFrom !== ''
                && $backgroundColorTo === ''
            ) {
                $backgroundColorTo = $backgroundColorFrom;
            } elseif ($backgroundColorFrom === ''
                && $backgroundColorTo !== ''
            ) {
                $backgroundColorFrom = $backgroundColorTo;
            }
        }

        if ($backgroundColorFrom !== ''
            && $backgroundColorTo === ''
        ) {
            $this->_cssHover
                .= sprintf('background-color:%s;', $backgroundColorFrom);
            return $this;
        }

        if ($backgroundColorFrom === ''
            && $backgroundColorTo !== ''
        ) {
            $this->_cssHover
                .= sprintf('background-color:%s;', $backgroundColorTo);
            return $this;
        }

        if ($backgroundColorFrom === ''
            || $backgroundColorTo === ''
        ) {
            return $this;
        }

        $gradientDirection = $this->getGradientDirection(true);
        $this->_cssHover .= sprintf('background:%s;', $backgroundColorFrom);
        $this->_cssHover .= sprintf(
            'background:-moz-linear-gradient(%s, %s 0%%, %s 100%%);',
            $gradientDirection['mozLinear'],
            $backgroundColorFrom,
            $backgroundColorTo
        );
        $this->_cssHover .= sprintf(
            'background:-webkit-gradient(%s, color-stop(0%%, %s), ' .
            'color-stop(100%%, %s));',
            $gradientDirection['webkit'],
            $backgroundColorFrom,
            $backgroundColorTo
        );
        $this->_cssHover .= sprintf(
            'background:-webkit-linear-gradient(%s, %s 0%%, %s 100%%);',
            $gradientDirection['webkitLinear'],
            $backgroundColorFrom,
            $backgroundColorTo
        );
        $this->_cssHover .= sprintf(
            'background:-o-linear-gradient(%s, %s 0%%, %s 100%%);',
            $gradientDirection['oLinear'],
            $backgroundColorFrom,
            $backgroundColorTo
        );
        $this->_cssHover .= sprintf(
            'background:-ms-linear-gradient(%s, %s 0%%, %s 100%%);',
            $gradientDirection['msLinear'],
            $backgroundColorFrom,
            $backgroundColorTo
        );
        $this->_cssHover .= sprintf(
            'background:linear-gradient(%s, %s 0%%, %s 100%%);',
            $gradientDirection['linear'],
            $backgroundColorFrom,
            $backgroundColorTo
        );
        $this->_cssHover .= sprintf(
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
     * @return DesignBlockModel
     */
    private function _setBorderRadiusHoverCss()
    {
        if ($this->get('hasBorderHover') === false) {
            return $this;
        }

        $borderTopLeftRadius = $this->get('borderTopLeftRadiusHover');
        $borderTopRightRadius = $this->get('borderTopRightRadiusHover');
        $borderBottomRightRadius = $this->get('borderBottomRightRadiusHover');
        $borderBottomLeftRadius = $this->get('borderBottomLeftRadiusHover');

        if ($borderTopLeftRadius !== 0) {
            $borderTopLeftRadius .= 'px';
        }

        if ($borderTopRightRadius !== 0) {
            $borderTopRightRadius .= 'px';
        }

        if ($borderBottomRightRadius !== 0) {
            $borderBottomRightRadius .= 'px';
        }

        if ($borderBottomLeftRadius !== 0) {
            $borderBottomLeftRadius .= 'px';
        }

        $this->_cssHover .= sprintf(
            '-webkit-border-radius:%s %s %s %s;',
            $borderTopLeftRadius,
            $borderTopRightRadius,
            $borderBottomRightRadius,
            $borderBottomLeftRadius
        );
        $this->_cssHover .= sprintf(
            '-moz-border-radius:%s %s %s %s;',
            $borderTopLeftRadius,
            $borderTopRightRadius,
            $borderBottomRightRadius,
            $borderBottomLeftRadius
        );
        $this->_cssHover .= sprintf(
            'border-radius:%s %s %s %s;',
            $borderTopLeftRadius,
            $borderTopRightRadius,
            $borderBottomRightRadius,
            $borderBottomLeftRadius
        );

        return $this;
    }

    /**
     * Sets border hover CSS
     *
     * @return DesignBlockModel
     */
    private function _setBorderHoverCss()
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

        $this->_cssHover .= sprintf(
            'border-width:%s %s %s %s;',
            $borderTopWidth,
            $borderRightWidth,
            $borderBottomWidth,
            $borderLeftWidth
        );

        $this->_cssHover .= sprintf(
            'border-style:%s;',
            $this->getBorderStyle(true)
        );

        $borderColor = $this->get('borderColorHover');
        if ($borderColor === '') {
            $borderColor = 'transparent';
        }

        $this->_cssHover .= sprintf(
            'border-color:%s;',
            $borderColor
        );

        return $this;
    }
}
