<?php

namespace ss\controllers\site\_abstract;

use ss\application\App;
use ss\controllers\_abstract\AbstractDataController;

/**
 * Abstract Controller for all site controllers
 */
abstract class AbstractController extends AbstractDataController
{

    /**
     * Static map
     *
     * @var array
     */
    private $_staticMap = [];

    /**
     * Sets static map
     *
     * @return void
     */
    private function _setStaticMap()
    {
        $this->_staticMap = include CODE_ROOT .
            '/config/other/staticSite.php';
    }

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
        $this->_setStaticMap();

        $layoutData = [];
        $layoutData['content'] = $content;
        $layoutData['title'] = $title;
        $layoutData['keywords'] = $keywords;
        $layoutData['description'] = $description;
        $layoutData['css'] = $this->_getCss();
        $layoutData['js'] = $this->_getJs();
        $layoutData['less'] = $this->_getLess();
        $layoutData['version'] = $this->_getVersion();
        $layoutData['language']
            = App::getInstance()->getLanguage()->getActiveId();
        $layoutData['errorMessages']
            = App::getInstance()->getValidator()->getErrorMessages();
        $layoutData['templates'] = $this->getContentFromTemplate(
            'site/templates',
            [
                'isUser' => $this->_isUser()
            ]
        );

        return $this->getContentFromTemplate('site/layout', $layoutData);
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
     * If is user
     *
     * @return bool
     */
    private function _isUser()
    {
        return false;
    }

    /**
     * Gets CSS
     *
     * @return array
     */
    private function _getCss()
    {
        $isUser = $this->_isUser();

        if ($this->_isMinimized() === true) {
            $cssList = [];
            $cssList[] = $this->_staticMap['common']['compiledCss'];
            if ($isUser === true) {
                $cssList[] = $this->_staticMap['admin']['compiledCss'];
            }

            return $cssList;
        }

        $cssList = $this->_staticMap['common']['libs']['css'];
        if ($isUser === true) {
            $cssList = array_merge(
                $cssList,
                $this->_staticMap['admin']['libs']['css']
            );
        }

        return $cssList;
    }

    /**
     * Gets JS
     *
     * @return array
     */
    private function _getJs()
    {
        $isUser = $this->_isUser();

        if ($this->_isMinimized() === true) {
            $jsList = [];
            $jsList[] = $this->_staticMap['common']['compiledJs'];
            if ($isUser === true) {
                $jsList[] = $this->_staticMap['admin']['compiledJs'];
            }

            return $jsList;
        }

        $jsList = $this->_staticMap['common']['libs']['js'];

        if ($isUser === true) {
            $jsList = array_merge(
                $jsList,
                $this->_staticMap['admin']['libs']['js']
            );
        }

        $jsList = array_merge(
            $jsList,
            $this->_staticMap['common']['js']
        );

        if ($isUser === false) {
            return $jsList;
        }

        return array_merge(
            $jsList,
            $this->_staticMap['admin']['js']
        );
    }

    /**
     * Gets less
     *
     * @return array
     */
    private function _getLess()
    {
        if ($this->_isMinimized() === true) {
            return [];
        }

        $less = [];

        $less[] = $this->_staticMap['common']['less'];
        if ($this->_isUser() === true) {
            $less[] = $this->_staticMap['admin']['less'];
        }

        return $less;
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
