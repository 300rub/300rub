<?php

namespace ss\models\blocks\image;

use ss\models\blocks\image\_base\AbstractDesignImageZoomModel;
use ss\application\App;

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
        $cssContainerId = App::getInstance()
            ->getView()
            ->generateCssContainerId($selector, self::TYPE);

        return [
            $this->get('designBlockModel')->getDesign(
                $selector,
                $namespace . '.designBlockModel',
                ['id'],
                $language->getMessage('design', 'imagesContainer')
            ),
            [
                'selector'  => $selector,
                'cssContainerId'     => $cssContainerId,
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
