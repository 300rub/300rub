<?php

namespace ss\controllers\page\_abstract;

use ss\application\App;
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
     *
     * @return void
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
            if ($isUser === true
                && array_key_exists('admin', $this->_staticMap) === true
            ) {
                $cssList[] = $this->_staticMap['admin']['compiledCss'];
            }

            return $cssList;
        }

        $cssList = $this->_staticMap['common']['libs']['css'];
        if ($isUser === true
            && array_key_exists('admin', $this->_staticMap) === true
        ) {
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
//        $staticFile = App::getInstance()->getStaticFile();
//
//
//        $path = CODE_ROOT . '/public/static/common';
//        $main = '/static/common/core/ss/js.js';
//
//        $directory = new \RecursiveDirectoryIterator($path);
//        $iterator = new \RecursiveIteratorIterator($directory);
//
//        $files = [$main];
//        foreach ($iterator as $info) {
//            $path = str_replace(CODE_ROOT . '/public', '', $info->getPathname());
//
//            if (strpos($path, '.js') === false
//                || $path === $main
//            ) {
//                continue;
//            }
//
//            $files[] = $path;
//        }
//
//        echo "<pre>";
//        var_dump($files);
//
//        exit();

        $isUser = $this->isUser();

        if ($this->_isMinimized() === true) {
            $jsList = [];
            $jsList[] = $this->_staticMap['common']['compiledJs'];
            if ($isUser === true
                && array_key_exists('admin', $this->_staticMap) === true
            ) {
                $jsList[] = $this->_staticMap['admin']['compiledJs'];
            }

            return $jsList;
        }

        $jsList = $this->_staticMap['common']['libs']['js'];

        if ($isUser === true
            && array_key_exists('admin', $this->_staticMap) === true
        ) {
            $jsList = array_merge(
                $jsList,
                $this->_staticMap['admin']['libs']['js']
            );
        }

        $jsList = array_merge(
            $jsList,
            $this->_staticMap['common']['js']
        );

        if ($isUser === false
            || array_key_exists('admin', $this->_staticMap) === false
        ) {
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

        $lessCommon = $this->_staticMap['common']['less'];
        if ($lessCommon !== '') {
            $less[] = $lessCommon;
        }

        if ($this->isUser() === true
            && array_key_exists('admin', $this->_staticMap) === true
        ) {
            $lessAdmin = $this->_staticMap['admin']['less'];
            if ($lessAdmin !== '') {
                $less[] = $lessAdmin;
            }
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
