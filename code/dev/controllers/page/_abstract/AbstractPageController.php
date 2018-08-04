<?php

namespace ss\controllers\page\_abstract;

use ss\controllers\_abstract\AbstractController;

/**
 * Abstract Page Controller
 */
abstract class AbstractPageController extends AbstractController
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
     * @param string $name Static map name
     */
    protected function setStaticMap($name)
    {
        $path = sprintf(
            '%s/config/other/%s.php',
            CODE_ROOT,
            $name
        );
        
        $this->_staticMap = include $path;
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
    protected function getCss()
    {
        $isUser = $this->isUser();

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
    protected function getJs()
    {
        $isUser = $this->isUser();

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
    protected function getLess()
    {
        if ($this->_isMinimized() === true) {
            return [];
        }

        $less = [];

        $less[] = $this->_staticMap['common']['less'];
        if ($this->isUser() === true) {
            $less[] = $this->_staticMap['admin']['less'];
        }

        return $less;
    }

    /**
     * Gets release version
     *
     * @return int
     */
    protected function getVersion()
    {
        $release = CODE_ROOT . '/config/release';
        if (file_exists($release) === false) {
            return 0;
        }

        return (int)file_get_contents($release);
    }
}
