<?php

namespace ss\tests\unit\models\blocks\siteMap\_base\AbstractSiteMapModel;

use ss\models\blocks\siteMap\SiteMapModel;
use ss\tests\unit\models\_abstract\_base\AbstractDbModelTest;

/**
 * Tests for the model SiteMapModel
 */
class AbstractSiteMapModelDbTest extends AbstractDbModelTest
{

    /**
     * Gets model name
     *
     * @return SiteMapModel
     */
    protected function getNewModel()
    {
        return new SiteMapModel();
    }
}
