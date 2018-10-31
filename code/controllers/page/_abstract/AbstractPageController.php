<?php

namespace ss\controllers\page\_abstract;

use ss\application\components\file\Css;
use ss\application\components\file\Html;
use ss\application\components\file\Js;
use ss\application\components\file\Less;
use ss\controllers\_abstract\AbstractController;

/**
 * Abstract Page Controller
 */
abstract class AbstractPageController extends AbstractController
{

    /**
     * Is minimized
     *
     * @return bool
     */
    private function _isMinimized()
    {
        return APP_ENV !== ENV_DEV;
    }

    /**
     * Gets CSS
     *
     * @return array
     */
    protected function getCss()
    {
        $type = Css::TYPE_COMMON;
        if ($this->isUser() === true) {
            $type = Css::TYPE_ADMIN;
        }

        $css = new Css($type);
        $css
            ->setVersion($this->_getVersion())
            ->setHasMinimized($this->_isMinimized());

        return $css->getCssList();
    }

    /**
     * Gets JS
     *
     * @return array
     */
    protected function getJs()
    {
        $type = Js::TYPE_COMMON;
        if ($this->isUser() === true) {
            $type = Js::TYPE_ADMIN;
        }

        $jsFile = new Js($type);
        $jsFile
            ->setVersion($this->_getVersion())
            ->setHasMinimized($this->_isMinimized());

        return $jsFile->getJsList();
    }

    /**
     * Gets HTML
     *
     * @return string
     */
    protected function getHtml()
    {
        $type = Html::TYPE_COMMON;
        if ($this->isUser() === true) {
            $type = Html::TYPE_ADMIN;
        }

        $html = new Html($type);
        $html->setHasMinimized($this->_isMinimized());

        return $html->getHtml();
    }

    /**
     * Gets less
     *
     * @return array
     */
    protected function getLess()
    {
        if ($this->_isMinimized() === true) {
            return null;
        }

        $type = Less::TYPE_COMMON;
        if ($this->isUser() === true) {
            $type = Less::TYPE_ADMIN;
        }

        return sprintf('/dev/less.php?type=%s', $type);
    }

    /**
     * Gets release version
     *
     * @return int
     */
    private function _getVersion()
    {
        $release = CODE_ROOT . '/config/release';
        if (file_exists($release) === false) {
            return 0;
        }

        return (int)file_get_contents($release);
    }
}
