<?php

namespace ss\models\blocks\block\_abstract;

use ss\models\blocks\block\_abstract\AbstractDesignBlockCssHoverModel as Hover;
use ss\models\blocks\image\ImageInstanceModel;

/**
 * Model for working with table "designBlocks"
 */
abstract class AbstractDesignBlockCssModel extends Hover
{

    /**
     * CSS
     *
     * @var string
     */
    protected $css = '';

    /**
     * Sets Margin CSS
     *
     * @return AbstractDesignBlockCssModel
     */
    protected function setMarginCss()
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

        $this->css .= sprintf(
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
     * @return AbstractDesignBlockCssModel
     */
    protected function setPaddingCss()
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

        $this->css .= sprintf(
            'padding:%s %s %s %s;',
            $paddingTop,
            $paddingRight,
            $paddingBottom,
            $paddingLeft
        );

        return $this;
    }

    /**
     * Sets Background color CSS
     *
     * @return AbstractDesignBlockCssModel
     */
    protected function setBackgroundColorCss()
    {
        $backgroundColorFrom = $this->get('backgroundColorFrom');
        $backgroundColorTo = $this->get('backgroundColorTo');
        if ($this->get('hasBackgroundGradient') === false) {
            $backgroundColorTo = '';
        }

        if ($backgroundColorFrom !== ''
            && $backgroundColorTo === ''
        ) {
            $this->css .= sprintf(
                'background-color:%s;',
                $backgroundColorFrom
            );
            return $this;
        }

        if ($backgroundColorFrom === ''
            && $backgroundColorTo !== ''
        ) {
            $this->css
                .= sprintf('background-color:%s;', $backgroundColorTo);
            return $this;
        }

        if ($backgroundColorFrom === ''
            || $backgroundColorTo === ''
        ) {
            return $this;
        }

        $gradientDirection = $this->getGradientDirection(false);
        $this->css .= sprintf('background:%s;', $backgroundColorFrom);
        $this->css .= sprintf(
            'background:-moz-linear-gradient(%s, %s 0%%, %s 100%%);',
            $gradientDirection['mozLinear'],
            $backgroundColorFrom,
            $backgroundColorTo
        );
        $this->css .= sprintf(
            'background:-webkit-gradient(%s, color-stop(0%%, %s), ' .
            'color-stop(100%%, %s));',
            $gradientDirection['webkit'],
            $backgroundColorFrom,
            $backgroundColorTo
        );
        $this->css .= sprintf(
            'background:-webkit-linear-gradient(%s, %s 0%%, %s 100%%);',
            $gradientDirection['webkitLinear'],
            $backgroundColorFrom,
            $backgroundColorTo
        );
        $this->css .= sprintf(
            'background:-o-linear-gradient(%s, %s 0%%, %s 100%%);',
            $gradientDirection['oLinear'],
            $backgroundColorFrom,
            $backgroundColorTo
        );
        $this->css .= sprintf(
            'background:-ms-linear-gradient(%s, %s 0%%, %s 100%%);',
            $gradientDirection['msLinear'],
            $backgroundColorFrom,
            $backgroundColorTo
        );
        $this->css .= sprintf(
            'background:linear-gradient(%s, %s 0%%, %s 100%%);',
            $gradientDirection['linear'],
            $backgroundColorFrom,
            $backgroundColorTo
        );
        $this->css .= sprintf(
            'filter:progid:DXImageTransform.Microsoft.gradient' .
            '(startColorstr="%s", endColorstr="%s",GradientType=%s);',
            $backgroundColorFrom,
            $backgroundColorTo,
            $gradientDirection['ie']
        );

        return $this;
    }

