<?php

namespace testS\models\sections;

use testS\application\App;
use testS\models\sections\_abstract\AbstractGridLineModel;

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
        if ($sectionId) {
            $this->getDb()
                ->addWhere("sectionId = :sectionId")
                ->addParameter("sectionId", $sectionId);
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
                $this->get("outsideDesignModel"),
                sprintf(".line-%s", $this->getId())
            )
        );

        $css = array_merge(
            $css,
            $view->generateCss(
                $this->get("insideDesignModel"),
                sprintf(".line-%s .line-container", $this->getId())
            )
        );

        return $css;
    }
}