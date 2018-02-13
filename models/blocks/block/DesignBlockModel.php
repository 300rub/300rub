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
            'id'        => App::getInstance()
                ->getView()
                ->generateCssId($selector, self::TYPE),
            'type'      => self::TYPE,
            'title'     => $title,
            'namespace' => $namespace,
            'labels'    => self::getLabels(),
            'values'    => $this->get(null, $except),
        ];
    }
}
