<?php

namespace ss\models\help;

use ss\models\help\_base\AbstractPageModel;

/**
 * Model for working with table "pages" (help DB)
 */
class PageModel extends AbstractPageModel
{

    /**
     * Sets content
     *
     * @return CategoryModel
     */
    public function setContent()
    {
        return $this;
    }
}
