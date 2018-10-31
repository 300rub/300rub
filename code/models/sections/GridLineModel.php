<?php

namespace ss\models\sections;

use ss\application\App;
use ss\models\sections\_base\AbstractGridLineModel;

/**
 * Model for working with table "gridLines"
 */
class GridLineModel extends AbstractGridLineModel
{

    /**
     * Adds section ID to SQL request
     *
     * @param int $sectionId Section ID
     *
     * @return GridLineModel
     */
    public function bySectionId($sectionId = null)
    {
        $sectionId = (int)$sectionId;

        if ($sectionId > 0) {
            $this->getTable()
                ->addWhere('sectionId = :sectionId')
                ->addParameter('sectionId', $sectionId);
        }

        return $this;
    }

    /**
     * Generates CSS
     *
     * @return array
     */
    public function generateCss()
    {
        $view = App::getInstance()->getView();

        $css = [];

        $css = array_merge(
            $css,
            $view->generateCss(
                $this->get('outsideDesignModel'),
                sprintf('.line-%s', $this->getId())
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $this->get('insideDesignModel'),
                sprintf('.line-%s .line-container', $this->getId())
            )
        );

        return $css;
    }

    /**
     * Gets new model
     *
     * @return GridLineModel
     */
    public static function model()
    {
        return new self;
    }
}