    /**
     * Sets Background image CSS
     *
     * @return AbstractDesignBlockCssModel
     */
    protected function setBackgroundImageCss()
    {
        if ($this->get('imageInstanceId') === null) {
            return $this;
        }

        $imageInstance = ImageInstanceModel::model()
            ->byId($this->get('imageInstanceId'))
            ->withRelations(['viewFileModel'])
            ->find();
        if ($imageInstance === null) {
            return $this;
        }

        $this->css .= sprintf(
            'background-image:url(%s);',
            $imageInstance->get('viewFileModel')->getUrl()
        );

        if ($this->get('isBackgroundCover') === true) {
            $this->css .= 'background-size:cover;';
            return $this;
        }

        $this->css .= sprintf(
            'background-position:%s;',
            $this->_getBackgroundPosition()
        );

        $this->css .= sprintf(
            'background-repeat:%s;',
            $this->_getBackgroundRepeat()
        );

        return $this;
    }

    /**
     * Gets background position
     *
     * @return string
     */
    private function _getBackgroundPosition()
    {
        $backgroundPosition = $this->get('backgroundPosition');
        $list = $this->getBackgroundPositionList();
        if (array_key_exists($backgroundPosition, $list) === true) {
            return $list[$backgroundPosition];
        }

        return $list[self::BACKGROUND_POSITION_LEFT_TOP];
    }

    /**
     * Gets background repeat
     *
     * @return string
     */
    private function _getBackgroundRepeat()
    {
        $backgroundRepeat = $this->get('backgroundRepeat');
        $list = $this->getBackgroundRepeatList();
        if (array_key_exists($backgroundRepeat, $list) === true) {
            return $list[$backgroundRepeat];
        }

        return $list[self::BACKGROUND_REPEAT_NONE];
    }

    /**
     * Sets BorderRadius CSS
     *
     * @return AbstractDesignBlockCssModel
     */
    protected function setBorderRadiusCss()
    {
        $borderTopLeft = $this->get('borderTopLeftRadius');
        $borderTopRight = $this->get('borderTopRightRadius');
        $borderBottomRight = $this->get('borderBottomRightRadius');
        $borderBottomLeft = $this->get('borderBottomLeftRadius');
        if ($borderTopLeft === 0
            && $borderTopRight === 0
            && $borderBottomRight === 0
            && $borderBottomLeft === 0
        ) {
            return $this;
        }

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

        $this->css .= sprintf(
            '-webkit-border-radius:%s %s %s %s;',
            $borderTopLeft,
            $borderTopRight,
            $borderBottomRight,
            $borderBottomLeft
        );
        $this->css .= sprintf(
            '-moz-border-radius:%s %s %s %s;',
            $borderTopLeft,
            $borderTopRight,
            $borderBottomRight,
            $borderBottomLeft
        );
        $this->css .= sprintf(
            'border-radius:%s %s %s %s;',
            $borderTopLeft,
            $borderTopRight,
            $borderBottomRight,
            $borderBottomLeft
        );

        return $this;
    }

    /**
     * Sets border CSS
     *
     * @return AbstractDesignBlockCssModel
     */
    protected function setBorderCss()
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

        $this->css .= sprintf(
            'border-width:%s %s %s %s;',
            $borderTopWidth,
            $borderRightWidth,
            $borderBottomWidth,
            $borderLeftWidth
        );

        $this->css .= sprintf(
            'border-style:%s;',
            $this->getBorderStyle(false)
        );
        $borderColor = $this->get('borderColor');
        if ($borderColor === '') {
            $borderColor = 'transparent';
        }

        $this->css .= sprintf(
            'border-color:%s;',
            $borderColor
        );

        return $this;
    }

    /**
     * Sets width CSS
     *
     * @return AbstractDesignBlockCssModel
     */
    protected function setWidthCss()
    {
        $width = $this->get('width');
        if ($width === 0) {
            return $this;
        }

        if ($width <= 100) {
            $width .= '%';
        }

        if ($width > 100) {
            $width .= 'px';
        }

        $this->css .= sprintf(
            'width:%s;',
            $width
        );

        return $this;
    }

    /**
     * Sets transition CSS
     *
     * @return AbstractDesignBlockCssModel
     */
    protected function setTransitionCss()
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

        $this->css .= sprintf('-webkit-transition:%s;', $transition);
        $this->css .= sprintf('-ms-transition:%s;', $transition);
        $this->css .= sprintf('-o-transition:%s;', $transition);
        $this->css .= sprintf('transition:%s;', $transition);

        return $this;
    }
}
