<?php

namespace ss\controllers\page\_abstract;

use ss\application\components\file\Css;
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
        $type = Less::TYPE_COMMON;
        if ($this->isUser() === true) {
            $type = Less::TYPE_ADMIN;
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

        return [];
//        $isUser = $this->isUser();
//
//        if ($this->_isMinimized() === true) {
//            $jsList = [];
//            $jsList[] = $this->_staticMap['common']['compiledJs'];
//            if ($isUser === true
//                && array_key_exists('admin', $this->_staticMap) === true
//            ) {
//                $jsList[] = $this->_staticMap['admin']['compiledJs'];
//            }
//
//            return $jsList;
//        }
//
//        $jsList = $this->_staticMap['common']['libs']['js'];
//
//        if ($isUser === true
//            && array_key_exists('admin', $this->_staticMap) === true
//        ) {
//            $jsList = array_merge(
//                $jsList,
//                $this->_staticMap['admin']['libs']['js']
//            );
//        }
//
//        $jsList = array_merge(
//            $jsList,
//            $this->_staticMap['common']['js']
//        );
//
//        if ($isUser === false
//            || array_key_exists('admin', $this->_staticMap) === false
//        ) {
//            return $jsList;
//        }
//
//        return array_merge(
//            $jsList,
//            $this->_staticMap['admin']['js']
//        );
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
