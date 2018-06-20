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
        $config = App::getInstance()->getConfig();

        if ($this->_isMinimized() === true) {
            $cssList = [];
            $cssList[] = $config->getValue(
                ['staticMap', 'common', 'compiledCss']
            );
            if ($isUser === true) {
                $cssList[] = $config->getValue(
                    ['staticMap', 'admin', 'compiledCss']
                );
            }

            return $cssList;
        }

        $cssList = $config->getValue(
            ['staticMap', 'common', 'libs', 'css']
        );
        if ($isUser === true) {
            $cssList = array_merge(
                $cssList,
                $config->getValue(
                    ['staticMap', 'admin', 'libs', 'css']
                )
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
        $config = App::getInstance()->getConfig();

        if ($this->_isMinimized() === true) {
            $jsList = [];
            $jsList[] = $config->getValue(
                ['staticMap', 'common', 'compiledJs']
            );
            if ($isUser === true) {
                $jsList[] = $config->getValue(
                    ['staticMap', 'admin', 'compiledJs']
                );
            }

            return $jsList;
        }

        $jsList = $config->getValue(
            ['staticMap', 'common', 'libs', 'js']
        );

        if ($isUser === true) {
            $jsList = array_merge(
                $jsList,
                $config->getValue(
                    ['staticMap', 'admin', 'libs', 'js']
                )
            );
        }

        $jsList = array_merge(
            $jsList,
            $config->getValue(
                ['staticMap', 'common', 'js']
            )
        );

        if ($isUser === false) {
            return $jsList;
        }

        return array_merge(
            $jsList,
            $config->getValue(
                ['staticMap', 'admin', 'js']
            )
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

        $config = App::getInstance()->getConfig();

        $less = [];

        $less[] = $config->getValue(
            ['staticMap', 'common', 'less']
        );
        if ($this->isUser() === true) {
            $less[] = $config->getValue(
                ['staticMap', 'admin', 'less']
            );
        }

        return $less;
    }
}
