<?php

namespace ss\application\instances;

use ss\application\components\common\Language;
use ss\application\instances\_abstract\AbstractAjax;
use ss\controllers\site\_abstract\AbstractController;
use ss\controllers\site\CreateController;
use ss\controllers\site\HelpController;
use ss\controllers\site\IndexController;

/**
 * Class for working with Site application
 */
class Site extends AbstractAjax
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
        echo $this->_getOutput($this->_isAjax());
    }

    /**
     * Flag is ajax
     *
     * @return bool
     */
    private function _isAjax()
    {
        $requestUri = $this
            ->getSuperGlobalVariable()
            ->getServerValue('REQUEST_URI');
        $requestUri = strtolower(trim($requestUri, '/'));
        $requestParameters = explode('/', $requestUri);

        if ($requestUri === ''
            || count($requestParameters) === 0
        ) {
            return false;
        }

        if ($requestParameters[0] === self::API_PREFIX) {
            return true;
        }

        return false;
    }

    /**
     * Gets controller
     *
     * @return AbstractController
     */
    private function _getPageController()
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

    /**
     * Gets output
     *
     * @param bool $isAjax Flag of ajax request
     *
     * @return string
     */
    private function _getOutput($isAjax)
    {
        if ($isAjax === true) {
            return $this
                ->setTransactionSkipped()
                ->processAjax();
        }

        $controller = $this->_getPageController();
        return $controller->run();
    }
}
