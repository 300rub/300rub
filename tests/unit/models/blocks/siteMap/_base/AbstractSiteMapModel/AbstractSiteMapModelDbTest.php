<?php

namespace testS\tests\unit\models\blocks\siteMap\_base\AbstractSiteMapModel;

use testS\models\blocks\siteMap\SiteMapModel;
use testS\tests\unit\models\_abstract\_base\AbstractDbModelTest;

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
