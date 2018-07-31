<?php

namespace ss\tests\phpunit\models\blocks\siteMap\_base\AbstractSiteMapModel;

use ss\models\blocks\siteMap\SiteMapModel;
use ss\tests\phpunit\models\_abstract\_base\AbstractDbModelTest;

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
