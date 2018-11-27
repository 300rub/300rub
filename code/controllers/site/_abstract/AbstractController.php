<?php

namespace ss\controllers\site\_abstract;

use ss\application\App;
use ss\application\components\file\Css;
use ss\application\components\file\Html;
use ss\application\components\file\Js;
use ss\application\components\file\Less;
use ss\controllers\_abstract\AbstractDataController;

/**
 * Abstract Controller for all site controllers
 */
abstract class AbstractController extends AbstractDataController
{

    /**
     * Gets site page
     *
     * @param string $content     Content
     * @param string $title       Meta title
     * @param string $keywords    Meta keywords
     * @param string $description Meta description
     *
     * @return string
     */
    protected function getPageHtml($content, $title, $keywords, $description)
    {
        return $this->render(
            'layout/site',
            [
                'icon'        => '/static/common/core/img/favicon.ico',
                'content'     => $content,
                'title'       => $title . $_SERVER['SERVER_ADDR'],
                'keywords'    => $keywords,
                'description' => $description,
                'css'         => $this->_getCss(),
                'js'          => $this->_getJs(),
                'html'        => $this->_getHtml(),
                'less'        => $this->_getLess(),
                'initJs'      => $this->_getInitJs(),
            ]
        );
    }

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
    private function _getCss()
    {
        $css = new Css(Css::TYPE_SITE);
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
    private function _getJs()
    {
        $jsFile = new Js(Js::TYPE_SITE);
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
    private function _getHtml()
    {
        $html = new Html(Html::TYPE_SITE);
        $html->setHasMinimized($this->_isMinimized());

        return $html->getHtml();
    }

    /**
     * Gets less
     *
     * @return array
     */
    private function _getLess()
    {
        if ($this->_isMinimized() === true) {
            return null;
        }

        return sprintf('/dev/less.php?type=%s', Less::TYPE_SITE);
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

    /**
     * Gets init JS
     *
     * @return string
     */
    private function _getInitJs()
    {
        return $this->render(
            'layout/js/site',
            [
                'language'
                    => App::getInstance()->getLanguage()->getActiveId(),
                'errorMessages'
                    => App::getInstance()->getValidator()->getErrorMessages(),
            ]
        );
    }
}
