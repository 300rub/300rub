<?php

namespace ss\models\blocks\text;

use ss\models\blocks\text\_base\AbstractDesignTextModel;
use ss\application\App;

/**
 * Model for working with table "designTexts"
 */
class DesignTextModel extends AbstractDesignTextModel
{

    /**
     * Type
     */
    const TYPE = 'text';

    /**
     * Default size
     */
    const DEFAULT_SIZE = 14;

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
            'id'        => App::getInstance()
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
     * Gets family
     *
     * @return string
     */
    public function getFamily()
    {
        $family = $this->get('family');
        if (array_key_exists($family, self::$familyList) === true) {
            return self::$familyList[$family];
        }

        return self::$familyList[self::FAMILY_OPEN_SANS];
    }

    /**
     * Gets text align
     *
     * @return string
     */
    public function getAlign()
    {
        $align = $this->get('align');
        if (array_key_exists($align, self::$textAlignList) === true) {
            return self::$textAlignList[$align];
        }

        return self::$textAlignList[self::TEXT_ALIGN_LEFT];
    }

    /**
     * Gets text decoration
     *
     * @param bool $isHover Hover flag
     *
     * @return string
     */
    public function getDecoration($isHover)
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
    public function getTransform($isHover)
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
}
