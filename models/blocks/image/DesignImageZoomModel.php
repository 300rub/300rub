<?php

namespace testS\models\blocks\image;

use testS\models\blocks\image\_abstract\AbstractDesignImageZoomModel;
use testS\application\App;

/**
 * Model for working with table "designImageZooms"
 */
class DesignImageZoomModel extends AbstractDesignImageZoomModel
{

    /**
     * Type
     */
    const TYPE = 'image-zoom';

    /**
     * Gets design
     *
     * @param string $selector  CSS selector
     * @param string $namespace Namespace
     *
     * @return array
     */
    public function getDesign($selector, $namespace = null)
    {
        if ($namespace === null) {
            $namespace = 'designImageZoomModel';
        }

        $language = App::getInstance()->getLanguage();

        return [
            $this->get('designBlockModel')->getDesign(
                $selector,
                $namespace . '.designBlockModel',
                ['id'],
                $language->getMessage('design', 'imagesContainer')
            ),
            [
                'selector'  => $selector,
                'id'        => App::getInstance()
                ->getView()
                ->generateCssId($selector, self::TYPE),
                'type'      => self::TYPE,
                'title'     => $language->getMessage('design', 'image'),
                'namespace' => $namespace,
                'labels'    => self::getLabels(),
                'values' => $this->get(
                    null,
                    ['id', 'designBlockId', 'designBlockModel']
                )
            ]
        ];
    }
}
