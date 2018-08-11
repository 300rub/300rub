<?php

namespace ss\application\instances;

use ss\application\components\Language;
use ss\application\instances\_abstract\AbstractApplication;
use ss\controllers\site\_abstract\AbstractController;
use ss\controllers\site\CreateController;
use ss\controllers\site\HelpController;
use ss\controllers\site\IndexController;

/**
 * Class for working with Site application
 */
class Site extends AbstractApplication
{

    /**
     * Prefixes
     */
    const HELP_PREFIX = 'help';
    const CREATE_PREFIX = 'create';

    /**
     * Runs application
     *
     * @return void
     */
    public function run()
    {
        $controller = $this->_getController();
        echo $controller->run();
    }

    /**
     * Gets controller
     *
     * @return AbstractController
     */
    private function _getController()
    {
        $requestUri = $this
            ->getSuperGlobalVariable()
            ->getServerValue('REQUEST_URI');

        $requestUri = trim($requestUri, '/');
        $requestParameters = explode('/', $requestUri);

        if ($requestUri === ''
            || count($requestParameters) === 0
        ) {
            $this->getLanguage()->setActiveId(
                Language::LANGUAGE_RU_ID
            );
            return new IndexController();
        }

        $this->getLanguage()->setIdByAlias(
            $requestParameters[0]
        );

        if (count($requestParameters) === 1) {
            return new IndexController();
        }

        $prefix = strtolower($requestParameters[1]);

        if ($prefix === self::HELP_PREFIX) {
            return new HelpController();
        }

        if ($prefix === self::CREATE_PREFIX) {
            return new CreateController();
        }

        return new IndexController();
    }
}
